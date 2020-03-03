<?php

namespace App\Http\Middleware;

use Closure;

class MinitutorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $active)
    {   
        if($active === 'active') {
            if (!$request->user()->minitutor->active) {
                return redirect()->route('dashboard.index');
            }
        } else {
            if ($request->user()->minitutor->active) {
                return redirect()->route('minitutor.index');
            }
        }
        return $next($request);
    }
}
