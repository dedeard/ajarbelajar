<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuardSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $defaultGuard = null): Response
    {
        if (in_array($defaultGuard, array_keys(config('auth.guards')))) {
            config(['auth.defaults.guard' => $defaultGuard]);
        }

        return $next($request);
    }
}
