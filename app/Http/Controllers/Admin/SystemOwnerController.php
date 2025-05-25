<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Contract;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;

class SystemOwnerController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logFile)) {
            $lines = array_slice(file($logFile, FILE_IGNORE_NEW_LINES), -100);

            foreach ($lines as $line) {
                if (trim($line) === '') continue;

                preg_match('/^\[(.*?)\].*?(\w+): (.*)$/', $line, $matches);

                $logs[] = [
                    'date' => $matches[1] ?? '',
                    'level' => $matches[2] ?? 'INFO',
                    'message' => $matches[3] ?? $line,
                ];
            }
        }

        $roles = Role::withCount('users')->get();

        // ✅ النسخ الاحتياطية
        $backupFiles = Storage::disk('local')->files('backups');
        $lastBackup = collect($backupFiles)
            ->map(fn($file) => Storage::disk('local')->lastModified($file))
            ->sortDesc()
            ->first();

        // هنا أنواع العقود الثابتة المؤقتة
        $contractTypes = collect([
           ['key' => 'type1', 'name' => 'نوع 1', 'updated_at' => now()->subDays(1), 'is_active' => true],
           ['key' => 'type2', 'name' => 'نوع 2', 'updated_at' => now()->subDays(3), 'is_active' => false],
           ['key' => 'type3', 'name' => 'نوع 3', 'updated_at' => now()->subDays(5), 'is_active' => true],
        ]);

        return view('admin.system-owner.index', [
            'usersCount'     => User::count(),
            'buildingsCount' => Building::count(),
            'unitsCount'     => Unit::count(),
            'contractsCount' => Contract::count(),
            'logs'           => $logs,
            'roles'          => $roles,
            'lastBackup'     => $lastBackup ? Carbon::createFromTimestamp($lastBackup) : null,
            'contractTypes'  => $contractTypes,
        ]);
    }
}
