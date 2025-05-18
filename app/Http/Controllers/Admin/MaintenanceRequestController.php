<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Technician;
use App\Models\User;
use App\Models\MaintenanceWorker;
use App\Models\MaintenanceCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DB;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $requests = MaintenanceRequest::with(['building', 'unit', 'category', 'technician'])
            ->when($request->building_id, fn($q) => $q->where('building_id', $request->building_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->technician_id, fn($q) => $q->where('technician_id', $request->technician_id))
            ->when($request->unit_number, function ($q) use ($request) {
                $q->whereHas('unit', function ($query) use ($request) {
                    $query->where('unit_number', 'LIKE', '%' . $request->unit_number . '%');
                });
            })
            ->latest()
            ->paginate($perPage);

        $buildings = Building::all();
        $categories = MaintenanceCategory::all();
        $technicians = Technician::all();

        $totalCount = MaintenanceRequest::count();
        $statusCounts = MaintenanceRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.maintenance_requests.index', compact(
            'requests',
            'buildings',
            'categories',
            'technicians',
            'totalCount',
            'statusCounts'
        ));
    }

    public function create()
    {
        $buildings = Building::all();
        $units = Unit::all();
        $categories = MaintenanceCategory::all();
        $technicians = User::role('technician')->get(); // أو Technician::all()

        return view('admin.maintenance_requests.create', compact('buildings', 'units', 'categories', 'technicians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id'    => 'required|exists:buildings,id',
            'unit_id'        => 'required|exists:units,id',
            'category_id'    => 'required|exists:maintenance_categories,id',
            'description'    => 'required|string',
            'image'          => 'nullable|image|max:2048',
            'technician_id'  => 'nullable|exists:users,id',
        ]);

        $data = $request->only(['building_id', 'unit_id', 'category_id', 'description', 'technician_id']);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('maintenance_images', 'public');
        }

        MaintenanceRequest::create($data);

        return redirect()->route('admin.maintenance_requests.index')->with('success', 'تم تسجيل البلاغ بنجاح');
    }

    public function show($id)
    {
        $request = MaintenanceRequest::with(['building', 'unit', 'worker', 'category', 'technician'])->findOrFail($id);

        return view('admin.maintenance_requests.show', compact('request'));
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::findOrFail($id);
        $buildings = Building::all();
        $units = Unit::all();
        $workers = MaintenanceWorker::all();
        $technicians = User::role('technician')->get(); // أو Technician::all()
        $categories = MaintenanceCategory::all();

        return view('admin.maintenance_requests.edit', compact(
            'request',
            'buildings',
            'units',
            'workers',
            'technicians',
            'categories'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'building_id'    => 'required|exists:buildings,id',
            'unit_id'        => 'required|exists:units,id',
            'category_id'    => 'required|exists:maintenance_categories,id',
            'description'    => 'required|string',
            'status'         => 'required|in:new,in_progress,completed,rejected,delayed,waiting_materials,customer_unavailable,other',
            'image'          => 'nullable|image|max:2048',
            'cost'           => 'nullable|numeric',
            'technician_id'  => 'nullable|exists:users,id',
        ]);

        $maintenance = MaintenanceRequest::findOrFail($id);

        $data = $request->only([
            'building_id',
            'unit_id',
            'category_id',
            'description',
            'status',
            'start_notes',
            'end_notes',
            'note',
            'cost',
            'technician_id'
        ]);

        if ($request->hasFile('image')) {
            if ($maintenance->image && Storage::disk('public')->exists($maintenance->image)) {
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

        if ($request->image && Storage::disk('public')->exists($request->image)) {
            Storage::disk('public')->delete($request->image);
        }

        $request->delete();

        return redirect()->route('admin.maintenance_requests.index')->with('success', 'تم حذف البلاغ بنجاح');
    }

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
