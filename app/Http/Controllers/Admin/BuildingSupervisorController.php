<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Building;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class BuildingSupervisorController extends Controller
{
    public function index()
    {
        // فقط المستخدمين اللي عندهم دور Building Supervisor
        $users = User::whereHas('roles', function ($q) {
        $q->where('name', 'Building Supervisor');
        })->with('buildings')->orderByDesc('id')->paginate(10);


        return view('admin.building_supervisors.index', compact('users'));
    }

    public function edit(User $user)
    {
        $this->authorize('edit users');

        $buildings = Building::all();
        $assigned = $user->buildings->pluck('id')->toArray();

        return view('admin.building_supervisors.edit', compact('user', 'buildings', 'assigned'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit users');

        $buildingIds = $request->input('buildings', []);

        // Sync المباني المحددة
        $user->buildings()->sync($buildingIds);

        return redirect()->route('admin.building-supervisors.index')->with('success', __('messages.updated_successfully'));
    }
}
