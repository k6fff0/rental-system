<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;

class LogController extends Controller
{
    /**
     * مسح محتوى سجل Laravel
     */
    public function clear(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            File::put($logPath, ''); // يفرغ محتوى السجل
        }

        // لو فيه باكدج log viewer
        if (class_exists(\Rap2hpoutre\LaravelLogViewer\LogViewerController::class)) {
            Artisan::call('log:clear');
        }

        return redirect()->back()->with('success', __('messages.log_cleared_successfully'));
    }

    /**
     * تحميل ملف سجل Laravel الحالي
     */
    public function download()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            abort(404, __('messages.log_file_not_found'));
        }

        return response()->download($logPath, 'system-log.txt');
    }
}
