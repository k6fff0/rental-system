<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class BuildingSupervisorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'Building Supervisor');
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->withCount('supervisedZones')->orderByDesc('id')->paginate(10);

        return view('admin.building_supervisors.index', compact('users'));
    }

    public function edit(User $user)
    {
        $this->authorize('edit users');

        // نحضر المناطق اللي ملهاش مشرف أو المشرف الحالي هو المستخدم ده
        $zones = Zone::where(function ($q) use ($user) {
            $q->whereNull('supervisor_id')
                ->orWhere('supervisor_id', $user->id);
        })->get();

        $assigned = $user->supervisedZones->pluck('id')->toArray();

        return view('admin.building_supervisors.edit', compact('user', 'zones', 'assigned'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit users');

        $zoneIds = $request->input('zones', []);

        // أول حاجة نفصل المستخدم ده من كل المناطق اللي كان مشرف عليها
        Zone::where('supervisor_id', $user->id)->update(['supervisor_id' => null]);

        // وبعدين نربطه بالمناطق المختارة
        Zone::whereIn('id', $zoneIds)->update(['supervisor_id' => $user->id]);

        return redirect()->route('admin.building-supervisors.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function show(User $user)
    {
        $zones = $user->supervisedZones()->with('buildings')->get();

        $buildings = $zones->flatMap(fn($zone) => $zone->buildings);

        return view('admin.building_supervisors.show', compact('user', 'zones', 'buildings'));
    }
}
