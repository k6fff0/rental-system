<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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

        // جِيب IDs المباني اللي مسندة لأي حد غير المستخدم الحالي
        $assignedToOthers = \DB::table('building_user')
            ->where('user_id', '!=', $user->id)
            ->pluck('building_id')
            ->unique()
            ->toArray();


        return view('admin.building_supervisors.edit', compact('user', 'buildings', 'assigned', 'assignedToOthers'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit users');

        $buildingIds = $request->input('buildings', []);

        // Sync المباني المحددة
        $user->buildings()->sync($buildingIds);

        return redirect()->route('admin.building-supervisors.index')->with('success', __('messages.updated_successfully'));
    }
    public function show(User $user)
    {
        $buildings = $user->buildings()->paginate(10); // أو العدد اللي تحبه
        return view('admin.building_supervisors.show', compact('user', 'buildings'));
    }
}
