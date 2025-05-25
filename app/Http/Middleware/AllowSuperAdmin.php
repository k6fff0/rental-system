<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowSuperAdmin
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return $next($request);
        }

        if (!auth()->user()?->can($permission)) {
            abort(403, __('messages.permission_denied') ?? 'لا تملك الصلاحية.');
        }

        return $next($request);
    }
}
