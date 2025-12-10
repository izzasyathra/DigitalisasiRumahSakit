<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Digital Hospital') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            .bg-gradient-modern {
                background: linear-gradient(135deg, #1e40af 0%, #701a75 100%); /* Biru ke Ungu Gelap */
            }
            .card-glass {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            }
            /* Warna Inputan biar serasi */
            .input-modern {
                background: rgba(255, 255, 255, 0.9);
                border: none;
                transition: all 0.3s ease;
            }
            .input-modern:focus {
                background: #ffffff;
                box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.5); /* Pink Glow */
            }
        </style>
    </head>
    
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-modern">
            
            {{-- Logo dan Judul --}}
            <div class="mb-6 text-center">
                <a href="/" class="flex flex-col items-center group">
                    <svg class="w-16 h-16 text-pink-400 group-hover:text-pink-300 transition duration-300 drop-shadow-md" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                    <h1 class="text-3xl font-bold text-white mt-2 tracking-wide drop-shadow-sm">
                        Digital Hospital
                    </h1>
                </a>
            </div>

            {{-- KOTAK KONTEN (GLASS) --}}
            <div class="w-full sm:max-w-md mt-4 px-8 py-8 card-glass rounded-2xl shadow-2xl overflow-hidden">
                {{ $slot }}
            </div>
            
            {{-- Footer Link --}}
            <div class="mt-6 text-center">
                <a href="/" class="text-sm text-gray-300 hover:text-white transition duration-300 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </body>
</html>