<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceWebGuard
{
    public function handle(Request $request, Closure $next)
    {
        auth()->shouldUse('web'); // 💥 ده اللي بيخلّي Laravel يقرأ الصلاحيات من الجارد الصح
        return $next($request);
    }
}
