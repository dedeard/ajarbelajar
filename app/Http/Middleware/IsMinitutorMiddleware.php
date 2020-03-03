<?php

namespace App\Http\Middleware;

use Closure;

class IsMinitutorMiddleware
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
        if (!$request->user()->minitutor) {
            return redirect()->route('minitutor.join.index');
        }
        return $next($request);
    }
}
