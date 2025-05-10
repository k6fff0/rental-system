<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::latest()->paginate(10);

        // تحويل التواريخ إلى كائنات Carbon
        $contracts->getCollection()->transform(function ($contract) {
            $contract->start_date = Carbon::parse($contract->start_date);
            $contract->end_date = Carbon::parse($contract->end_date);
            return $contract;
        });

        $activeContractsCount = Contract::where('end_date', '>', now()->addDays(30))->count();
        $expiringSoonCount = Contract::whereBetween('end_date', [now(), now()->addDays(30)])->count();

        return view('admin.contracts.index', compact('contracts', 'activeContractsCount', 'expiringSoonCount'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        $units = Unit::all();
        return view('admin.contracts.create', compact('tenants', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric',
            'notes' => 'nullable|string',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['tenant_id', 'unit_id', 'start_date', 'end_date', 'rent_amount', 'notes']);

        if ($request->hasFile('contract_file')) {
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }

        Contract::create($data);

        return redirect()->route('admin.contracts.index')->with('success', __('messages.contract_created_successfully'));
    }

    public function show(Contract $contract)
    {
        return view('admin.contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $tenants = Tenant::all();
        $units = Unit::all();
        return view('admin.contracts.edit', compact('contract', 'tenants', 'units'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric',
            'notes' => 'nullable|string',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['tenant_id', 'unit_id', 'start_date', 'end_date', 'rent_amount', 'notes']);

        if ($request->hasFile('contract_file')) {
            if ($contract->contract_file) {
                Storage::disk('public')->delete($contract->contract_file);
            }
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }

        $contract->update($data);

        return redirect()->route('admin.contracts.index')->with('success', __('messages.contract_updated_successfully'));
    }

    public function destroy(Contract $contract)
    {
        if ($contract->contract_file) {
            Storage::disk('public')->delete($contract->contract_file);
        }

        $contract->delete();

        return redirect()->route('admin.contracts.index')->with('success', __('messages.contract_deleted_successfully'));
    }
}
