@extends('layouts.app')

@section('content')

<style>
    /* Animasi fade & slide */
    .fade-slide {
        animation: fadeSlide 1.2s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeSlide {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Glass Effect */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
</style>

{{-- BACKGROUND FULL --}}
<div class="min-h-screen w-full bg-gradient-to-br from-blue-900 via-slate-900 to-black text-white">

    {{-- NAVBAR --}}
    <nav class="w-full glass py-5 shadow-md">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold tracking-wide">Digital Hospital</h1>

            <div class="space-x-6 text-lg">
                <a href="{{ route('login') }}" class="hover:text-blue-300 transition">Login</a>
                <a href="{{ route('register') }}" class="hover:text-blue-300 transition">Register</a>
            </div>
        </div>
    </nav>

    {{-- WELCOME SECTION --}}
    <div class="container mx-auto mt-20 px-4 fade-slide">

        <div class="glass p-10 rounded-2xl shadow-xl text-center">
            <h2 class="text-4xl font-extrabold drop-shadow-lg">
                Selamat Datang di <span class="text-blue-300">Digital Hospital</span>
            </h2>
            <p class="text-gray-200 mt-3 text-lg">
                Sistem pelayanan kesehatan modern untuk pengalaman yang lebih mudah & cepat.
            </p>
        </div>

    </div>

    {{-- LIST POLI --}}
    <div class="container mx-auto mt-20 px-4 fade-slide" style="animation-delay: 0.6s;">
        <h3 class="text-3xl font-semibold mb-6">Daftar Poli</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach ($polis as $poli)
            <div class="glass p-6 rounded-xl shadow-lg hover:scale-105 transition transform">
                <h4 class="text-xl font-bold text-blue-300">{{ $poli->name }}</h4>
                <p class="text-gray-200 mt-2">{{ $poli->description }}</p>
            </div>
            @endforeach

        </div>
    </div>

    <div class="h-20"></div>

</div>

@endsection
