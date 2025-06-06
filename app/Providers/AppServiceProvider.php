<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Http\UploadedFile;
use App\Services\ImageService;

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
    if (File::exists(config_path('settings.php'))) {
        $settings = include config_path('settings.php');
        config(['settings' => $settings]);
    }

    Paginator::useTailwind();

    app()->resolving(function () {
        $locale = Session::get('locale', config('app.locale'));
        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
        }
    });

    View::composer('*', function ($view) {
        $user = auth()->user();
        $view->with([
            'unreadNotificationsCount' => $user ? $user->unreadNotifications()->count() : 0,
            'recentNotifications' => $user ? $user->notifications()->latest()->take(5)->get() : collect(),
        ]);
    });

    Permission::created(function ($permission) {
        $superAdmin = Role::where('name', 'super-admin')->first();
        if ($superAdmin && !$superAdmin->hasPermissionTo($permission->name)) {
            $superAdmin->givePermissionTo($permission);
        }
    });

    // ✅ إضافة الماكرو الخاص برفع الصور وضغطها
    UploadedFile::macro('optimizeAndStore', function (string $folder, bool $withThumb = true) {
        $imageService = app(ImageService::class);
        return $imageService->storeAndOptimize($this, $folder, $withThumb);
    });
}

}
