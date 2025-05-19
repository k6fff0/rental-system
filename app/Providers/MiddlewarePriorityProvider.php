<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Http\Middleware\ForceWebGuard;

class MiddlewarePriorityProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('middleware.priority', function () {
            return [
                // 🟢 حط ForceWebGuard فوق الـ Permission middleware
                ForceWebGuard::class,
                ValidateCsrfToken::class,
                ThrottleRequests::class,
                HandlePrecognitiveRequests::class,
            ];
        });
    }
}
