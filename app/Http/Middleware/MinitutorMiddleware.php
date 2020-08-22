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
    public function handle($request, Closure $next, $type = null)
    {
        $user = $request->user();
        if($user) {
            $minitutor = $user->minitutor;
            switch($type) {
                case "active":
                    if($minitutor && $minitutor->active) {
                        return $next($request);
                    }
                break;
                case "nonacive":
                    if($minitutor && !$minitutor->active) {
                        return $next($request);
                    }
                break;
                default :
                    if($minitutor) {
                        return $next($request);
                    }
                break;
            }
            return abort(403);
        } else {
            return abort(401);
        }
    }
}
