<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // ✅ عرض كل الوحدات
    public function index(Request $request)
{
    $query = Unit::with('building', 'contracts.tenant');

    // فلتر المبنى
    if ($request->filled('building_id')) {
        $query->where('building_id', $request->building_id);
    }

    // فلتر برقم الغرفة (بحث جزئي)
    if ($request->filled('search')) {
        $query->where('unit_number', 'like', '%' . $request->search . '%');
    }

    $units = $query->get();
    $buildings = \App\Models\Building::all();

    return view('admin.units.index', compact('units', 'buildings'));
}


    // ✅ صفحة إنشاء وحدة جديدة
    public function create()
    {
        $buildings = Building::all();
        return view('admin.units.create', compact('buildings'));
    }

    // ✅ حفظ وحدة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'building_id'  => 'required|exists:buildings,id',
            'unit_number'  => 'required|string|max:50|unique:units,unit_number,NULL,id,building_id,' . $request->building_id,
            'floor'        => 'nullable|integer',
            'type'         => 'nullable|string|max:50',
            'status'       => 'required|in:available,occupied,booked,maintenance,cleaning',
            'notes'        => 'nullable|string|max:1000',
            'rent_price'   => 'nullable|numeric|min:0',
        ]);

        Unit::create($request->all());

        return redirect()->route('admin.units.index')->with('success', __('messages.created_successfully'));
    }

    // ✅ صفحة تعديل الوحدة
    public function edit(Unit $unit)
    {
        $buildings = Building::all();
        return view('admin.units.edit', compact('unit', 'buildings'));
    }

    // ✅ تعديل الوحدة بالكامل
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'building_id'  => 'required|exists:buildings,id',
            'unit_number'  => 'required|string|max:50|unique:units,unit_number,' . $unit->id . ',id,building_id,' . $request->building_id,
            'floor'        => 'nullable|integer',
            'type'         => 'nullable|string|max:50',
            'status'       => 'required|in:available,occupied,booked,maintenance,cleaning',
            'notes'        => 'nullable|string|max:1000',
            'rent_price'   => 'nullable|numeric|min:0',
        ]);

        $unit->update([
            'building_id'  => $request->building_id,
            'unit_number'  => $request->unit_number,
            'floor'        => $request->floor,
            'type'         => $request->type,
            'status'       => $request->status,
            'notes'        => $request->notes,
            'rent_price'   => $request->rent_price,
        ]);

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

    // ✅ حذف الوحدة
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', __('messages.deleted_successfully'));
    }
}
