<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    // Arahkan user ke dashboard setelah berhasil login
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {
        // Validasi input login (pakai email & password)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba login dengan guard default
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke halaman intended (default: /dashboard)
            return redirect()->intended($this->redirectTo);
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Tentukan field login yang digunakan (default: email)
     */
    public function username()
    {
        return 'email';
    }
}
