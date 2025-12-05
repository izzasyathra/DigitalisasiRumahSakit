@extends('layouts.app')

@section('title', 'Login - Hospital System')

@section('content')
<div class="max-w-md mx-auto py-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <i class="fas fa-hospital text-5xl text-blue-600 mb-4"></i>
            <h2 class="text-3xl font-bold text-gray-800">Login</h2>
            <p class="text-gray-600 mt-2">Silakan login untuk melanjutkan</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                           placeholder="nama@email.com"
                           required>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                           placeholder="Masukkan password"
                           required>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="remember" 
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-gray-700 text-sm">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i> 
                Login
            </button>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Atau</span>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-green-600 hover:underline font-semibold">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
            </p>
            <p class="text-gray-600 mt-3">
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> 
                    Kembali ke Beranda
                </a>
            </p>
        </div>

        <!-- Demo Credentials Info (Optional - hapus di production) -->
        <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-sm text-gray-600 font-semibold mb-2">
                <i class="fas fa-info-circle text-blue-500"></i> Demo Akun:
            </p>
            <div class="text-xs text-gray-600 space-y-1">
                <p><strong>Admin:</strong> admin@hospital.com / password</p>
                <p><strong>Dokter:</strong> budi@hospital.com / password</p>
                <p><strong>Pasien:</strong> pasien1@email.com / password</p>
            </div>
        </div>
    </div>
</div>
@endsection