<?php

namespace App\Http\Middleware;

use Closure;

class LaraXMV
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
        $themeName = \Session::get('themeName', 'laraX');
        if(\Theme::exists($themeName))
            \Theme::set($themeName);
        return $next($request);
    }
}
