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
            'system_email' => 'required|email',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'default_contract_terms' => 'required|string',
            'app_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'favicon' => 'nullable|mimes:ico,png,jpg,jpeg|max:1024',

        ]);

        try {
            /** ✅ الطريقة الصح من Spatie */
            $settings = resolve(SystemSettings::class);

            // 🟢 النصوص والألوان
            $settings->app_name = $request->input('app_name');
            $settings->system_email = $request->input('system_email');
            $settings->primary_color = $request->input('primary_color');
            $settings->secondary_color = $request->input('secondary_color');
            $settings->default_contract_terms = $request->input('default_contract_terms');
            $settings->maintenance_mode = $request->boolean('maintenance_mode');

            // 🟢 حذف اللوجو
            if ($request->boolean('remove_logo') && $settings->app_logo) {
                Storage::disk('public')->delete($settings->app_logo);
                $settings->app_logo = null;
            }

            // 🟢 رفع لوجو جديد
            if ($request->hasFile('app_logo')) {
                if ($settings->app_logo) {
                    Storage::disk('public')->delete($settings->app_logo);
                }
                $settings->app_logo = $request->file('app_logo')->store('logos', 'public');
            }

            // 🟢 حذف الفاف ايقون
            if ($request->boolean('remove_favicon') && $settings->favicon) {
                Storage::disk('public')->delete($settings->favicon);
                $settings->favicon = null;
            }

            // 🟢 رفع فاف ايقون جديد
            if ($request->hasFile('favicon')) {
                if ($settings->favicon) {
                    Storage::disk('public')->delete($settings->favicon);
                }
                $settings->favicon = $request->file('favicon')->store('favicons', 'public');
            }

            // 🧠 حفظ التعديلات
            $settings->save();

            // 🧠 إعادة تحميل instance جديدة بعد الحفظ
            app()->forgetInstance(SystemSettings::class);

            // 🛠️ لو وضع الصيانة اختلف نفذه
            if ($settings->maintenance_mode) {
                Artisan::call('down');
            } else {
                Artisan::call('up');
            }

            return back()->with('success', '✅ تم تحديث إعدادات النظام بنجاح.');
        } catch (\Throwable $e) {
            return back()->with('error', '❌ حصل خطأ: ' . $e->getMessage());
        }
    }
}
