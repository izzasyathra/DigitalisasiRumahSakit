<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Publik | Digital Hospital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-hero {
            background-image: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #6366f1 100%);
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
                <a href="{{ route('login') }}" class="bg-indigo-500 hover:bg-indigo-600 px-4 py-2 rounded-lg font-semibold transition duration-300">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg font-semibold transition duration-300">Register</a>
                @endif
            </nav>
        </header>

        
            <main class="max-w-7xl mx-auto p-6 lg:p-8 pt-10">
    <h1 class="text-4xl font-extrabold mb-10 text-center">Layanan & Jadwal Dokter</h1>
    
    <section class="w-full mb-16">
        <h2 class="text-3xl font-bold mb-8 border-b border-gray-600 pb-2">Daftar Poli 🏥</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            
            @forelse ($polis as $poli)
                <div class="card-glass p-6 text-center transition duration-300 hover:scale-[1.02] cursor-pointer">
                    <div class="text-4xl mb-3">{{ $poli->icon_path ?? '🏥' }}</div>
                    
                    <h3 class="text-xl font-semibold mb-1">{{ $poli->name }}</h3> 
                    
                    <p class="text-gray-300 text-sm">{{ $poli->description }}</p>
                    
                    <a href="#dokter-poli-{{ $poli->id }}" class="text-pink-400 text-sm mt-2 block hover:underline">Lihat Dokter & Jadwal</a>
                </div>
            @empty
                <p class="text-gray-400 col-span-4 text-center">Data Poli belum tersedia di sistem.</p>
            @endforelse
            
        </div>
    </section>
    
    </main>
        
        <footer class="mt-20 p-4 text-center text-gray-400 border-t border-gray-700">
            </footer>
    </div>
</body>
</html>