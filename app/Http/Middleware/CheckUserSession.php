<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserSession
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
