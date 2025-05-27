<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Building;
use App\Models\ContractType;
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
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'rent_amount'   => 'required|numeric',
            'notes'         => 'nullable|string',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $hasActiveContract = Contract::where('unit_id', $request->unit_id)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->exists();

        if ($hasActiveContract) {
            return back()->withErrors([
                'unit_id' => __('messages.unit_already_has_active_contract')
            ])->withInput();
        }

        $data = $request->only([
            'tenant_id',
            'unit_id',
            'start_date',
            'end_date',
            'rent_amount',
            'notes',
        ]);

        $data['contract_number'] = 'C-' . str_pad(Contract::max('id') + 1, 6, '0', STR_PAD_LEFT);

        if ($request->hasFile('contract_file')) {
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }

        $contract = Contract::create($data);
        $contract->unit->update(['status' => 'occupied']);
        $data['status'] = 'active';
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
			//'status' => 'required|in:active,terminated,expired',

        ]);

        if ($contract->unit_id != $request->unit_id) {
            $conflict = Contract::where('unit_id', $request->unit_id)
                ->where('id', '!=', $contract->id)
                ->whereDate('start_date', '<=', $request->end_date)
                ->whereDate('end_date', '>=', $request->start_date)
                ->exists();

            if ($conflict) {
                return back()->withErrors([
                    'unit_id' => __('messages.unit_already_has_active_contract')
                ])->withInput();
            }
        }

        $data = $request->only([
            'tenant_id',
            'unit_id',
            'start_date',
            'end_date',
            'rent_amount',
            'notes',
			'status',
        ]);

        if ($request->hasFile('contract_file')) {
            if ($contract->contract_file) {
                Storage::disk('public')->delete($contract->contract_file);
            }
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }
		if ($contract->status === 'terminated' && $request->end_date > now()) {
           $data['status'] = 'active';
        }

        $contract->update($data);

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
        'end_date' => now()->timezone('Asia/Dubai'),
        'status' => 'terminated', // ✅ إضافة تحديث حالة العقد
    ]);

    $contract->unit()->update(['status' => 'available']);

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
