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
        // تحسين استعلام الفلاتر
        $requests = MaintenanceRequest::with(['building', 'unit', 'category', 'technician'])
            ->when($request->building_id, fn($q) => $q->where('building_id', $request->building_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->unit_number, function ($q) use ($request) {
                $q->whereHas('unit', function ($query) use ($request) {
                    $query->where('unit_number', 'LIKE', '%' . $request->unit_number . '%');
                });
            })
            ->latest()
            ->get();

        $buildings = Building::all();
        $categories = \App\Models\MaintenanceCategory::all();

        return view('admin.maintenance_requests.index', compact('requests', 'buildings', 'categories'));
    }

    public function create()
{
    $buildings = Building::all();
    $units = Unit::all();
    $categories = \App\Models\MaintenanceCategory::all();
    $technicians = User::role('technician')->get(); // لو بتستخدم spatie أو عدلها حسب تسميتك

    return view('admin.maintenance_requests.create', compact('buildings', 'units', 'categories', 'technicians'));
}


    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'required|exists:units,id',
            'category_id' => 'required|exists:maintenance_categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
			'technician_id' => 'nullable|exists:users,id',

        ]);

        $data = $request->only(['building_id', 'unit_id', 'category_id', 'description' , 'technician_id']);
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
    $technicians = User::role('technician')->get(); // نفس الحكاية فوق

    return view('admin.maintenance_requests.edit', compact('request', 'buildings', 'units', 'workers', 'technicians'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_id' => 'required|exists:units,id',
            'category_id' => 'required|exists:maintenance_categories,id',
            'description' => 'required|string',
            'status' => 'required|in:new,in_progress,completed,rejected,delayed,waiting_materials,customer_unavailable,other',
            'image' => 'nullable|image|max:2048',
            'cost' => 'nullable|numeric',
			'technician_id' => 'nullable|exists:users,id',

        ]);

        $maintenance = MaintenanceRequest::findOrFail($id);

        $data = $request->only([
            'building_id',
            'unit_id',
            'category_id',
            'description',
            'status',
            'assigned_worker_id',
            'start_notes',
            'end_notes',
            'note',
            'cost',
			'technician_id'
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
            'status' => 'required|in:new,in_progress,completed,rejected,delayed,waiting_materials,customer_unavailable,other',
        ]);

        $maintenance = MaintenanceRequest::findOrFail($id);
        $maintenance->status = $request->status;
        $maintenance->save();

        return redirect()->back()->with('success', 'تم تحديث حالة البلاغ بنجاح');
    }
}