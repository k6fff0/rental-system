<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\User;
use App\Models\MaintenanceWorker;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = MaintenanceRequest::with(['building', 'unit'])
            ->when($request->building_id, fn($q) => $q->where('building_id', $request->building_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        $buildings = Building::all();

        return view('admin.maintenance_requests.index', compact('requests', 'buildings'));
    }

    public function create()
    {
        $buildings = Building::all();
        $units = Unit::all();

        return view('admin.maintenance_requests.create', compact('buildings', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['building_id', 'unit_id', 'type', 'description']);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('maintenance_images', 'public');
        }

        MaintenanceRequest::create($data);

        return redirect()->route('admin.maintenance_requests.index')->with('success', 'تم تسجيل البلاغ بنجاح');
    }

    public function show($id)
    {
        $request = MaintenanceRequest::with(['building', 'unit', 'worker'])->findOrFail($id);

        return view('admin.maintenance_requests.show', compact('request'));
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::findOrFail($id);
        $buildings = Building::all();
        $units = Unit::all();
        $workers = MaintenanceWorker::all();

        return view('admin.maintenance_requests.edit', compact('request', 'buildings', 'units', 'workers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:new,in_progress,completed,rejected',
            'image' => 'nullable|image|max:2048',
            'cost' => 'nullable|numeric',
        ]);

        $maintenance = MaintenanceRequest::findOrFail($id);

        $data = $request->only([
            'building_id',
            'unit_id',
            'type',
            'description',
            'status',
            'assigned_worker_id',
            'start_notes',
            'end_notes',
            'note',
            'cost',
        ]);

        if ($request->hasFile('image')) {
            if ($maintenance->image) {
                Storage::disk('public')->delete($maintenance->image);
            }
            $data['image'] = $request->file('image')->store('maintenance_images', 'public');
        }

        $maintenance->update($data);

        return redirect()->route('admin.maintenance_requests.index')->with('success', 'تم تحديث البلاغ بنجاح');
    }

    public function destroy($id)
    {
        $request = MaintenanceRequest::findOrFail($id);
        if ($request->image) {
            Storage::disk('public')->delete($request->image);
        }
        $request->delete();

        return redirect()->route('admin.maintenance_requests.index')->with('success', 'تم حذف البلاغ بنجاح');
    }

    // ✅ ميثود جديدة لتحديث الحالة فقط
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,completed,rejected,delayed,awaiting_materials,customer_unavailable,other',
        ]);

        $maintenance = MaintenanceRequest::findOrFail($id);
        $maintenance->status = $request->status;
        $maintenance->save();

        return redirect()->back()->with('success', 'تم تحديث حالة البلاغ بنجاح');
    }
}
