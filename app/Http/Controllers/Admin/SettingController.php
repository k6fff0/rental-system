<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Settings\SystemSettings;

class SettingController extends Controller
{
    /**
     * عرض صفحة الإعدادات العامة
     */
    public function edit()
    {
        return view('admin.settings.edit');
    }

    /**
     * ✅ تفعيل أو تعطيل وضع الصيانة باستخدام Spatie Settings
     */
    public function toggleMaintenance(Request $request)
    {
        try {
            $settings = app(SystemSettings::class);
            $settings->maintenance_mode = $request->has('maintenance_mode');
            $settings->save();
            $settings->refresh();

            if ($settings->maintenance_mode) {
                Artisan::call('down');
            } else {
                Artisan::call('up');
            }

            return back()->with('success', '✅ تم تحديث وضع الصيانة.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل في تنفيذ وضع الصيانة: ' . $e->getMessage());
        }
    }

    /**
     * ✅ تنظيف الكاش بأنواعه
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            return back()->with('success', '✅ تم تنظيف الكاش بالكامل.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل في تنظيف الكاش: ' . $e->getMessage());
        }
    }

    /**
     * ✅ تحسين قاعدة البيانات
     */
    public function optimizeDatabase()
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $tableKey = "Tables_in_$dbName";

            foreach ($tables as $table) {
                DB::statement("OPTIMIZE TABLE `" . $table->$tableKey . "`");
            }

            return back()->with('success', '✅ تم تحسين قاعدة البيانات.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل تحسين قاعدة البيانات: ' . $e->getMessage());
        }
    }

    /**
     * ✅ إعادة تشغيل الـ Queue Workers
     */
    public function restartQueue()
    {
        try {
            Artisan::call('queue:restart');
            return back()->with('success', '🔄 تم إعادة تشغيل الـ Queue Workers.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ فشل في إعادة تشغيل الـ Queue: ' . $e->getMessage());
        }
    }

    /**
     * ✅ تحديث إعدادات النظام (الاسم، الشعار، اللون، وضع الصيانة)
     */
  public function update(Request $request)
{
    $request->validate([
        'app_name' => 'required|string|max:100',
        'app_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:1024',
        'primary_color' => 'required|string',
    ]);

    try {
        $settings = app(SystemSettings::class);

        // احفظ القيمة الحالية لوضع الصيانة قبل التعديل
        $previousMaintenance = $settings->maintenance_mode;

        // ✅ تحديث الاسم واللون
        $settings->app_name = $request->input('app_name');
        $settings->primary_color = $request->input('primary_color');

        // ✅ تحديث وضع الصيانة حسب الطلب الجديد
        $newMaintenance = $request->boolean('maintenance_mode');
        $settings->maintenance_mode = $newMaintenance;

        // ✅ حذف الشعار لو تم اختياره
        if ($request->boolean('remove_logo')) {
            if ($settings->app_logo && Storage::disk('public')->exists($settings->app_logo)) {
                Storage::disk('public')->delete($settings->app_logo);
            }
            $settings->app_logo = null;
        }

        // ✅ رفع الشعار الجديد
        if ($request->hasFile('app_logo')) {
            if ($settings->app_logo && Storage::disk('public')->exists($settings->app_logo)) {
                Storage::disk('public')->delete($settings->app_logo);
            }
            $path = $request->file('app_logo')->store('logos', 'public');
            $settings->app_logo = $path;
        }

        // ✅ حذف الفاف ايقون لو تم اختياره
        if ($request->boolean('remove_favicon')) {
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $settings->favicon = null;
        }

        // ✅ رفع الفاف ايقون الجديد
        if ($request->hasFile('favicon')) {
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $path = $request->file('favicon')->store('favicons', 'public');
            $settings->favicon = $path;
        }

        $settings->save();

        // 🧠 إعادة تحميل القيم لتحديث الـ Singleton
        app()->forgetInstance(SystemSettings::class);
        $settings = app(SystemSettings::class);

        // ✅ تغيير وضع الصيانة فقط إذا اختلف عن السابق
        if ($previousMaintenance !== $newMaintenance) {
            if ($newMaintenance) {
                Artisan::call('down');
            } else {
                Artisan::call('up');
            }
        }

        return back()->with('success', '✅ تم تحديث الإعدادات بنجاح.');
    } catch (\Exception $e) {
        return back()->with('error', '❌ حدث خطأ أثناء تحديث الإعدادات: ' . $e->getMessage());
    }
}


}
