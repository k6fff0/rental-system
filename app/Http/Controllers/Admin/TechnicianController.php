<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TechnicianProfile;

class TechnicianController extends Controller
{
	public function __construct()
{
    $this->middleware('permission:view technicians')->only(['index', 'show']);
    $this->middleware('permission:create technicians')->only(['create', 'store']);
    $this->middleware('permission:edit technicians')->only(['edit', 'update']);
    $this->middleware('permission:delete technicians')->only(['destroy']);
}

    public function index()
    {
        $technicians = User::role('technician')->with('technicianProfile')->get();

        return view('admin.technicians.index', compact('technicians'));
    }

    public function show($id)
    {
        $technician = User::with('technicianProfile')->findOrFail($id);

        return view('admin.technicians.show', compact('technician'));
    }

    public function edit($id)
    {
        $technician = User::with('technicianProfile')->findOrFail($id);

        return view('admin.technicians.edit', compact('technician'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'specialty' => 'required|string|max:255',
            'status' => 'required|in:available,busy,unavailable',
            'notes' => 'nullable|string',
        ]);

        $technician = User::findOrFail($id);
        $profile = $technician->technicianProfile ?? new TechnicianProfile(['user_id' => $technician->id]);

        $profile->fill($request->only(['specialty', 'status', 'notes']))->save();

        return redirect()->route('admin.technicians.show', $technician->id)->with('success', 'تم تحديث بيانات الفني بنجاح');
    }
}
