<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // ✅ عرض كل الوحدات
    public function index()
    {
        $units = Unit::with('building')->get();
        return view('admin.units.index', compact('units'));
    }

    // ✅ صفحة إنشاء وحدة جديدة
    public function create()
    {
        $buildings = Building::all();
        return view('admin.units.create', compact('buildings'));
    }
	public function updateStatus(Request $request, Unit $unit)
{
    $request->validate([
        'status' => 'required|in:available,occupied,maintenance',
    ]);

    $unit->status = $request->input('status');
    $unit->save();

    return back()->with('success', __('messages.updated_successfully'));
}


    // ✅ حفظ الوحدة الجديدة
    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_number' => 'required|string|max:50',
            'floor' => 'nullable|integer',
            'type' => 'nullable|string|max:50',
        ]);

        Unit::create($request->all());

        return redirect()->route('admin.units.index')->with('success', 'تم إضافة الوحدة بنجاح');
    }

    // ✅ صفحة تعديل وحدة
    public function edit(Unit $unit)
    {
        $buildings = Building::all();
        return view('admin.units.edit', compact('unit', 'buildings'));
    }

    // ✅ تعديل الوحدة
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_number' => 'required|string|max:50',
            'floor' => 'nullable|integer',
            'type' => 'nullable|string|max:50',
        ]);

        $unit->update($request->all());

        return redirect()->route('admin.units.index')->with('success', 'تم تعديل الوحدة بنجاح');
    }

    // ✅ حذف وحدة
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'تم حذف الوحدة');
    }
}
