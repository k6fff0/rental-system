<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $mainSpecialties = Specialty::where('is_main', true)->with('subtasks')->get();
        return view('admin.specialties.index', compact('mainSpecialties'));
    }

public function create()
{
    $mainSpecialties = Specialty::where('is_main', true)->get();
    return view('admin.specialties.create', compact('mainSpecialties'));
}


    public function store(Request $request)
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

        return redirect()->route('admin.technicians.specialties.index')->with('success', 'تم إضافة التخصص بنجاح.');
    }

    public function edit($id)
    {
        $specialty = Specialty::findOrFail($id);
        $mainSpecialties = Specialty::where('is_main', true)->get();
        return view('admin.specialties.edit', compact('specialty', 'mainSpecialties'));
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'is_main' => 'required|boolean',
            'parent_id' => 'nullable|exists:specialties,id',
        ]);

        $specialty->update([
            'name' => $request->name,
            'is_main' => $request->is_main,
            'parent_id' => $request->is_main ? null : $request->parent_id,
        ]);

        return redirect()->route('admin.technicians.specialties.index')->with('success', 'تم تحديث التخصص بنجاح.');
    }

    public function destroy($id)
    {
        Specialty::destroy($id);
        return back()->with('success', 'تم حذف التخصص بنجاح.');
    }
}
