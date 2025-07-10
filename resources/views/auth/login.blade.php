@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">

        {{-- Left Side - Login Form --}}
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-3xl font-bold mb-2">Login</h2>
            <p class="text-sm text-gray-600 mb-6">Welcome back! Please log in to your account.</p>

            {{-- Error Message --}}
            @if(session('error'))
                <div class="mb-4 text-sm text-red-600 bg-red-100 px-4 py-2 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 px-4 py-2 rounded">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block mb-1 font-medium text-sm text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email">
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block mb-1 font-medium text-sm text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password">
                </div>

                {{-- Remember Me --}}
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2 border-gray-300 rounded">
                    <label for="remember" class="text-sm text-gray-600">Remember Me</label>
                </div>

                {{-- Login Button --}}
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md transition">
                    Login
                </button>
            </form>

            {{-- Register Link --}}
            <div class="mt-4 text-sm text-center">
                Tidak punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar di sini</a>
            </div>
        </div>

        {{-- Right Side - Branding --}}
        <div class="hidden md:flex w-1/2 bg-indigo-600 text-white items-center justify-center p-8 relative">
            <div class="text-center">
                <img src="{{ asset('images/kip-logo.png') }}" alt="Logo Krakatau" class="mx-auto mb-4 w-24">
                <h2 class="text-2xl font-bold">Krakatau<br>International Port</h2>
            </div>
        </div>
    </div>
</div>
@endsection
