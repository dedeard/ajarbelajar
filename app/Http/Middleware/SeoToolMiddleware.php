<?php

namespace App\Http\Middleware;

use App\Helpers\Seo;
use Closure;
use Route;
class SeoToolMiddleware
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
        if(!Route::is('post.show') && !Route::is('admin*') && !Route::is('category.show')) {
            Seo::set($request->path());
        }
        return $next($request);
    }
}
