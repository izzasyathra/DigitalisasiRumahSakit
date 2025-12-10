<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a { text-decoration: none; }
    </style>
</head>
<body class="font-sans antialiased bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="fas fa-hospital-alt me-2"></i> {{ config('app.name', 'Hospital System') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.home') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.poli.index') ? 'active fw-bold text-primary' : '' }}" href="{{ route('guest.poli.index') }}">Daftar Poli</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.doctor.index') ? 'active fw-bold text-primary' : '' }}" href="{{ route('guest.doctor.index') }}">Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.schedules.index') ? 'active fw-bold text-primary' : '' }}" href="{{ route('guest.schedules.index') }}">Jadwal</a>
                    </li>
                    
                    <li class="nav-item ms-lg-3">
                        @auth
                            {{-- Jika sudah login, arahkan ke Dashboard sesuai Role --}}
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm rounded-pill px-4">Dashboard</a>
                            @elseif(Auth::user()->role == 'dokter')
                                <a href="{{ route('doctor.dashboard') }}" class="btn btn-primary btn-sm rounded-pill px-4">Dashboard</a>
                            @else
                                <a href="{{ route('patient.dashboard') }}" class="btn btn-primary btn-sm rounded-pill px-4">Dashboard</a>
                            @endif
                        @else
                            {{-- Jika belum login --}}
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3">Daftar</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <h5 class="fw-bold mb-3">{{ config('app.name', 'Hospital System') }}</h5>
            <p class="small text-white-50 mb-0">
                &copy; {{ date('Y') }} All rights reserved. <br>
                Jl. Kesehatan No. 123, Kota Sehat.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>