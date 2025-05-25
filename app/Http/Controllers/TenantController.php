<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
	public function __construct()
	{
		$this->middleware('permission:view tenants')->only(['index', 'show']);
		$this->middleware('permission:create tenants')->only(['create', 'store']);
		$this->middleware('permission:edit tenants')->only(['edit', 'update']);
		$this->middleware('permission:delete tenants')->only(['destroy']);
	}

	public function index(Request $request)
	{
		$query = Tenant::query()->with('unit');

		if ($request->filled('search')) {
			$search = $request->search;

			$query->where(function ($q) use ($search) {
				$q->where('name', 'like', "%$search%")
					->orWhere('id_number', 'like', "%$search%")
					->orWhere('phone', 'like', "%$search%")
					->orWhereHas('unit', fn($q2) => $q2->where('unit_number', 'like', "%$search%"));
			});
		}

		$tenants = $query->latest()->paginate(15);

		return view('admin.tenants.index', compact('tenants'));
	}

	public function create()
	{
		$buildings = Building::select('id', 'name')->get();
		return view('admin.tenants.create', compact('buildings'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'tenant_status' => 'required|string|in:active,late_payer,has_debt,absent,abroad,legal_issue',
			'name' => 'required|string|max:100',
			'phone' => 'nullable|string|max:20',
			'id_number' => 'nullable|string|max:50',
			'email' => 'nullable|email|max:100',
			'notes' => 'nullable|string|max:500',
			'debt' => 'nullable|numeric|min:0',
		]);

		$tenant = Tenant::create([
			'tenant_status' => $request->tenant_status,
			'name' => $request->name,
			'phone' => $request->phone,
			'id_number' => $request->id_number,
			'email' => $request->email,
			'notes' => $request->notes,
			'debt' => $request->debt ?? 0,
		]);

		return redirect()->route('admin.tenants.index')->with('success', 'تم إضافة المستأجر بنجاح');
	}

	public function edit(Tenant $tenant)
	{
		$buildings = Building::select('id', 'name')->get();
		$buildingId = optional($tenant->unit)->building_id;
		$units = $buildingId
			? Unit::where('building_id', $buildingId)->select('id', 'unit_number')->get()
			: collect();

		return view('admin.tenants.edit', compact('tenant', 'buildings', 'units'));
	}

	public function update(Request $request, Tenant $tenant)
	{
		$request->validate([
			'tenant_status' => 'required|string|in:active,late_payer,has_debt,absent,abroad,legal_issue',
			'unit_id' => 'nullable|exists:units,id',
			'name' => 'required|string|max:100',
			'phone' => 'nullable|string|max:20',
			'id_number' => 'nullable|string|max:50',
			'email' => 'nullable|email|max:100',
			'move_in_date' => 'nullable|date',
			'notes' => 'nullable|string|max:500',
			'debt' => 'nullable|numeric|min:0',
		]);

		if ($tenant->unit_id && $tenant->unit_id != $request->unit_id) {
			Unit::where('id', $tenant->unit_id)->update(['status' => 'available']);
		}

		$tenant->update([
			'tenant_status' => $request->tenant_status,
			'unit_id' => $request->tenant_status === 'active' ? $request->unit_id : null,
			'name' => $request->name,
			'phone' => $request->phone,
			'id_number' => $request->id_number,
			'email' => $request->email,
			'move_in_date' => $request->move_in_date,
			'notes' => $request->notes,
			'debt' => $request->debt ?? 0,
		]);

		if ($request->tenant_status === 'active' && $request->filled('unit_id')) {
			Unit::where('id', $request->unit_id)->update(['status' => 'occupied']);
		}

		return redirect()->route('admin.tenants.index')->with('success', 'تم تعديل بيانات المستأجر');
	}
	
public function search(Request $request)
{
    $q = $request->input('q');

    if (!$q) {
        return response()->json([]);
    }

    $searchTerm = strtolower(trim($q));
    $digitsOnly = preg_replace('/[^0-9]/', '', $q);

    // احتمال يكون كتب رقم محلي: 050xxxxxxx → نحوله لـ 9715xxxxxxx
    $normalized = $digitsOnly;
    if (preg_match('/^05[0-9]{8}$/', $digitsOnly)) {
        $normalized = '971' . substr($digitsOnly, 1);
    }

    $results = \App\Models\Tenant::query()
        ->where(function ($query) use ($searchTerm, $digitsOnly, $normalized) {
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])
                  ->orWhereRaw('LOWER(id_number) LIKE ?', ["%{$searchTerm}%"]);

            if (!empty($digitsOnly)) {
                // تنظيف الرقم في قاعدة البيانات
                $cleanPhone = "
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(phone, '+', ''),
                                '-', ''),
                            ' ', ''),
                        '(', ''),
                    ')', '')
                ";

                $query->orWhereRaw("{$cleanPhone} LIKE ?", ["%{$digitsOnly}%"]);
                $query->orWhereRaw("{$cleanPhone} LIKE ?", ["%{$normalized}%"]);
                $query->orWhereRaw("{$cleanPhone} LIKE ?", ["%{$searchTerm}%"]);
            }
			if (preg_match('/^05[0-9]{2,}$/', $digitsOnly)) {
              $partialNormalized = '971' . substr($digitsOnly, 1); // نحوله حتى لو ناقص
              $query->orWhereRaw("{$cleanPhone} LIKE ?", ["%{$partialNormalized}%"]);
            }
        })
        ->select('id', 'name', 'phone', 'id_number')
        ->limit(10)
        ->get();

    return response()->json($results);
}



	public function destroy(Tenant $tenant)
	{
		if ($tenant->unit_id) {
			Unit::where('id', $tenant->unit_id)->update(['status' => 'available']);
		}

		$tenant->delete();
		return redirect()->route('admin.tenants.index')->with('success', 'تم حذف المستأجر');
	}

	public function show(Tenant $tenant)
	{
		if (request()->ajax()) {
			return view('admin.tenants.show', compact('tenant'));
		}

		return view('admin.tenants.show', compact('tenant'));
	}

	public function linkUser(Tenant $tenant)
	{
		$users = User::whereDoesntHave('tenant')->where('role', 'tenant')->get();
		return view('admin.tenants.link', compact('tenant', 'users'));
	}

	public function getTenantData($id)
	{
		$tenant = Tenant::select('id', 'name', 'id_number', 'phone', 'email')->findOrFail($id);
		return response()->json($tenant);
	}

	public function attachUser(Request $request, Tenant $tenant)
	{
		$request->validate([
			'user_id' => 'required|exists:users,id',
		]);

		$tenant->user_id = $request->user_id;
		$tenant->save();

		return redirect()->route('admin.tenants.index')->with('success', 'تم ربط المستأجر بالمستخدم بنجاح');
	}

	public function createUser(Request $request, Tenant $tenant)
	{
		$request->validate([
			'email' => 'required|email|unique:users,email',
			'password' => 'required|string|min:6',
		]);

		$user = User::create([
			'name' => $tenant->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'role' => 'tenant',
		]);

		$tenant->user_id = $user->id;
		$tenant->save();

		return redirect()->route('admin.tenants.index')->with('success', 'تم إنشاء حساب وربطه بالمستأجر بنجاح');
	}

	public function unlinkUnit(Tenant $tenant)
	{
		if ($tenant->unit_id) {
			Unit::where('id', $tenant->unit_id)->update(['status' => 'available']);
		}

		$tenant->unit_id = null;
		$tenant->save();

		return redirect()->route('admin.tenants.index')->with('success', 'تم إلغاء ربط الوحدة بنجاح');
	}
}
