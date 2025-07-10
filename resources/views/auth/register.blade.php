@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">

        {{-- Left - Register Form --}}
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-3xl font-bold mb-2">Register</h2>
            <p class="text-sm text-gray-600 mb-6">Buat akun baru Anda di sini.</p>

            {{-- Flash success message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Display validation errors --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Terjadi kesalahan:</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Username --}}
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Username">
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="example@email.com">
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Password">
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Ulangi Password">
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md transition">
                    Daftar
                </button>
            </form>

            <div class="mt-4 text-sm text-center">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold">Login</a>
            </div>
        </div>

        {{-- Right - Logo Branding --}}
        <div class="hidden md:flex w-1/2 bg-indigo-600 text-white items-center justify-center p-8 relative">
            <div class="text-center">
                <img src="{{ asset('images/kip-logo.png') }}" alt="Logo Krakatau" class="mx-auto mb-4 w-24">
                <h2 class="text-2xl font-bold">Krakatau<br>International Port</h2>
            </div>
        </div>
    </div>
</div>
@endsection
