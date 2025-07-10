<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoscosAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.poscos-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('poscos')->attempt($credentials)) {
            return redirect()->intended('/poscos/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }
}
