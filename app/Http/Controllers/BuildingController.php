<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the buildings.
     */
    public function index(Request $request)
    {
        $query = Building::query();

        // فلتر بالاسم
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // فلتر بالـ ID من القائمة
        if ($request->filled('building_id')) {
            $query->where('id', $request->building_id);
        }

        $buildings = $query->withCount('units')->get();

        return view('admin.buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new building.
     */
    public function create()
    {
        return view('admin.buildings.create');
    }

    /**
     * Store a newly created building in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_nationality' => 'nullable|string|max:255',
            'owner_id_number' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:255',
            'municipality_number' => 'nullable|string|max:255',
            'rent_amount' => 'nullable|numeric',
            'initial_renovation_cost' => 'nullable|numeric',
            'electric_meters' => 'nullable|array',
            'electric_meters.*' => 'nullable|string',
            'internet_lines' => 'nullable|array',
            'internet_lines.*' => 'nullable|string',
        ]);

        Building::create($data);

        return redirect()->route('admin.buildings.index')->with('success', 'تم إضافة المبنى بنجاح.');
    }

    /**
     * Display the specified building.
     */
    public function show(Building $building)
    {
        return view('admin.buildings.show', compact('building'));
    }

    /**
     * Show the form for editing the specified building.
     */
    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }

    /**
     * Update the specified building in storage.
     */
    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_nationality' => 'nullable|string|max:255',
            'owner_id_number' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:255',
            'municipality_number' => 'nullable|string|max:255',
            'rent_amount' => 'nullable|numeric',
            'initial_renovation_cost' => 'nullable|numeric',
            'electric_meters' => 'nullable|array',
            'electric_meters.*' => 'nullable|string',
            'internet_lines' => 'nullable|array',
            'internet_lines.*' => 'nullable|string',
        ]);

        $building->update($data);

        return redirect()->route('admin.buildings.index')->with('success', 'تم تعديل المبنى بنجاح.');
    }

    /**
     * Remove the specified building from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('admin.buildings.index')->with('success', 'تم حذف المبنى.');
    }
}
