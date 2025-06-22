<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialty;
use Carbon\Carbon;
use App\Models\MaintenanceRequest;


class TechnicianController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:view technicians')->only(['index', 'show']);
        $this->middleware('permission:create technicians')->only(['create', 'store']);
        //$this->middleware('permission:edit technicians')->only(['edit', 'update']);
        $this->middleware('permission:delete technicians')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = User::role('technician')->with('mainSpecialty');

        if ($request->filled('specialty')) {
            $query->where('main_specialty_id', $request->specialty);
        }

        $technicians = $query->get();
        $mainSpecialties = Specialty::where('is_main', true)->get();

        return view('admin.technicians.index', compact('technicians', 'mainSpecialties'));
    }


    public function show($id)
    {
        $technician = User::with(['mainSpecialty', 'technicianRequests.unit', 'technicianRequests.subSpecialty'])->findOrFail($id);

        $requests = $technician->technicianRequests;

        $total = $requests->count();
        $completed = $requests->where('status', 'completed')->count();
        $rejected = $requests->where('status', 'rejected')->count();
        $new = $requests->where('status', 'new')->count();
        $in_progress = $requests->where('status', 'in_progress')->count();

        $durations = $requests->whereNotNull('in_progress_at')
            ->whereNotNull('completed_at')
            ->map(function ($request) {
                return $request->completed_at->diffInMinutes($request->in_progress_at);
            });

        $averageDuration = $durations->avg();
        $fastest = $durations->min();
        $slowest = $durations->max();

        $totalCost = $requests->sum('cost');

        // ✅ توليد لوج مقروء مرتب
        $logs = $requests->sortByDesc('updated_at')->map(function ($r) {
            $unitNumber = optional($r->unit)->unit_number ?? 'بدون رقم';
            $subName = optional($r->subSpecialty)->name ?? 'غير محدد';
            $time = $r->updated_at->format('Y-m-d H:i');

            return match ($r->status) {
                'completed'   => "✅ تم إكمال مهمة صيانة <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'rejected'    => "❌ تم رفض مهمة <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'in_progress' => "🛠️ بدأ العمل في <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'new'         => "🕓 تم تعيين الطلب <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'delayed'     => "⏳ تم تأجيل مهمة <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                default       => "ℹ️ حالة غير معروفة - الوحدة {$unitNumber} ({$time})",
            };
        });

        return view('admin.technicians.show', compact(
            'technician',
            'requests',
            'total',
            'completed',
            'rejected',
            'new',
            'in_progress',
            'averageDuration',
            'fastest',
            'slowest',
            'totalCost',
            'logs'
        ));
    }


    public function edit($id)
    {
        $technician = User::with('mainSpecialty')->findOrFail($id);
        $mainSpecialties = Specialty::where('is_main', true)->get();
        return view('admin.technicians.edit', compact('technician', 'mainSpecialties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'main_specialty_id' => 'nullable|exists:specialties,id',
            'technician_status' => 'required|in:available,busy,unavailable',
            'notes' => 'nullable|string',
        ]);

        $technician = User::findOrFail($id);
        $technician->main_specialty_id = $request->main_specialty_id;
        $technician->technician_status = $request->technician_status;
        $technician->notes = $request->notes;
        $technician->save();

        return redirect()->route('admin.technicians.show', $technician->id)
            ->with('success', 'تم تحديث بيانات الفني بنجاح');
    }

    public function specialtiesIndex()
    {
        $specialties = Specialty::latest()->get();
        return view('admin.technicians.specialties.index', compact('specialties'));
    }

    public function createSpecialty()
    {
        $mainSpecialties = Specialty::where('is_main', true)->get();
        return view('admin.technicians.specialties.create', compact('mainSpecialties'));
    }

    public function editSpecialty($id)
    {
        $specialty = Specialty::findOrFail($id);
        $mainSpecialties = Specialty::where('is_main', true)->where('id', '!=', $id)->get();
        return view('admin.technicians.specialties.edit', compact('specialty', 'mainSpecialties'));
    }

    public function storeSpecialty(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_main' => 'required|boolean',
            'parent_id' => 'nullable|exists:specialties,id',
        ]);

        Specialty::create([
            'name' => $request->name,
            'is_main' => $request->is_main,
            'parent_id' => $request->is_main ? null : $request->parent_id,
        ]);

        return back()->with('success', 'تمت إضافة التخصص بنجاح');
    }

    public function updateSpecialty(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_main' => 'required|boolean',
            'parent_id' => 'nullable|exists:specialties,id',
        ]);

        $specialty = Specialty::findOrFail($id);
        $specialty->update([
            'name' => $request->name,
            'is_main' => $request->is_main,
            'parent_id' => $request->is_main ? null : $request->parent_id,
        ]);

        return back()->with('success', 'تم تعديل التخصص بنجاح');
    }

    public function destroySpecialty($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();

        return back()->with('success', 'تم حذف التخصص بنجاح');
    }


    public function report(Request $request, $id)
    {
        $technician = User::with('mainSpecialty')->findOrFail($id);

        $query = MaintenanceRequest::with(['unit', 'subSpecialty'])
            ->where('assigned_worker_id', $technician->id);

        // ✅ فلترة بالتاريخ لو موجود
        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereBetween('updated_at', [$from, $to]);
        }

        $requests = $query->get();

        // ✅ إحصائيات الحالة
        $total      = $requests->count();
        $new        = $requests->where('status', 'new')->count();
        $inProgress = $requests->where('status', 'in_progress')->count();
        $completed  = $requests->where('status', 'completed')->count();
        $rejected   = $requests->where('status', 'rejected')->count();

        // ✅ حساب مدد التنفيذ
        $durations = $requests->filter(function ($r) {
            return $r->created_at && $r->completed_at;
        })->map(function ($r) {
            return $r->completed_at->diffInHours($r->created_at);
        });

        $averageDuration = $durations->avg();
        $fastest         = $durations->min();
        $slowest         = $durations->max();

        $totalCost = $requests->sum('cost');

        // ✅ بناء سجل النشاطات بصيغة مقروءة
        $logs = $requests->sortByDesc('updated_at')->map(function ($r) {
            $unitNumber = optional($r->unit)->unit_number ?? 'بدون رقم';
            $subName    = optional($r->subSpecialty)->name ?? 'غير محدد';
            $time       = $r->updated_at->format('Y-m-d H:i');

            return match ($r->status) {
                'completed'   => "✅ تم إكمال مهمة صيانة <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'rejected'    => "❌ تم رفض مهمة <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'in_progress' => "🛠️ بدأ العمل في <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'new'         => "🕓 تم تعيين الطلب <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                'delayed'     => "⏳ تم تأجيل مهمة <strong>{$subName}</strong> - الوحدة <strong>{$unitNumber}</strong> ({$time})",
                default       => "ℹ️ حالة غير معروفة - الوحدة {$unitNumber} ({$time})",
            };
        });

        return view('admin.technicians.report', compact(
            'technician',
            'requests',
            'total',
            'completed',
            'new',
            'rejected',
            'inProgress',
            'averageDuration',
            'fastest',
            'slowest',
            'totalCost',
            'logs'
        ));
    }
}
