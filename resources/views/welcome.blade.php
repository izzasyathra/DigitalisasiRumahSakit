<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Hospital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Pastikan background mencakup seluruh halaman */
        .bg-hero {
            background-image: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #6366f1 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="antialiased">

    <div class="bg-hero text-white min-h-screen">
        
        <header class="p-6 flex justify-between items-center max-w-7xl mx-auto">
    
    <div class="text-2xl font-bold flex items-center">
        <svg class="w-6 h-6 mr-2 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
        </svg>
        Digital Hospital
    </div>

    <nav class="flex items-center space-x-4">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg font-semibold transition duration-300">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="bg-indigo-500 hover:bg-indigo-600 px-4 py-2 rounded-lg font-semibold transition duration-300">Log in</a>
                
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg font-semibold transition duration-300">Register</a>
                @endif
                
                <a href="{{ route('guest.index') }}" class="text-white opacity-75 hover:opacity-100 transition duration-300 text-sm ml-2">Lanjutkan sebagai Tamu</a>
            @endauth
        @endif
    </nav>
</header>

        <main class="max-w-7xl mx-auto p-6 lg:p-8 flex flex-col items-center text-center pt-20">
            <div class="card-glass p-10 max-w-3xl animate-pulse-slow">
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight">
                    Selamat Datang di <span class="text-pink-400">Digital Hospital</span>
                </h1>
                <p class="text-xl mb-8 text-gray-200">
                    Sistem pelayanan kesehatan modern untuk pengalaman yang lebih mudah & cepat.
                </p>
                <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="btn-primary-custom text-lg px-8 py-3">
                    Buat Janji Temu Sekarang
                </a>
            </div>

            <section class="mt-20 w-full">
                <h2 class="text-3xl font-bold mb-8">Daftar Poli</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @php
                        $polis = [
                            ['name' => 'Poli Umum', 'icon' => '🩺', 'desc' => 'Layanan kesehatan umum.'],
                            ['name' => 'Poli Gigi', 'icon' => '🦷', 'desc' => 'Spesialis perawatan gigi.'],
                            ['name' => 'Poli Anak', 'icon' => '🧸', 'desc' => 'Kesehatan dan tumbuh kembang anak.'],
                        ];
                    @endphp
                    
                    @foreach ($polis as $poli)
                        <div class="card-glass p-6 text-center transition duration-300 hover:scale-[1.02] cursor-pointer">
                            <div class="text-4xl mb-3">{{ $poli['icon'] }}</div>
                            <h3 class="text-xl font-semibold mb-1">{{ $poli['name'] }}</h3>
                            <p class="text-gray-300 text-sm">{{ $poli['desc'] }}</p>
                            <a href="#" class="text-pink-400 text-sm mt-2 block hover:underline">Lihat Dokter</a>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>
        
        <footer class="mt-20 p-4 text-center text-gray-400 border-t border-gray-700">
            © {{ date('Y') }} Digital Hospital. All rights reserved. | <a href="#" class="hover:text-white">Tentang Kami</a> | <a href="#" class="hover:text-white">Kontak</a>
        </footer>
    </div>

    <style>
        @keyframes pulse-slow {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 0 40px rgba(99, 102, 241, 0.5); /* Glowing effect */
            }
        }
        .animate-pulse-slow {
            animation: pulse-slow 8s infinite ease-in-out;
        }
    </style>
</body>
</html>