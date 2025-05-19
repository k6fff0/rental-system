<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Building;
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

    public function index()
    {
        $contracts = Contract::with(['tenant', 'unit'])->latest()->paginate(10);
        $activeContractsCount = Contract::where('end_date', '>', now()->addDays(30))->count();
        $expiringSoonCount = Contract::whereBetween('end_date', [now(), now()->addDays(30)])->count();

        return view('admin.contracts.index', compact('contracts', 'activeContractsCount', 'expiringSoonCount'));
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
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'rent_amount'   => 'required|numeric',
            'notes'         => 'nullable|string',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'tenant_id',
            'unit_id',
            'start_date',
            'end_date',
            'rent_amount',
            'notes',
        ]);

        if ($request->hasFile('contract_file')) {
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }

        $contract = Contract::create($data);

        // ✅ تحديث حالة الوحدة تلقائياً
        $contract->unit->update(['status' => 'occupied']);

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
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'rent_amount'   => 'required|numeric',
            'notes'         => 'nullable|string',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'tenant_id',
            'unit_id',
            'start_date',
            'end_date',
            'rent_amount',
            'notes',
        ]);

        if ($request->hasFile('contract_file')) {
            if ($contract->contract_file) {
                Storage::disk('public')->delete($contract->contract_file);
            }
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }

        $contract->update($data);

        // ✅ تحديث حالة الوحدة بعد التعديل
        $contract->unit->update(['status' => 'occupied']);

        return redirect()->route('admin.contracts.index')
                         ->with('success', __('messages.contract_updated_successfully'));
    }

    public function destroy(Contract $contract)
    {
        if ($contract->contract_file) {
            Storage::disk('public')->delete($contract->contract_file);
        }

        $contract->delete();

        return redirect()->route('admin.contracts.index')
                         ->with('success', __('messages.contract_deleted_successfully'));
    }

    public function end(Contract $contract)
   {
    $contract->update([
        'end_date' => now()->format('Y-m-d'),
    ]);

    // ✅ ترجع حالة الوحدة إلى متاحة
    $contract->unit()->update([
        'status' => 'available',
    ]);

    return back()->with('success', __('messages.contract_ended_successfully'));
    }

    // ✅ API: جلب الوحدات الخاصة بمبنى معين
    public function getUnitsByBuilding($buildingId)
    {
        return Unit::where('building_id', $buildingId)->get(['id', 'unit_number']);
    }
}
