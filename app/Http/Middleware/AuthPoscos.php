<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthPoscos
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('poscos')->check()) {
            return redirect()->route('poscos.login');
        }

        return $next($request);
    }
}

