<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagerController extends Controller
{
	public function __construct()
{
    $this->middleware('permission:view roles')->only(['index', 'show']);
    $this->middleware('permission:create roles')->only(['create', 'store']);
    $this->middleware('permission:edit roles')->only(['edit', 'update']);
    $this->middleware('permission:delete roles')->only(['destroy']);
}

    /**
     * عرض كل المجموعات.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.manager', compact('roles'));
    }

    /**
     * إضافة مجموعة جديدة.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->route('admin.role_manager.index')
                         ->with('success', __('messages.role_created_successfully'));
    }

    /**
     * تعديل اسم وصلاحيات المجموعة.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * تحديث بيانات المجموعة.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array|nullable',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // تحديث الاسم
        $role->name = $request->name;
        $role->save();

        // ✅ تحويل IDs إلى كائنات Permission
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
        $role->syncPermissions($permissions);

        return redirect()->route('admin.role_manager.index')
                         ->with('success', __('messages.role_updated_successfully'));
    }

    /**
     * حذف المجموعة.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.role_manager.index')
                         ->with('success', __('messages.role_deleted_successfully'));
    }
}
