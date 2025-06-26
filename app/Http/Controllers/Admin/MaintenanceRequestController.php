<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB;
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

    //-------------------------------------------------------------------------------------------------------------------------------------------


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

    //-------------------------------------------------------------------------------------------------------------------------------------------


    public function create()
    {
        // ✅ جلب المباني للمبنى-only select
        $buildings = \App\Models\Building::orderBy('name')->get();

        // جلب التخصصات الفرعية مع التخصص الرئيسي
        $subSpecialties = Specialty::subtasks()
            ->with('parent:id,name')
            ->orderBy('name')
            ->get();

        // التقنيين (إذا احتجتهم)
        $technicians = User::role('technician')
            ->orderBy('name')
            ->get();

        return view('admin.maintenance_requests.create', compact(
            'buildings',         // ✅ أضفنا ده
            'subSpecialties',
            'technicians'
        ));
    }



    //-------------------------------------------------------------------------------------------------------------------------------------------





    //-------------------------------------------------------------------------------------------------------------------------------------------


    public function store(Request $request)
    {
        $request->validate([
            'request_type'     => 'required|in:unit,building',
            'unit_id'          => 'required_if:request_type,unit|nullable|exists:units,id',
            'building_id'      => 'required_if:request_type,building|nullable|exists:buildings,id',
            'sub_specialty_id' => 'required|exists:specialties,id',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|max:20480',
            'technician_id'    => 'nullable|exists:users,id',
            'extra_phone'      => 'nullable|string|max:20',
            'is_whatsapp'      => 'nullable|boolean',
            'is_emergency'     => 'nullable|boolean',
            'audio_data'       => 'nullable|string',
        ]);

        $exists = MaintenanceRequest::where('unit_id', $request->unit_id)
            ->where('sub_specialty_id', $request->sub_specialty_id)
            ->whereNotIn('status', ['completed', 'cancelled', 'rejected'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'يوجد بلاغ جاري لهذا العطل في هذه الوحدة بالفعل.');
        }

        $unit = $request->unit_id ? Unit::with('latestContract.tenant')->find($request->unit_id) : null;

        $data = [
            'unit_id'          => $unit?->id,
            'sub_specialty_id' => $request->sub_specialty_id,
            'description'      => $request->description,
            'building_id'      => $request->building_id ?? $unit?->building_id,
            'extra_phone'      => $request->input('extra_phone'),
            'is_whatsapp'      => $request->boolean('is_whatsapp'),
            'is_emergency'     => $request->boolean('is_emergency'),
            'created_by'       => auth()->id(),
            'tenant_id'        => $unit?->latestContract?->tenant?->id,
        ];

        // 📷 رفع الصورة
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('maintenance_images', 'public');
        }

        // 🔊 رفع الملاحظة الصوتية
        if ($request->filled('audio_data')) {
            try {
                $base64Data = $request->input('audio_data');
                $base64 = preg_replace('#^data:audio/\w+;base64,#i', '', $base64Data);
                $fileData = base64_decode($base64);
                $filename = 'maintenance_audio_notes/' . uniqid('note_') . '.webm';
                Storage::disk('public')->put($filename, $fileData);
                $data['audio_note'] = $filename;
            } catch (\Exception $e) {
                Log::error('خطأ في حفظ الملاحظة الصوتية: ' . $e->getMessage());
            }
        }

        // 👨‍🔧 التوزيع اليدوي
        if ($request->filled('technician_id')) {
            $technician = User::find($request->technician_id);
            if ($technician->technician_status === 'unavailable') {
                return back()->with('error', 'هذا الفني غير متاح حالياً ولا يمكن توكيله.');
            }
            $data['assigned_worker_id'] = $technician->id;
            $data['assigned_manually'] = true;
        } else {
            // 👨‍🔧 التوزيع التلقائي حسب المنطقة
            $subSpecialty = Specialty::find($request->sub_specialty_id);
            if ($subSpecialty && $subSpecialty->parent_id) {
                $mainSpecialtyId = $subSpecialty->parent_id;

                $building = Building::find($data['building_id']);
                $zoneId = $building?->zone_id;

                // فني من نفس المنطقة
                $technician = User::role('technician')
                    ->where('main_specialty_id', $mainSpecialtyId)
                    ->whereIn('technician_status', ['available', 'busy'])
                    ->whereHas('technicianZones', fn($q) => $q->where('zone_id', $zoneId))
                    ->withCount(['assignedMaintenanceRequests as active_requests_count' => function ($q) {
                        $q->whereNotIn('status', ['completed', 'cancelled']);
                    }])
                    ->orderBy('active_requests_count')
                    ->inRandomOrder()
                    ->first();

                // fallback لفني عالمي مش مرتبط بمنطقة
                if (! $technician) {
                    $technician = User::role('technician')
                        ->where('main_specialty_id', $mainSpecialtyId)
                        ->whereIn('technician_status', ['available', 'busy'])
                        ->doesntHave('technicianZones') // بدون منطقة
                        ->withCount(['assignedMaintenanceRequests as active_requests_count' => function ($q) {
                            $q->whereNotIn('status', ['completed', 'cancelled']);
                        }])
                        ->orderBy('active_requests_count')
                        ->inRandomOrder()
                        ->first();
                }

                if ($technician) {
                    $data['assigned_worker_id'] = $technician->id;
                    $data['assigned_manually'] = false;
                }
            }
        }

        // 💾 إنشاء البلاغ
        $maintenanceRequest = MaintenanceRequest::create($data);

        // ✅ تحديث حالة الفني حسب عدد المهام
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
            'is_emergency'      => 'nullable|boolean',
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

        // فلتر الوحدة عن طريق id مباشر (اختياري)
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // فلتر البحث الذكي عن الوحدة
        if ($request->filled('unit_search')) {
            $query->whereHas('unit', function ($q) use ($request) {
                $q->where('unit_number', 'like', '%' . $request->unit_search . '%');
            });
        }

        // فلتر الفني
        if ($request->filled('assigned_worker_id')) {
            $query->where('assigned_worker_id', $request->assigned_worker_id);
        }

        // فلتر نوع المشكلة
        if ($request->filled('sub_specialty_id')) {
            $query->where('sub_specialty_id', $request->sub_specialty_id);
        }

        // فلتر التاريخ
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // فلتر الحالة (لو عايز تختار بين completed أو rejected فقط)
        if ($request->filled('status') && in_array($request->status, ['completed', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // ترتيب حسب السورت
        if ($request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($request->sort == 'status') {
            $query->orderBy('status', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // الافتراضي
        }

        $requests = $query->paginate(30)->withQueryString();

        return view('admin.maintenance_requests.archive', compact('requests'));
    }

    //-------------------------------------------------------------------------------------------------------------------------------------------

    public function myRequests(Request $request)
    {
        $technicianId = auth()->id();

        $requests = \App\Models\MaintenanceRequest::with([
            'unit.building',
            'building',
            'subSpecialty'
        ])
            ->where('assigned_worker_id', $technicianId)
            ->whereNotIn('status', ['completed', 'rejected'])
            ->when($request->building_id, fn($q) => $q->where('building_id', $request->building_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderByDesc('is_emergency')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $buildings = \App\Models\Building::all();

        return view('admin.technicians.maintenance.index', compact('requests', 'buildings'));
    }

    //-------------------------------------------------------------------------------------------------------------------------------------------

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


    //-------------------------------------------------------------------------------------------------------------------------------------------


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

    //-------------------------------------------------------------------------------------------------------------------------------------------	

}
