<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Contract;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

class SystemOwnerController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $lastLog = 'لم يتم العثور على سجل اللوج';

        if (File::exists($logFile)) {
            $lines = file($logFile);
            $lastLog = implode('', array_slice($lines, -100));
        }

        // ✅ تعريف المتغير قبل الإرسال
        $roles = Role::withCount('users')->get();

        return view('admin.system-owner.index', [
            'usersCount'     => User::count(),
            'buildingsCount' => Building::count(),
            'unitsCount'     => Unit::count(),
            'contractsCount' => Contract::count(),
            'lastLog'        => $lastLog,
            'roles'          => $roles,
        ]);
    }
}
