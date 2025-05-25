<?php

namespace App\Http\Middleware;

use Closure;
use ErrorException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\MaintenanceModeBypassCookie;
use Illuminate\Foundation\Http\Middleware\Concerns\ExcludesPaths;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PreventRequestsDuringMaintenance
{
    use ExcludesPaths;

    protected $app;
    protected $except = [];
    protected static $neverPrevent = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {
        if ($this->inExceptArray($request)) {
            return $next($request);
        }

        if ($this->app->maintenanceMode()->active()) {
            try {
                $data = $this->app->maintenanceMode()->data();
            } catch (ErrorException $exception) {
                if (! $this->app->maintenanceMode()->active()) {
                    return $next($request);
                }
                throw $exception;
            }

            // 🧠 نفك الجلسة يدويًا من الكوكي
            $laravelSession = $request->cookie(config('session.cookie'));

            if ($laravelSession) {
                try {
                    $sessionId = Crypt::decrypt($laravelSession);

                    $sessionRow = DB::table(config('session.table', 'sessions'))
                        ->where('id', $sessionId)
                        ->first();

                    if ($sessionRow && isset($sessionRow->user_id)) {
                        $user = \App\Models\User::find($sessionRow->user_id);

                        if ($user && $user->email === 'admin@corvita.net') {
                            return $next($request);
                        }
                    }
                } catch (\Exception $e) {
                    // لو فشل فك التشفير، كمل طبيعي واديه 503
                }
            }

            if (isset($data['template'])) {
                return response(
                    $data['template'],
                    $data['status'] ?? 503,
                    $this->getHeaders($data)
                );
            }

            throw new HttpException(
                $data['status'] ?? 503,
                'Service Unavailable',
                null,
                $this->getHeaders($data)
            );
        }

        return $next($request);
    }

    protected function getHeaders($data)
    {
        $headers = isset($data['retry']) ? ['Retry-After' => $data['retry']] : [];

        if (isset($data['refresh'])) {
            $headers['Refresh'] = $data['refresh'];
        }

        return $headers;
    }
}
