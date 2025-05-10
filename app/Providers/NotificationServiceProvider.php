<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.navbar', function ($view) {
            $view->with([
                'unreadNotificationsCount' => auth()->user()->unreadNotifications()->count(),
                'recentNotifications' => auth()->user()->notifications()->take(5)->get()
            ]);
        });
    }
}
