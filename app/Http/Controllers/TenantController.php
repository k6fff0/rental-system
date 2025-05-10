<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    // ✅ عرض كل المستأجرين
    public function index()
    {
        $tenants = Tenant::with(['unit', 'user'])->paginate(10);
        return view('admin.tenants.index', compact('tenants'));
    }

    // ✅ صفحة إضافة مستأجر
    public function create()
    {
        $units = Unit::all();
        return view('admin.tenants.create', compact('units'));
    }

    // ✅ حفظ المستأجر الجديد
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'move_in_date' => 'nullable|date',
        ]);

        Tenant::create($request->all());

        return redirect()->route('admin.tenants.index')->with('success', 'تم إضافة المستأجر بنجاح');
    }

    // ✅ صفحة تعديل مستأجر
    public function edit(Tenant $tenant)
    {
        $units = Unit::all();
        return view('admin.tenants.edit', compact('tenant', 'units'));
    }

    // ✅ تحديث بيانات المستأجر
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'move_in_date' => 'nullable|date',
        ]);

        $tenant->update($request->all());

        return redirect()->route('admin.tenants.index')->with('success', 'تم تعديل بيانات المستأجر');
    }

    // ✅ حذف مستأجر
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('admin.tenants.index')->with('success', 'تم حذف المستأجر');
    }

    // ✅ عرض صفحة ربط المستأجر بحساب
    public function linkUser(Tenant $tenant)
    {
        $users = User::whereDoesntHave('tenant')->where('role', 'tenant')->get();
        return view('tenants.link', compact('tenant', 'users'));
    }

    // ✅ ربط المستأجر بمستخدم موجود
    public function attachUser(Request $request, Tenant $tenant)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $tenant->user_id = $request->user_id;
        $tenant->save();

        return redirect()->route('admin.tenants.index')->with('success', 'تم ربط المستأجر بالمستخدم بنجاح');
    }

    // ✅ إنشاء حساب جديد وربطه بالمستأجر
    public function createUser(Request $request, Tenant $tenant)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $tenant->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tenant',
        ]);

        $tenant->user_id = $user->id;
        $tenant->save();

        return redirect()->route('admin.tenants.index')->with('success', 'تم إنشاء حساب وربطه بالمستأجر بنجاح');
    }
}
