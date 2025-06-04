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
use App\Models\Specialty;
use DB;
use App\Exports\MaintenanceArchiveExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class MaintenanceRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view maintenance requests')->only(['index', 'show']);
        $this->middleware('permission:create maintenance requests')->only(['create', 'store']);
        $this->middleware('permission:edit maintenance requests')->only(['edit', 'update']);
        $this->middleware('permission:delete maintenance requests')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $requests = MaintenanceRequest::with(['building', 'unit', 'technician', 'unit.activeContract.tenant', 'subSpecialty.parent'])
            ->when($request->building_id, fn($q) => $q->where('building_id', $request->building_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->sub_specialty_id, fn($q) => $q->where('sub_specialty_id', $request->sub_specialty_id))
            ->when($request->technician_id, fn($q) => $q->where('assigned_worker_id', $request->technician_id))
            ->when($request->unit_number, function ($q) use ($request) {
                $q->whereHas('unit', function ($query) use ($request) {
                    $query->where('unit_number', 'LIKE', '%' . $request->unit_number . '%');
                });
            })
            ->whereNotIn('status', ['completed', 'rejected'])
            ->latest()
            ->paginate($perPage);

        $buildings = Building::all();
        $subSpecialties = \App\Models\Specialty::subtasks()->with('parent')->get();
        $technicians = User::role('technician')->get();

        $totalCount = MaintenanceRequest::count();
        $statusCounts = MaintenanceRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.maintenance_requests.index', compact(
            'requests',
            'buildings',
            'subSpecialties',
            'technicians',
            'totalCount',
            'statusCounts'
        ));
    }


    public function create()
    {
        $buildings = Building::all();
        $units = Unit::all();
        $subSpecialties = Specialty::subtasks()->with('parent')->get();
        $technicians = User::role('technician')->get();

        return view('admin.maintenance_requests.create', compact('buildings', 'units', 'subSpecialties', 'technicians'));
    }






    public function store(Request $request)
    {
        // ✅ 1. فحص البيانات المطلوبة
        $request->validate([
            'building_id'      => 'required|exists:buildings,id',
            'unit_id'          => 'required|exists:units,id',
            'sub_specialty_id' => 'required|exists:specialties,id',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|max:20480',
            'technician_id'    => 'nullable|exists:users,id',
        ]);

        // ✅ 🔁 تحقق من وجود أوردر نشط لنفس الغرفة والعطل
        $exists = MaintenanceRequest::where('unit_id', $request->unit_id)
            ->where('sub_specialty_id', $request->sub_specialty_id)
            ->whereNotIn('status', ['completed', 'cancelled', 'rejected']) // حالات شغالة
            ->exists();

        if ($exists) {
            return back()->with('error', 'يوجد بلاغ جاري لهذا العطل في هذه الوحدة بالفعل.');
        }

        // ✅ 2. تجهيز البيانات الأساسية
        $data = $request->only(['building_id', 'unit_id', 'sub_specialty_id', 'description']);
        $data['created_by'] = auth()->id();

        // ✅ 3. رفع الصورة لو موجودة
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('maintenance_images', 'public');
        }

        // ✅ 4. تعيين فني يدوي
        if ($request->filled('technician_id')) {
            $technician = User::find($request->technician_id);

            if ($technician->technician_status === 'unavailable') {
                return back()->with('error', 'هذا الفني غير متاح حالياً ولا يمكن توكيله.');
            }

            $data['assigned_worker_id'] = $technician->id;
            $data['assigned_manually'] = true;
        } else {
            // ✅ 5. تعيين تلقائي
            $subSpecialty = Specialty::find($request->sub_specialty_id);

            if ($subSpecialty && $subSpecialty->parent_id) {
                $mainSpecialtyId = $subSpecialty->parent_id;

                $technician = User::role('technician')
                    ->where('main_specialty_id', $mainSpecialtyId)
                    ->whereIn('technician_status', ['available', 'busy'])
                    ->withCount(['assignedMaintenanceRequests as active_requests_count' => function ($q) {
                        $q->whereNotIn('status', ['completed', 'cancelled']);
                    }])
                    ->orderBy('active_requests_count')
                    ->inRandomOrder()
                    ->first();

                if ($technician) {
                    $data['assigned_worker_id'] = $technician->id;
                    $data['assigned_manually'] = false;
                }
            }
        }

        // ✅ 6. إنشاء البلاغ
        $maintenanceRequest = MaintenanceRequest::create($data);

        // ✅ 7. تحديث حالة الفني
        if ($maintenanceRequest->technician) {
            $maintenanceRequest->technician->updateTechnicianBusyStatus();
        }

        return redirect()->route('admin.maintenance_requests.index')
            ->with('success', 'تم تسجيل البلاغ بنجاح');
    }



    public function edit($id)
    {
        $maintenance = MaintenanceRequest::findOrFail($id);
        $buildings = Building::all();
        $units = Unit::all();
        $technicians = User::role('technician')->get();
        $subSpecialties = Specialty::subtasks()->with('parent')->get(); // التخصصات الفرعية فقط

        return view('admin.maintenance_requests.edit', compact(
            'maintenance',
            'buildings',
            'units',
            'technicians',
            'subSpecialties'
        ));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'building_id'       => 'required|exists:buildings,id',
            'unit_id'           => 'required|exists:units,id',
            'sub_specialty_id'  => 'required|exists:specialties,id',
            'description'       => 'required|string',
            'status'            => 'required|in:new,in_progress,completed,rejected,delayed,waiting_materials,customer_unavailable,other',
            'image'             => 'nullable|image|max:20480',
            'cost'              => 'nullable|numeric',
            'technician_id'     => 'nullable|exists:users,id',
        ]);

        $maintenance = MaintenanceRequest::findOrFail($id);
        $oldTechnician = $maintenance->technician;
        $oldStatus = $maintenance->status;

        $data = $request->only([
            'building_id',
            'unit_id',
            'sub_specialty_id',
            'description',
            'note',
            'cost',
            'status'
        ]);

        // ✅ تعيين الفني يدويًا
        if ($request->filled('technician_id')) {
            $technician = User::find($request->technician_id);

            if ($technician->technician_status === 'unavailable') {
                return back()->with('error', 'هذا الفني غير متاح حالياً ولا يمكن توكيله.');
            }

            $data['assigned_worker_id'] = $technician->id;
            $data['assigned_manually'] = true;
        }

        // ✅ تحديث صورة الإنجاز لو اترفعت
        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('maintenance_images', 'public');

            if (!empty($maintenance->completed_image) && Storage::disk('public')->exists($maintenance->completed_image)) {
                Storage::disk('public')->delete($maintenance->completed_image);
            }

            $data['completed_image'] = $newImagePath;
        }

        // ✅ تحديث حالة الطلب وتسجيل وقت التغيير ومن قام به
        if ($request->status !== $oldStatus) {
            $now = now();
            $userId = auth()->id();

            match ($request->status) {
                'in_progress' => [
                    $data['in_progress_at'] = $now,
                    $data['in_progress_by'] = $userId,
                ],
                'completed' => [
                    $data['completed_at'] = $now,
                    $data['completed_by'] = $userId,
                ],
                'rejected' => [
                    $data['rejected_at'] = $now,
                    $data['rejected_by'] = $userId,
                ],
                default => []
            };
        }

        $maintenance->update($data);

        // ✅ تحديث حالة الفني الجديد
        if ($maintenance->technician) {
            $maintenance->technician->updateTechnicianBusyStatus();
            $maintenance->technician->recalculateTechnicianStatus();
        }

        // ✅ تحديث حالة الفني القديم لو اتغير
        if ($oldTechnician && $oldTechnician->id !== $maintenance->assigned_worker_id) {
            $oldTechnician->recalculateTechnicianStatus();
        }

        return redirect()->route('admin.maintenance_requests.index')
            ->with('success', 'تم تحديث البلاغ بنجاح');
    }


    public function updateStatus(Request $request, $id)
    {
        abort_unless(auth()->user()->can('change maintenance status'), 403);

        $request->validate([
            'status' => 'required|in:new,in_progress,completed,rejected,delayed,waiting_materials,customer_unavailable,other',
        ]);

        $maintenance = MaintenanceRequest::findOrFail($id);
        $newStatus = $request->status;
        $userId = auth()->id();

        // 🧠 نحفظ التوقيت ومين عمل التغيير حسب الحالة
        switch ($newStatus) {
            case 'in_progress':
                $maintenance->in_progress_at = now();
                $maintenance->in_progress_by = $userId;
                break;

            case 'completed':
                $maintenance->completed_at = now();
                $maintenance->completed_by = $userId;
                break;

            case 'rejected':
                $maintenance->rejected_at = now();
                $maintenance->rejected_by = $userId;
                break;
        }

        $maintenance->status = $newStatus;
        $maintenance->save();

        // ✅ إعادة احتساب حالة الفني
        if ($maintenance->technician) {
            $maintenance->technician->recalculateTechnicianStatus();
        }

        return redirect()->back()->with('success', 'تم تحديث حالة البلاغ بنجاح');
    }



    public function show($id)
    {
        $request = MaintenanceRequest::with([
            'building',
            'unit.activeContract.tenant', // 👈 مهم برضو هنا
            'subSpecialty.parent',
            'technician',
            'creator',
            'inProgressBy',
            'completedBy',
            'rejectedBy'
        ])->findOrFail($id);

        return view('admin.maintenance_requests.show', compact('request'));
    }
    public function archive(Request $request)
    {


        $query = MaintenanceRequest::with(['unit', 'building', 'technician', 'subSpecialty'])
            ->whereIn('status', ['completed', 'rejected']);

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->filled('assigned_worker_id')) {
            $query->where('assigned_worker_id', $request->assigned_worker_id);
        }

        if ($request->filled('sub_specialty_id')) {
            $query->where('sub_specialty_id', $request->sub_specialty_id);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $requests = $query->latest()->paginate(30);


        return view('admin.maintenance_requests.archive', compact('requests'));
    }


    public function exportExcel(Request $request)
    {
        return Excel::download(new MaintenanceArchiveExport($request), 'maintenance-archive.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $requests = MaintenanceRequest::with(['unit', 'building', 'technician', 'subSpecialty'])
            ->whereIn('status', ['completed', 'rejected'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.maintenance_requests.exports.pdf', compact('requests'));
        return $pdf->download('maintenance-archive.pdf');
    }
}
