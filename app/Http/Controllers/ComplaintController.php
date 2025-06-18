<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:255',
            'message' => 'required|string',
        ]);

        Complaint::create($data);

        return redirect()->back()->with('success', 'تم إرسال الشكوى بنجاح.');
    }

    public function index()
    {
        $complaints = Complaint::latest()->paginate(20);
        return view('admin.complaints.index', compact('complaints'));
    }
}
