<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Expense;
use App\Models\Violation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleReportExport;
use App\Services\VehicleReportService;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('user')->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.vehicles.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_category'         => 'required|string|max:3',
            'plate_number'           => 'required|numeric|digits_between:1,6',
            'brand'                  => 'required|string|max:255',
            'model'                  => 'nullable|string',
            'color'                  => 'nullable|string|max:255',
            'user_id'                => 'nullable|exists:users,id',
            'status'                 => 'required|string|in:available,in_service,broken',
            'photo'                  => 'nullable|image|max:22048',
            'notes'                  => 'nullable|string',
            'license_expiry_date'    => 'nullable|date',
            'insurance_expiry_date'  => 'nullable|date',
        ]);

        $fullPlate = $request->plate_category . '-' . $request->plate_number;

        // تأكد إن الرقم ده مش موجود قبل كده
        if (\App\Models\Vehicle::where('plate_number', $fullPlate)->exists()) {
            return back()->withErrors(['plate_number' => 'رقم اللوحة هذا مستخدم بالفعل.'])->withInput();
        }

        $vehicle = new Vehicle($request->except('photo'));
        $vehicle->plate_number = $fullPlate;

        if ($request->hasFile('photo')) {
            $vehicle->photo = $request->file('photo')->store('vehicles', 'public');
        }

        $vehicle->save();

        return redirect()->route('vehicles.index')->with('success', 'تم إنشاء السيارة بنجاح');
    }



    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $users = User::all();

        return view('admin.vehicles.edit', compact('vehicle', 'users'));
    }


    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'plate_category'         => 'required|string|max:3',
            'plate_number'           => 'required|numeric|digits_between:1,6',
            'brand'                  => 'required|string|max:255',
            'model'                  => 'nullable|string',
            'color'                  => 'nullable|string|max:255',
            'user_id'                => 'nullable|exists:users,id',
            'status'                 => 'required|string|in:available,in_service,broken',
            'photo'                  => 'nullable|image|max:2048',
            'notes'                  => 'nullable|string',
            'license_expiry_date'    => 'nullable|date',
            'insurance_expiry_date'  => 'nullable|date',
        ]);

        $fullPlate = $request->plate_category . '-' . $request->plate_number;

        if (
            \App\Models\Vehicle::where('plate_number', $fullPlate)
            ->where('id', '!=', $vehicle->id)
            ->exists()
        ) {
            return back()->withErrors(['plate_number' => 'رقم اللوحة هذا مستخدم بالفعل.'])->withInput();
        }

        $vehicle->fill($request->except('photo'));
        $vehicle->plate_number = $fullPlate;

        if ($request->hasFile('photo')) {
            if ($vehicle->photo) {
                Storage::disk('public')->delete($vehicle->photo);
            }
            $vehicle->photo = $request->file('photo')->store('vehicles', 'public');
        }

        $vehicle->save();

        return redirect()->route('vehicles.index')->with('success', 'تم تحديث بيانات السيارة بنجاح');
    }



    public function show($id)
    {
        $vehicle = Vehicle::with([
            'user',
            'expenses' => fn($q) => $q->orderByDesc('expense_date'),
            'violations' => fn($q) => $q->orderByDesc('date') // لو ده كمان فيه نفس المشكلة راجعه
        ])->findOrFail($id);

        return view('admin.vehicles.show', compact('vehicle'));
    }



    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if ($vehicle->photo) {
            Storage::disk('public')->delete($vehicle->photo);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully');
    }


    public function reports(Request $request)
    {

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : null;
        $endDate   = $request->end_date ? Carbon::parse($request->end_date) : null;
        $vehicleId = $request->vehicle_id;
        $userId    = $request->user_id;

        $vehicles = Vehicle::all();
        $users    = User::all();

        // تحميل المصروفات المرتبطة بالسيارات فقط
        $expenses = Expense::with('expensable')
            ->where('expensable_type', Vehicle::class);

        if ($vehicleId) {
            $expenses->where('expensable_id', $vehicleId);
        }

        // تحميل الغرامات مع علاقاتها
        $violations = Violation::with(['vehicle', 'user']);

        // فلاتر التاريخ
        if ($startDate) {
            $expenses->whereDate('expense_date', '>=', $startDate);
            $violations->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $expenses->whereDate('expense_date', '<=', $endDate);
            $violations->whereDate('date', '<=', $endDate);
        }

        // فلتر السيارة
        if ($vehicleId) {
            $expenses->where('expensable_id', $vehicleId);
            $violations->where('vehicle_id', $vehicleId);
        }

        // فلتر السائق
        if ($userId) {
            $violations->where('user_id', $userId);
        }

        return view('admin.vehicles.reports.index', [
            'vehicles'   => $vehicles,
            'users'      => $users,
            'expenses'   => $expenses->get(),
            'violations' => $violations->get(),
            'startDate'  => $startDate,
            'endDate'    => $endDate,
            'vehicleId'  => $vehicleId,
            'userId'     => $userId,
        ]);
    }


    public function exportPdf(Request $request)
    {
        $data = VehicleReportService::getReportData($request);

        $pdf = Pdf::loadView('admin.vehicles.reports.pdf', $data);
        return $pdf->download('vehicle-report.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new VehicleReportExport($request), 'vehicle-report.xlsx');
    }
}
