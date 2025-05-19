<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Enums\UnitType;

class UnitController extends Controller
{
	public function __construct()
{
    $this->middleware('permission:view units')->only(['index', 'show']);
    $this->middleware('permission:create units')->only(['create', 'store']);
    $this->middleware('permission:edit units')->only(['edit', 'update']);
    $this->middleware('permission:delete units')->only(['destroy']);
}

    // ✅ عرض كل الوحدات
    public function index(Request $request)
    {
        $query = Unit::with('building', 'contracts.tenant');

        // فلتر المبنى
        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        // فلتر رقم الوحدة
        if ($request->filled('search')) {
            $query->where('unit_number', 'like', '%' . $request->search . '%');
        }

        // فلتر نوع الوحدة
        if ($request->filled('unit_type')) {
            $query->where('unit_type', $request->unit_type);
        }

        $units = $query->get();
        $buildings = Building::all();
        $unitTypes = UnitType::values();

        return view('admin.units.index', compact('units', 'buildings', 'unitTypes'));
    }

    // ✅ صفحة إنشاء وحدة جديدة
    public function create()
    {
        $buildings = Building::all();
        $unitTypes = UnitType::values();

        return view('admin.units.create', compact('buildings', 'unitTypes'));
    }

    // ✅ حفظ وحدة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'building_id'  => 'required|exists:buildings,id',
            'unit_number'  => 'required|string|max:50|unique:units,unit_number,NULL,id,building_id,' . $request->building_id,
            'floor'        => 'nullable|integer',
            'unit_type'    => 'required|string|in:' . implode(',', UnitType::values()),
            'status'       => 'required|in:available,occupied,booked,maintenance,cleaning',
            'notes'        => 'nullable|string|max:1000',
            'rent_price'   => 'required|numeric|min:0',
        ]);

        Unit::create($request->only([
            'building_id',
            'unit_number',
            'floor',
            'unit_type',
            'status',
            'notes',
            'rent_price',
        ]));

        return redirect()->route('admin.units.index')->with('success', __('messages.created_successfully'));
    }

    // ✅ صفحة تعديل الوحدة
    public function edit(Unit $unit)
    {
        $buildings = Building::all();
        $unitTypes = UnitType::values();

        return view('admin.units.edit', compact('unit', 'buildings', 'unitTypes'));
    }

    // ✅ تعديل الوحدة بالكامل
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'building_id'  => 'required|exists:buildings,id',
            'unit_number'  => 'required|string|max:50|unique:units,unit_number,' . $unit->id . ',id,building_id,' . $request->building_id,
            'floor'        => 'nullable|integer',
            'unit_type'    => 'required|string|in:' . implode(',', UnitType::values()),
            'status'       => 'required|in:available,occupied,booked,maintenance,cleaning',
            'notes'        => 'nullable|string|max:1000',
            'rent_price'   => 'nullable|numeric|min:0',
        ]);

        $unit->update($request->only([
            'building_id',
            'unit_number',
            'floor',
            'unit_type',
            'status',
            'notes',
            'rent_price',
        ]));

        return redirect()->route('admin.units.index')->with('success', __('messages.updated_successfully'));
    }

    // ✅ تعديل الحالة فقط
    public function updateStatus(Request $request, Unit $unit)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,booked,maintenance,cleaning',
        ]);

        $unit->update(['status' => $request->status]);

        return back()->with('success', __('messages.updated_successfully'));
    }
	public function show(Unit $unit)
{
    $unit->load(['building', 'contracts.tenant', 'latestContract.tenant']);
    return view('admin.units.show', compact('unit'));
}


    // ✅ حذف الوحدة
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('admin.units.index')->with('success', __('messages.deleted_successfully'));
    }
	
}
