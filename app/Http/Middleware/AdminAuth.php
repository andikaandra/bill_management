<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            return $next($request);
        }
        return redirect('/login');
    }
}
