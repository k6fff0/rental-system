<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;
use Exception;

class BackupController extends Controller
{
    /**
     * إنشاء نسخة احتياطية
     */
  public function create()
{
    try {
        \Log::info('🔁 Running backup via UI...');

        Artisan::call('backup:run');
        $output = Artisan::output();

        \Log::info('📦 Backup Output:', [$output]);

        return back()->with('success', '✅ تم تنفيذ النسخة الاحتياطية بنجاح');
    } catch (\Exception $e) {
        \Log::error('❌ فشل تنفيذ النسخة الاحتياطية: ' . $e->getMessage());
        return back()->with('error', '❌ فشل النسخة الاحتياطية: ' . $e->getMessage());
    }
}


    /**
     * تحميل أحدث نسخة
     */
    public function download()
    {
        $diskName = config('backup.backup.destination.disks')[0];
        $disk = Storage::disk($diskName);

        $files = collect($disk->files(config('backup.backup.name')))
            ->filter(fn($file) => str_ends_with($file, '.zip'))
            ->sortByDesc(fn($file) => $disk->lastModified($file));

        $latestBackup = $files->first();

        if (!$latestBackup) {
            return back()->with('error', '❌ لا توجد نسخ احتياطية متاحة.');
        }

        return $disk->download($latestBackup);
    }

    /**
     * حذف النسخ القديمة
     */
    public function clean()
    {
        try {
            Artisan::call('backup:clean');
            return back()->with('success', '🧹 تم حذف النسخ القديمة بنجاح!');
        } catch (Exception $e) {
            return back()->with('error', '❌ فشل في حذف النسخ القديمة: ' . $e->getMessage());
        }
    }

    /**
     * استعادة نسخة احتياطية (sql أو zip)
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:zip,sql',
        ]);

        $file = $request->file('backup_file');
        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('temp-restore', $filename);

        // حذف البيانات القديمة لو طلب المستخدم
        if ($request->boolean('delete_existing')) {
            Artisan::call('migrate:fresh');
        }

        // استرجاع قاعدة البيانات
        if (str_ends_with($filename, '.sql')) {
            $command = sprintf(
                'mysql -u%s -p%s %s < %s',
                escapeshellarg(config('database.connections.mysql.username')),
                escapeshellarg(config('database.connections.mysql.password')),
                escapeshellarg(config('database.connections.mysql.database')),
                escapeshellarg(storage_path("app/{$path}"))
            );
            exec($command, $output, $return_var);

            if ($return_var !== 0) {
                return back()->with('error', '❌ فشل استرجاع قاعدة البيانات.');
            }

            return back()->with('success', '✅ تم استرجاع قاعدة البيانات بنجاح!');
        }

        // فك الضغط لمجلد مؤقت آمن
        if (str_ends_with($filename, '.zip')) {
            $zip = new ZipArchive;
            $res = $zip->open(storage_path("app/{$path}"));
            if ($res === TRUE) {
                $extractPath = storage_path("app/restore-temp/" . pathinfo($filename, PATHINFO_FILENAME));
                if (!is_dir($extractPath)) {
                    mkdir($extractPath, 0775, true);
                }
                $zip->extractTo($extractPath);
                $zip->close();
                return back()->with('success', '✅ تم فك ضغط النسخة الاحتياطية إلى مجلد مؤقت!');
            } else {
                return back()->with('error', '❌ فشل فك ضغط النسخة.');
            }
        }

        return back()->with('error', '❌ نوع الملف غير مدعوم.');
    }
}
