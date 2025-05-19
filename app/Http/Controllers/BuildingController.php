<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view buildings')->only(['index', 'show']);
        $this->middleware('permission:create buildings')->only(['create', 'store']);
        $this->middleware('permission:edit buildings')->only(['edit', 'update']);
        $this->middleware('permission:delete buildings')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Building::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('building_id')) {
            $query->where('id', $request->building_id);
        }

        $buildings = $query->withCount('units')->get();

        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.buildings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'location_url' => 'nullable|url',
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
        ]);

        $data['electric_meters'] = json_encode($request->electric_meters);
        $data['internet_lines'] = json_encode(array_values($request->internet_lines ?? []));

        Building::create($data);

        return redirect()->route('admin.buildings.index')->with('success', 'تم إضافة المبنى بنجاح.');
    }

    public function show(Building $building)
    {
        return view('admin.buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'location_url' => 'nullable|url',
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
        ]);

        $data['electric_meters'] = json_encode($request->electric_meters);
        $data['internet_lines'] = json_encode(array_values($request->internet_lines ?? []));

        $building->update($data);

        return redirect()->route('admin.buildings.index')->with('success', 'تم تعديل المبنى بنجاح.');
    }

    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('admin.buildings.index')->with('success', 'تم حذف المبنى.');
    }
}
