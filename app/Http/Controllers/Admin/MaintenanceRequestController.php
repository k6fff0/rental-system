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
            ->orderByRaw('GREATEST(UNIX_TIMESTAMP(updated_at), UNIX_TIMESTAMP(created_at)) DESC')
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



//-------------------------------------------------------------------------------------------------------------------------------------------


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
        'extra_phone'      => 'nullable|string|max:20',
        'is_whatsapp'      => 'nullable|boolean',
    ]);

    // ✅ 🔁 تحقق من وجود أوردر نشط لنفس الغرفة والعطل
    $exists = MaintenanceRequest::where('unit_id', $request->unit_id)
        ->where('sub_specialty_id', $request->sub_specialty_id)
        ->whereNotIn('status', ['completed', 'cancelled', 'rejected'])
        ->exists();

    if ($exists) {
        return back()->with('error', 'يوجد بلاغ جاري لهذا العطل في هذه الوحدة بالفعل.');
    }

    // ✅ 2. تجهيز البيانات الأساسية
    $data = $request->only([
    'building_id',
    'unit_id',
    'sub_specialty_id',
    'description',
    ]);
    $data['extra_phone'] = $request->input('extra_phone');
    $data['is_whatsapp'] = $request->boolean('is_whatsapp');
    $data['created_by'] = auth()->id();

    // ✅ ⏺️ نحفظ الساكن الحالي وقت البلاغ
    $unit = \App\Models\Unit::with('latestContract.tenant')->find($request->unit_id);
    $data['tenant_id'] = $unit->latestContract?->tenant?->id;

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

//-------------------------------------------------------------------------------------------------------------------------------------


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

//-------------------------------------------------------------------------------------------------------------------------------------


 public function update(Request $request, $id)
{
    $request->validate([
        'building_id'       => 'required|exists:buildings,id',
        'unit_id'           => 'required|exists:units,id',
        'sub_specialty_id'  => 'required|exists:specialties,id',
        'description'       => 'nullable|string',
        'status'            => 'required|in:new,in_progress,completed,rejected,delayed,waiting_materials,customer_unavailable,other',
        'image'             => 'nullable|image|max:20480',
        'cost'              => 'nullable|numeric',
        'technician_id'     => 'nullable|exists:users,id',
        'extra_phone'       => 'nullable|string|max:20',
        'is_whatsapp'       => 'nullable|boolean',
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
        'status',

    ]);
	$data['extra_phone'] = $request->input('extra_phone');
    $data['is_whatsapp'] = $request->boolean('is_whatsapp');

    // ✅ التحقق من الفني الجديد
    if ($request->filled('technician_id')) {
        $technician = User::find($request->technician_id);

        if ($technician->technician_status === 'unavailable') {
            return back()->with('error', 'هذا الفني غير متاح حالياً ولا يمكن توكيله.');
        }

        // ✅ لو تم تغيير الفني
        if ($technician->id !== $maintenance->assigned_worker_id) {
            $data['assigned_worker_id'] = $technician->id;
            $data['assigned_manually'] = true;

            \Log::info('Requested technician_id: ' . $request->technician_id);
            \Log::info('Old technician: ' . $maintenance->assigned_worker_id);
        }
    }

    // ✅ تحديث صورة الإنجاز لو اترفعت
    if ($request->hasFile('image')) {
        $newImagePath = $request->file('image')->store('maintenance_images', 'public');

        if (!empty($maintenance->completed_image) && Storage::disk('public')->exists($maintenance->completed_image)) {
            Storage::disk('public')->delete($maintenance->completed_image);
        }

        $data['completed_image'] = $newImagePath;
    }

    // ✅ تحديث وقت التغيير حسب الحالة
    if ($request->status !== $oldStatus) {
        $now = now();
        $userId = auth()->id();

        switch ($request->status) {
            case 'in_progress':
                $data['in_progress_at'] = $now;
                $data['in_progress_by'] = $userId;
                break;
            case 'completed':
                $data['completed_at'] = $now;
                $data['completed_by'] = $userId;
                break;
            case 'rejected':
                $data['rejected_at'] = $now;
                $data['rejected_by'] = $userId;
                break;
            case 'delayed':
                $data['delayed_at'] = $now;
                break;
        }
    }

    $maintenance->fill($data);
    $maintenance->save();

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


//----------------------------------------------------------------------------------------------------------------------------------------------------

public function updateStatus(Request $request, $id)
{
    if (!auth()->user()->can('change maintenance status') && auth()->user()->user_type !== 'technician') {
        abort(403);
    }

    $request->validate([
        'status' => 'required|in:new,in_progress,completed,rejected,delayed,waiting_materials,customer_unavailable,other',
        'note' => 'nullable|string|max:1000',
        'completed_image' => 'nullable|image|max:20480',
    ]);

    $maintenance = MaintenanceRequest::findOrFail($id);
    $newStatus = $request->status;
    $userId = auth()->id();
    $now = now();

    switch ($newStatus) {
        case 'in_progress':
            $maintenance->in_progress_at = $now;
            $maintenance->in_progress_by = $userId;
            break;

        case 'completed':
            $maintenance->completed_at = $now;
            $maintenance->completed_by = $userId;

            if ($request->hasFile('completed_image')) {
                $path = $request->file('completed_image')->store('maintenance_images', 'public');
                $maintenance->completed_image = $path;
            }
            break;

        case 'rejected':
            $maintenance->rejected_at = $now;
            $maintenance->rejected_by = $userId;
            $maintenance->rejection_note = $request->note;
            break;

        case 'delayed':
            $maintenance->note = $request->note;
            $maintenance->delayed_at = $now; // ✅ تم تسجيل وقت التأجيل
			$maintenance->delayed_by = $userId;
            break;
    }

    $maintenance->status = $newStatus;
    $maintenance->save();

    if ($maintenance->technician) {
        $maintenance->technician->recalculateTechnicianStatus();
    }

    \Log::info("تم نقل الأوردر إلى فني ID: " . $maintenance->assigned_worker_id);

    return redirect()->back()->with('success', 'تم تحديث حالة البلاغ بنجاح');
}

//------------------------------------------------------------------------------------------------------------------------------------------------	


 public function show($id)
    {
        $request = MaintenanceRequest::with([
            'building',
            'unit.latestContract.tenant', 
            'subSpecialty.parent',
            'technician',
            'creator',
            'inProgressBy',
			'delayedBy',
            'completedBy',
            'rejectedBy'
        ])->findOrFail($id);

        return view('admin.maintenance_requests.show', compact('request'));
    }
	




//------------------------------------------------------------------------------------------------------------------------------------------------	
	
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




public function myRequests(Request $request)
{
    $technicianId = auth()->id();

    $requests = \App\Models\MaintenanceRequest::with(['unit.building', 'subSpecialty'])
        ->where('assigned_worker_id', $technicianId)
        ->whereNotIn('status', ['completed', 'rejected'])
        ->when($request->building_id, fn($q) => $q->where('building_id', $request->building_id))
		->when($request->status, fn($q) => $q->where('status', $request->status))
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

    $buildings = \App\Models\Building::all(); // علشان نعبي السلكت في الفيو

    return view('admin.technicians.maintenance.index', compact('requests', 'buildings'));
}


public function start($id)
{
    return $this->updateStatus(request()->merge(['status' => 'in_progress']), $id);
}

public function complete($id)
{
    return $this->updateStatus(request()->merge(['status' => 'completed']), $id);
}

public function reject(Request $request, $id)
{
    return $this->updateStatus($request->merge(['status' => 'rejected']), $id);
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
