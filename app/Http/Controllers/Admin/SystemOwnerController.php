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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Settings\SystemSettings;

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

        $backupFiles = Storage::disk('local')->files('backups');
        $lastBackup = collect($backupFiles)
            ->map(fn($file) => Storage::disk('local')->lastModified($file))
            ->sortDesc()
            ->first();

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

    public function clearLog()
    {
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            file_put_contents($logPath, '');
        }
        return back()->with('success', '🧹 تم مسح سجلات النظام بنجاح!');
    }

    public function downloadLog()
    {
        $logPath = storage_path('logs/laravel.log');
        if (!file_exists($logPath)) {
            return back()->with('error', '❌ لا يوجد ملف سجلات حاليًا.');
        }
        return response()->download($logPath, 'laravel-log-' . now()->format('Y-m-d_H-i-s') . '.log');
    }

    public function toggleMaintenance()
    {
        $value = request()->has('maintenance_mode');
        if (function_exists('settings')) {
            $settings = settings(SystemSettings::class);
            $settings->maintenance_mode = $value;
            $settings->save();
        }
        $value ? Artisan::call('down') : Artisan::call('up');
        return back()->with('success', '✅ تم تحديث وضع الصيانة.');
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            return back()->with('success', '✅ تم تنظيف الكاش بالكامل.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل تنظيف الكاش: ' . $e->getMessage());
        }
    }

    public function optimizeDatabase()
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            foreach ($tables as $table) {
                $tableName = $table->{"Tables_in_$dbName"};
                DB::statement("OPTIMIZE TABLE `$tableName`");
            }
            return back()->with('success', '✅ تم تحسين قاعدة البيانات بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل في تحسين قاعدة البيانات: ' . $e->getMessage());
        }
    }

    public function restartQueue()
    {
        try {
            Artisan::call('queue:restart');
            return back()->with('success', '🔄 تم إعادة تشغيل الـ Queue Workers بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل في إعادة تشغيل الـ Queue: ' . $e->getMessage());
        }
    }
}
