<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialty;

class TechnicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view technicians')->only(['index', 'show']);
        $this->middleware('permission:create technicians')->only(['create', 'store']);
        $this->middleware('permission:edit technicians')->only(['edit', 'update']);
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
        $technician = User::with('mainSpecialty')->findOrFail($id);
        return view('admin.technicians.show', compact('technician'));
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
}
