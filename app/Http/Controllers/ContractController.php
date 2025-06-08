<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Building;
use App\Models\ContractType;
use App\Enums\UnitStatus;
use App\Enums\UnitType;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view contracts')->only(['index', 'show']);
        $this->middleware('permission:create contracts')->only(['create', 'store']);
        $this->middleware('permission:edit contracts')->only(['edit', 'update']);
        $this->middleware('permission:delete contracts')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Contract::with(['tenant', 'unit']);

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('contract_number', 'like', "%$search%")
                    ->orWhereHas('tenant', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%")
                            ->orWhere('id_number', 'like', "%$search%");
                    })
                    ->orWhereHas('unit', function ($q3) use ($search) {
                        $q3->where('unit_number', 'like', "%$search%");
                    });
            });
        }

        $contracts = $query->latest()->paginate(10);
        $activeContractsCount = Contract::where('end_date', '>', now()->addDays(30))->count();
        $expiringSoonCount = Contract::whereBetween('end_date', [now(), now()->addDays(30)])->count();
        $contractTypes = ContractType::orderBy('updated_at', 'desc')->get();

        return view('admin.contracts.index', compact(
            'contracts',
            'activeContractsCount',
            'expiringSoonCount',
            'contractTypes'
        ));
    }

    public function create()
    {
        $tenants = Tenant::all();
        $units = Unit::all();
        $buildings = Building::all();

        return view('admin.contracts.create', compact('tenants', 'units', 'buildings'));
    }

   public function store(Request $request)
{
    $request->validate([
        'tenant_id'     => 'required|exists:tenants,id',
        'unit_id'       => 'required|exists:units,id',
        'start_date'    => 'required|date|before:end_date',
        'end_date'      => 'required|date|after:start_date',
        'rent_amount'   => 'required|numeric',
        'notes'         => 'nullable|string',
        'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $tenant = Tenant::findOrFail($request->tenant_id);
    $unit = Unit::with('contracts', 'building')->findOrFail($request->unit_id);

    if (
        $tenant->family_type === 'individual' &&
        $unit->building->families_only
    ) {
        return back()->withErrors(['tenant_id' => 'هذا المبنى مخصص للعائلات فقط ولا يمكن تسجيل عقد لفرد.'])->withInput();
    }

    // 🛑 منع توقيع عقد جديد لو فيه أي عقد غير ملغي
    $hasNonTerminatedContract = $unit->contracts()
        ->where('status', '!=', 'terminated')
        ->exists();

    if ($hasNonTerminatedContract) {
        return back()->withErrors([
            'unit_id' => 'لا يمكن إنشاء عقد جديد لهذه الوحدة إلا بعد إنهاء العقد السابق يدوياً.',
        ])->withInput();
    }

    // ✅ تجهيز البيانات
    $data = $request->only([
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'rent_amount',
        'notes',
    ]);

    $data['contract_number'] = 'C-' . str_pad(Contract::max('id') + 1, 6, '0', STR_PAD_LEFT);
    $data['status'] = 'active';

    if ($request->hasFile('contract_file')) {
        $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
    }

    // ✅ إنشاء العقد
    $contract = Contract::create($data);

    // ✅ تحديث حالة الغرفة إلى مشغولة
    $contract->unit->update(['status' => UnitStatus::OCCUPIED->value]);

    // ✅ البحث عن حجز مؤكد وتحديثه
    $booking = RoomBooking::where('unit_id', $contract->unit_id)
        ->where('status', 'confirmed')
        ->latest()
        ->first();

    if ($booking) {
        $booking->status = 'completed';
        $booking->expires_at = now();
        $booking->save();

        // ✅ ربط العقد بالحجز
        $contract->update(['room_booking_id' => $booking->id]);
    }

    // ✅ إلغاء أي حجوزات أخرى فعالة على نفس الوحدة (لو موجودة)
    RoomBooking::where('unit_id', $contract->unit_id)
        ->whereIn('status', ['tentative', 'confirmed']) // لو في غيره
        ->where('id', '!=', $booking?->id)
        ->update(['status' => 'cancelled_due_to_rent']);

    return redirect()->route('admin.contracts.index')
        ->with('success', __('messages.contract_created_successfully'));
}


    public function show(Contract $contract)
    {
        $contract->load(['tenant', 'unit']);
        return view('admin.contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $tenants = Tenant::all();
        $units = Unit::where('building_id', $contract->unit->building_id ?? null)->get();
        $buildings = Building::all();

        return view('admin.contracts.edit', compact('contract', 'tenants', 'units', 'buildings'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'tenant_id'     => 'required|exists:tenants,id',
            'unit_id'       => 'required|exists:units,id',
            'start_date'    => 'required|date|before:end_date',
            'end_date'      => 'required|date|after:start_date',
            'rent_amount'   => 'required|numeric',
            'notes'         => 'nullable|string',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status'        => 'nullable|in:active,terminated,ended',
        ]);

        // 🛑 منع ربط وحدة بعقد تاني غير مفسوخ
        if ($contract->unit_id != $request->unit_id) {
            $hasOtherContract = Contract::where('unit_id', $request->unit_id)
                ->where('id', '!=', $contract->id)
                ->where('status', '!=', 'terminated')
                ->exists();

            if ($hasOtherContract) {
                return back()->withErrors([
                    'unit_id' => 'لا يمكن ربط هذه الوحدة لأنها مرتبطة بعقد آخر غير ملغي.',
                ])->withInput();
            }
        }

        // تجهيز البيانات
        $data = $request->only([
            'tenant_id',
            'unit_id',
            'start_date',
            'end_date',
            'rent_amount',
            'notes',
            'status',
        ]);

        // رفع ملف جديد لو تم تغييره
        if ($request->hasFile('contract_file')) {
            if ($contract->contract_file) {
                Storage::disk('public')->delete($contract->contract_file);
            }
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }

        // ✅ تحديث العقد
        $contract->update($data);

        // ✅ تحديث حالة الغرفة بناءً على حالة العقد الجديدة
        if ($contract->status === 'terminated') {
            $contract->unit()->update(['status' => UnitStatus::AVAILABLE->value]);
        } elseif (now()->greaterThan(Carbon::parse($contract->end_date))) {
            $contract->update(['status' => 'ended']);
            $contract->unit()->update(['status' => UnitStatus::EXPIRED_CONTRACT->value]);
        } else {
            $contract->unit()->update(['status' => UnitStatus::OCCUPIED->value]);
        }

        return redirect()->route('admin.contracts.index')
            ->with('success', __('messages.contract_updated_successfully'));
    }



    public function destroy(Contract $contract)
    {
        // 🛑 ممنوع حذف عقد غير مفسوخ
        if ($contract->status !== 'terminated') {
            return back()->withErrors([
                'contract' => '❌ لا يمكن حذف هذا العقد لأنه لم يتم فسخه بعد. يُرجى أولاً إنهاء العقد يدويًا من خلال "فسخ العقد".',
            ]);
        }

        // 🛡️ التحقق من صلاحية Role "Admin's"
        if (!auth()->user()->hasRole("Admin's")) {
            return back()->withErrors([
                'contract' => '❌ ليس لديك الصلاحية لحذف العقود. مسموح فقط لمجموعة Admin\'s.',
            ]);
        }

        // 🗑️ حذف الملف إن وُجد
        if ($contract->contract_file) {
            Storage::disk('public')->delete($contract->contract_file);
        }

        // 🧹 حذف العقد
        $contract->forceDelete();

        return redirect()->route('admin.contracts.index')
            ->with('success', __('messages.contract_deleted_successfully'));
    }


    public function end(Contract $contract)
    {
        $contract->update([
            'end_date' => now()->timezone('Asia/Dubai'),
            'status'   => 'terminated',
        ]);

        // ✅ بما أن العقد اتفسخ يدويًا، نرجّع الغرفة متاحة فورًا
        $contract->unit()->update([
            'status' => UnitStatus::AVAILABLE->value,
        ]);

        return back()->with('success', __('messages.contract_ended_successfully'));
    }


    public function getUnitsByBuilding($buildingId)
    {
        return Unit::where('building_id', $buildingId)
            ->select('id', 'unit_number')
            ->get();
    }

    public function toggle($key)
    {
        $contractType = ContractType::where('key', $key)->firstOrFail();
        $contractType->is_active = !$contractType->is_active;
        $contractType->save();

        return redirect()->back()->with('success', __('messages.updated_successfully'));
    }

    public function getAvailableUnits(Building $building)
    {
        return $building->units()
            ->where('status', 'available')
            ->select('id', 'unit_number')
            ->get();
    }

    public function print($id)
    {
        $contract = Contract::with('tenant', 'unit.building')->findOrFail($id);
        return view('admin.contracts.print', compact('contract'));
    }
}
