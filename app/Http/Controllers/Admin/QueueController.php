<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class QueueController extends Controller
{
    public function restart()
    {
        Artisan::call('queue:restart'); // إعادة تشغيل الصفوف
        return back()->with('success', 'تم إعادة تشغيل صفوف المهام بنجاح');
    }
}
