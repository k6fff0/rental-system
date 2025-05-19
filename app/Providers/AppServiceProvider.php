<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ تفعيل اللغة من الجلسة
        app()->resolving(function () {
            $locale = Session::get('locale', config('app.locale'));

            if (in_array($locale, ['ar', 'en'])) {
                App::setLocale($locale);
            }
        });

        // ✅ تمرير بيانات الإشعارات للنافبار تلقائيًا
        View::composer('layouts.navigation', function ($view) {
            $user = auth()->user();
            $view->with([
                'unreadNotificationsCount' => $user?->unreadNotifications()->count() ?? 0,
                'recentNotifications' => $user?->notifications()->take(5)->get() ?? collect()
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
