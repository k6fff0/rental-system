<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use App\Models\Building;
use App\Enums\UnitType;
use App\Enums\UnitStatus;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewTenantNotification;
use Illuminate\Pagination\LengthAwarePaginator;
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
		$query = Tenant::with(['contracts.unit']);

		if ($request->filled('search')) {
			$search = $request->search;

			$query->where(function ($q) use ($search) {
				$q->where('name', 'like', "%$search%")
					->orWhere('id_number', 'like', "%$search%")
					->orWhere('phone', 'like', "%$search%")
					->orWhereHas('contracts', function ($q3) use ($search) {
						$q3->whereHas('unit', function ($q4) use ($search) {
							$q4->where('unit_number', 'like', "%$search%");
						});
					});
			});
		}

		// جلب كل المستأجرين مع العقود
		$tenants = $query->get();

		// ترتيبهم حسب أحدث نشاط
		$tenants = $tenants->sortByDesc(function ($tenant) {
			$latestContract = $tenant->contracts->sortByDesc('updated_at')->first();
			$latestActivity = max(
				$tenant->updated_at->timestamp,
				optional($latestContract?->updated_at)->timestamp ?? 0
			);
			return $latestActivity;
		});

		// تحويل إلى pagination يدويًا
		$perPage = 15;
		$page = request()->get('page', 1);
		$items = $tenants->values();

		$paginated = new LengthAwarePaginator(
			$items->forPage($page, $perPage),
			$items->count(),
			$perPage,
			$page,
			['path' => request()->url(), 'query' => request()->query()]
		);

		return view('admin.tenants.index', [
			'tenants' => $paginated
		]);
	}



	public function create()
	{
		$buildings = Building::select('id', 'name')->get();
		return view('admin.tenants.create', compact('buildings'));
	}


	//---------------------------------------------------------------------------------------------------------

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:100',
			'phone' => ['nullable', 'string', 'regex:/^\+\d{8,15}$/'],
			'phone_secondary' => ['nullable', 'string', 'regex:/^\+?\d{6,15}$/'],
			'id_number' => 'nullable|digits:15|unique:tenants,id_number',
			'family_type' => 'required|in:individual,family',
			'email' => 'nullable|email|max:100',
			'notes' => 'nullable|string|max:500',
			'debt' => 'nullable|numeric|min:0',
			'id_front' => 'nullable|image|mimes:jpg,jpeg,png|max:30720',
			'id_back'  => 'nullable|image|mimes:jpg,jpeg,png|max:30720',
		]);

		// تحقق من خيار واتساب
		$isWhatsapp = $request->has('is_whatsapp');

		// رفع الصور
		$idFrontPath = $request->hasFile('id_front')
			? $request->file('id_front')->store('tenant_ids', 'public')
			: null;

		$idBackPath = $request->hasFile('id_back')
			? $request->file('id_back')->store('tenant_ids', 'public')
			: null;

		// إنشاء المستأجر
		$tenant = Tenant::create([
			'tenant_status' => 'active',
			'name' => $request->name,
			'phone' => $request->phone,
			'phone_secondary' => $request->phone_secondary,
			'is_whatsapp' => $isWhatsapp,
			'id_number' => $request->id_number,
			'family_type' => $request->family_type,
			'email' => $request->email,
			'notes' => $request->notes,
			'debt' => $request->debt ?? 0,
			'id_front' => $idFrontPath,
			'id_back' => $idBackPath,
		]);

		// إشعار للمستخدمين بصلاحية تنبيه
		$notifiables = User::permission('notify.tenants.create')->get();
		Notification::send($notifiables, new NewTenantNotification($tenant->name));

		log_action('👤 تم إضافة مستأجر جديد: ' . $tenant->name . ' - رقم الهاتف: ' . $tenant->phone);

		return redirect()->route('admin.tenants.index')->with('success', 'تم إضافة المستأجر بنجاح');
	}



	//-------------------------------------------------------------------------------------------------------------------------------



	public function edit(Tenant $tenant)
	{
		$buildings = Building::select('id', 'name')->get();
		$buildingId = optional($tenant->unit)->building_id;
		$units = $buildingId
			? Unit::where('building_id', $buildingId)->select('id', 'unit_number')->get()
			: collect();

		return view('admin.tenants.edit', compact('tenant', 'buildings', 'units'));
	}


	//-------------------------------------------------------------------------------------------------------------------------------



	public function update(Request $request, Tenant $tenant)
	{
		$request->validate([
			'tenant_status' => 'required|string|in:active,late_payer,has_debt,absent,abroad,legal_issue,blocked',
			'unit_id' => 'nullable|exists:units,id',
			'name' => 'required|string|max:100',
			'phone' => ['nullable', 'string', 'regex:/^\+\d{8,15}$/'],
			'phone_secondary' => ['nullable', 'string', 'regex:/^\+?\d{6,15}$/'],
			'id_number' => ['nullable', 'string', 'max:50', Rule::unique('tenants', 'id_number')->ignore($tenant->id)],
			'family_type' => 'required|in:individual,family',
			'email' => 'nullable|email|max:100',
			'move_in_date' => 'nullable|date',
			'notes' => 'nullable|string|max:500',
			'debt' => 'nullable|numeric|min:0',
			'id_front' => 'nullable|image|mimes:jpg,jpeg,png|max:30720',
			'id_back'  => 'nullable|image|mimes:jpg,jpeg,png|max:30720',
		]);

		// 🏠 تحديث حالة الوحدة القديمة لو اتغيرت
		if ($tenant->unit_id && $tenant->unit_id != $request->unit_id) {
			Unit::where('id', $tenant->unit_id)->update(['status' => 'available']);
		}

		// 🖼️ رفع الصور الجديدة إن وجدت
		$idFrontPath = $request->hasFile('id_front')
			? $request->file('id_front')->store('tenant_ids', 'public')
			: $tenant->id_front;

		$idBackPath = $request->hasFile('id_back')
			? $request->file('id_back')->store('tenant_ids', 'public')
			: $tenant->id_back;

		$tenant->update([
			'tenant_status' => $request->tenant_status,
			'unit_id' => $request->tenant_status === 'active' ? $request->unit_id : null,
			'name' => $request->name,
			'phone' => $request->phone,
			'phone_secondary' => $request->phone_secondary,
			'is_whatsapp' => $request->has('is_whatsapp'),
			'id_number' => $request->id_number,
			'family_type' => $request->family_type,
			'email' => $request->email,
			'move_in_date' => $request->move_in_date,
			'notes' => $request->notes,
			'debt' => $request->debt ?? 0,
			'id_front' => $idFrontPath,
			'id_back' => $idBackPath,
		]);

		// 🏠 تحديث حالة الوحدة الجديدة لو تم التخصيص
		if ($request->tenant_status === 'active' && $request->filled('unit_id')) {
			Unit::where('id', $request->unit_id)->update(['status' => 'occupied']);
		}
		log_action('👤 تم تعديل بيانات المستأجر: ' . $tenant->name);

		return redirect()->route('admin.tenants.index')->with('success', 'تم تعديل بيانات المستأجر');
	}

	//-------------------------------------------------------------------------------------------------------------------------------


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
		// لو طلب AJAX (زي المودال)، رجّع البيانات بس
		if (request()->ajax()) {
			return view('admin.tenants.show', compact('tenant'));
		}

		// جلب العقود المرتبطة بالمستأجر
		$contracts = \App\Models\Contract::with('unit.building')
			->where('tenant_id', $tenant->id)
			->orderByDesc('start_date')
			->get();

		// العقد الحالي = عقد ساري الآن
		$activeContracts = $contracts->filter(function ($contract) {
			return $contract->start_date <= now() && $contract->end_date >= now();
		});

		// العقود القديمة = غير العقد الحالي
		$pastContracts = $contracts->filter(function ($contract) use ($activeContracts) {
			return !$activeContracts->contains('id', $contract->id);
		});
		return view('admin.tenants.show', compact('tenant', 'activeContracts', 'pastContracts'));
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
