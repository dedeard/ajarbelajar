<?php

namespace App\Http\Middleware;

use Closure;

class NotMinitutorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->minitutor) {
            return abort(403);
        }
        return $next($request);
    }
}
