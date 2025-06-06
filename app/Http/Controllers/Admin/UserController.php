<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialty;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view users')->only(['index', 'show']);
        $this->middleware('permission:create users')->only(['create', 'store']);
        $this->middleware('permission:edit users')->only(['edit', 'update']);
        $this->middleware('permission:delete users')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = User::with(['roles', 'mainSpecialty'])
            ->where('is_hidden', false)
            ->where('email', '!=', config('app.super_admin_email'));

        if ($request->filled('role_id')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->role_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(12);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $mainSpecialties = Specialty::where('is_main', true)->get();

        return view('admin.users.create', compact('roles', 'permissions', 'mainSpecialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:6|confirmed',
            'phone'             => 'nullable|string|max:255',
            'main_specialty_id' => 'nullable|exists:specialties,id',
            'technician_status' => 'nullable|in:available,busy,unavailable',
            'role'              => 'nullable|exists:roles,name',
            'permissions'       => 'array',
            'permissions.*'     => 'exists:permissions,id',
            'photo'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10048',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'phone'             => $request->phone,
            'main_specialty_id' => $request->main_specialty_id,
            'technician_status' => $request->technician_status,
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
            $user->photo_url = 'storage/' . $photoPath;
        } else {
            $user->photo_url = 'storage/users/default-avatar.png';
        }

        $user->save();

        if ($request->filled('role')) {
            $user->assignRole($request->role);
        }

        $permissionNames = Permission::whereIn('id', $request->permissions ?? [])->pluck('name');
        $user->syncPermissions($permissionNames);

        return redirect()->route('admin.users.index')
            ->with('success', __('messages.user_created_successfully'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $mainSpecialties = Specialty::where('is_main', true)->get();

        return view('admin.users.edit', compact('user', 'roles', 'permissions', 'mainSpecialties'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'لا يمكن تعديل بيانات مالك النظام.');
        }

        $request->validate([
            'name'              => 'nullable|string|max:255',
            'email'             => 'nullable|email|unique:users,email,' . $user->id,
            'phone'             => 'nullable|string|max:255',
            'main_specialty_id' => 'nullable|exists:specialties,id',
            'technician_status' => 'nullable|in:available,busy,unavailable',
            'role'              => 'nullable|exists:roles,name',
            'permissions'       => 'array',
            'permissions.*'     => 'exists:permissions,id',
            'photo'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        $user->main_specialty_id = $request->main_specialty_id;
        $user->technician_status = $request->technician_status;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
            $user->photo_url = 'storage/' . $photoPath;
        }

        $user->save();

        if ($request->filled('role')) {
            $user->syncRoles([$request->role]);
        } else {
            $user->syncRoles([]);
        }

        $permissionNames = Permission::whereIn('id', $request->permissions ?? [])->pluck('name');
        $user->syncPermissions($permissionNames);

        return redirect()->route('admin.users.index')
            ->with('success', __('messages.user_updated_successfully'));
    }


public function toggleActive(User $user)
{
	
    if (!auth()->user()->hasRole("Admin's")) {
        abort(403, __('messages.unauthorized'));
    }

    // لو المستخدم متعطل بالفعل، هنفعّله
    if (!$user->is_active) {
        $user->is_active = true;
        $user->save();

        return back()->with('success', __('messages.user_enabled_successfully'));
    }

    // لو المستخدم شغّال، هنعطله
    $user->is_active = false;
    $user->save();

    return back()->with('error', __('messages.user_disabled_successfully'));
}

public function destroy(string $id)
{
    $user = User::findOrFail($id);

    if ($user->isSuperAdmin()) {
        return redirect()->route('admin.users.index')
            ->with('error', __('messages.cannot_delete_super_admin'));
    }

    $user->delete(); // soft delete

    return redirect()->route('admin.users.index')
        ->with('success', __('messages.user_deleted_successfully'));
}



}
