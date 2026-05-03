<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (session()->has('user')) {
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
