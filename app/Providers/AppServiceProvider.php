<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

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
    }
}
