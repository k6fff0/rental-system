<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // ✅ استدعاء الـ GD Driver

class ImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ImageManager::class, function () {
            return new ImageManager(new Driver()); // ✅ مرر الـ Driver ككائن
        });
    }
}
