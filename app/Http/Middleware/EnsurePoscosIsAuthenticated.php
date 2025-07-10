<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsurePoscosIsAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('poscos')->check()) {
            return redirect('/poscos/login'); // route login khusus poscos
        }

        return $next($request);
    }
}

