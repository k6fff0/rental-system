<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\Building;
use App\Models\User;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::withCount(['buildings', 'technicians'])->with('supervisor')->get();
        return view('admin.zones.index', compact('zones'));
    }

    public function create()
    {
        $buildings = Building::whereNull('zone_id')->get();
        $technicians = User::role('technician')->get();
        $supervisors = User::role('Building Supervisor')->get();

        return view('admin.zones.create', compact('buildings', 'technicians', 'supervisors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'buildings' => 'array',
            'technicians' => 'array',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $zone = Zone::create([
            'name' => $request->name,
            'supervisor_id' => $request->supervisor_id,
        ]);

        // ربط المباني
        if ($request->filled('buildings')) {
            Building::whereIn('id', $request->buildings)->update(['zone_id' => $zone->id]);
        }

        // ربط الفنيين
        if ($request->filled('technicians')) {
            $zone->technicians()->sync($request->technicians);
        }

        return redirect()->route('admin.zones.index')->with('success', 'تم إنشاء المنطقة بنجاح');
    }

    public function edit(Zone $zone)
    {
        $buildings = Building::where(function ($q) use ($zone) {
            $q->whereNull('zone_id')->orWhere('zone_id', $zone->id);
        })->get();

        $technicians = User::role('technician')->get();
        $supervisors = User::role('Building Supervisor')->get();

        $selectedBuildings = $zone->buildings->pluck('id')->toArray();
        $selectedTechnicians = $zone->technicians->pluck('id')->toArray();

        return view('admin.zones.edit', compact(
            'zone',
            'buildings',
            'technicians',
            'supervisors',
            'selectedBuildings',
            'selectedTechnicians'
        ));
    }

    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'buildings' => 'array',
            'technicians' => 'array',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $zone->update([
            'name' => $request->name,
            'supervisor_id' => $request->supervisor_id,
        ]);

        // فك ربط المباني القديمة وربط الجديدة
        Building::where('zone_id', $zone->id)->update(['zone_id' => null]);
        if ($request->filled('buildings')) {
            Building::whereIn('id', $request->buildings)->update(['zone_id' => $zone->id]);
        }

        // مزامنة الفنيين
        $zone->technicians()->sync($request->input('technicians', []));

        return redirect()->route('admin.zones.index')->with('success', 'تم تحديث بيانات المنطقة بنجاح');
    }

    public function show(Zone $zone)
    {
        $zone->load(['buildings', 'technicians', 'supervisor']);
        return view('admin.zones.show', compact('zone'));
    }

    public function destroy(Zone $zone)
    {
        // فك ارتباط المباني
        Building::where('zone_id', $zone->id)->update(['zone_id' => null]);

        // فك ارتباط الفنيين فقط
        $zone->technicians()->detach();

        // حذف المنطقة
        $zone->delete();

        return redirect()->route('admin.zones.index')->with('success', 'تم حذف المنطقة بنجاح');
    }
}
