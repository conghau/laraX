<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminAuthenticate {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin') {
        if (Auth::guard($guard)->check()) {
            return $next($request);
        }
        return redirect(Config::get('app.admin_path').'/auth/login');
    }
}
