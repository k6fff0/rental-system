<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enums\UnitType;
use App\Enums\UnitStatus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class BuildingController extends Controller


{
    public function __construct()
    {
        $this->middleware('permission:view buildings')->only(['index']);
        $this->middleware('permission:view building details')->only(['show']);
        $this->middleware('permission:create buildings')->only(['create', 'store']);
        $this->middleware('permission:edit buildings')->only(['edit', 'update']);
        $this->middleware('permission:delete buildings')->only(['destroy']);
    }


    //--------------------------------------------------------------------------------------------------------------


    public function index(Request $request)
    {
        $query = Building::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('building_id')) {
            $query->where('id', $request->building_id);
        }

        $buildings = $query->withCount('units')->paginate(10);

        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.buildings.create');
    }



    //--------------------------------------------------------------------------------------------------------------



    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'building_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'location_url' => 'nullable|url',
            'owner_name' => 'nullable|string|max:255',
            'owner_nationality' => 'nullable|string|max:255',
            'owner_id_number' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:255',
            'municipality_number' => 'nullable|string|max:255',
            'rent_amount' => 'nullable|numeric',
            'initial_renovation_cost' => 'nullable|numeric',
            'guarantee_cheque_amount' => 'nullable|numeric|min:0',
            'grace_period_months' => 'nullable|integer|min:0',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after_or_equal:contract_start_date',
            'image' => 'nullable|image|max:22048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('buildings', 'public');
        }

        $building = Building::create($data);

        log_action("🏢 تم إضافة مبنى جديد: {$building->name}");

        return redirect()->route('admin.buildings.index')->with('success', 'تم إضافة المبنى بنجاح.');
    }


    //--------------------------------------------------------------------------------------------------------------


    public function show(Building $building)
    {
        return view('admin.buildings.show', compact('building'));
    }



    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }


    //--------------------------------------------------------------------------------------------------------------

    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'building_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'location_url' => 'nullable|url',
            'owner_name' => 'nullable|string|max:255',
            'owner_nationality' => 'nullable|string|max:255',
            'owner_id_number' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:255',
            'municipality_number' => 'nullable|string|max:255',
            'rent_amount' => 'nullable|numeric',
            'initial_renovation_cost' => 'nullable|numeric',
            'guarantee_cheque_amount' => 'nullable|numeric|min:0',
            'grace_period_months' => 'nullable|integer|min:0',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after_or_equal:contract_start_date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($building->image) {
                Storage::disk('public')->delete($building->image);
            }

            $data['image'] = $request->file('image')->store('buildings', 'public');
        }

        $building->update($data);

        log_action('🏢 تم تعديل بيانات المبنى: ' . $building->name);

        return redirect()->route('admin.buildings.index')->with('success', 'تم تعديل المبنى بنجاح.');
    }

    //--------------------------------------------------------------------------------------------------------------

    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('admin.buildings.index')->with('success', 'تم حذف المبنى.');
    }



    //--------------------------------------------------------------------------------------------------------------



    public function deleteImage(Building $building)
    {
        if ($building->image && Storage::disk('public')->exists($building->image)) {
            Storage::disk('public')->delete($building->image);
            $building->update(['image' => null]);
        }

        return back()->with('success', 'تم حذف صورة المبنى بنجاح.');
    }

    //--------------------------------------------------------------------------------------------------------------



    public function toggleFamiliesOnly(Building $building)
    {

        $building->families_only = !$building->families_only;
        $building->save();


        return redirect()->route('admin.buildings.edit', $building->id)
            ->with('success', 'تم تحديث الحالة بنجاح');
    }
}
