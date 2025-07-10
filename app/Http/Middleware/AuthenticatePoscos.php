<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticatePoscos
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('poscos')->check()) {
            return redirect()->route('poscos.login'); // sesuaikan route login
        }

        return $next($request);
    }
}

