<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Middleware\PreventRequestsDuringMaintenance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->singleton(
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        PreventRequestsDuringMaintenance::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ تحميل إعدادات النظام من config/settings.php
        if (File::exists(config_path('settings.php'))) {
            $settings = include config_path('settings.php');

            // ضم الإعدادات داخل config
            config(['settings' => $settings]);
        }

        // ✅ تفعيل اللغة من الجلسة
        app()->resolving(function () {
            $locale = Session::get('locale', config('app.locale'));

            if (in_array($locale, ['ar', 'en'])) {
                App::setLocale($locale);
            }
        });

        // ✅ تمرير بيانات الإشعارات لكل الواجهات
        View::composer('*', function ($view) {
            $user = auth()->user();

            $view->with([
                'unreadNotificationsCount' => $user ? $user->unreadNotifications()->count() : 0,
                'recentNotifications' => $user ? $user->notifications()->latest()->take(5)->get() : collect(),
            ]);
        });

        // ✅ ربط أي صلاحية جديدة تلقائيًا برول super-admin
        Permission::created(function ($permission) {
            $superAdmin = Role::where('name', 'super-admin')->first();

            if ($superAdmin && !$superAdmin->hasPermissionTo($permission->name)) {
                $superAdmin->givePermissionTo($permission);
            }
        });
    }
}
