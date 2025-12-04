<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Publik | Digital Hospital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-hero {
            /* Pastikan Anda sudah mendefinisikan .bg-gradient-modern atau menggunakan definisi ini */
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
            <h1 class="text-5xl font-extrabold mb-10 text-center tracking-wide">Layanan & Jadwal Dokter</h1>
            
            <section class="w-full mb-16">
                <h2 class="text-3xl font-bold mb-8 border-b border-gray-600 pb-2">Daftar Poli 🏥</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    
                    @php
                        // Dummy data jika variabel $polis dari controller kosong
                        $polis = $polis ?? collect([
                            (object)['id' => 1, 'name' => 'Poli Umum', 'description' => 'Layanan kesehatan umum.', 'icon_path' => '🩺'],
                            (object)['id' => 2, 'name' => 'Poli Gigi', 'description' => 'Spesialis perawatan gigi.', 'icon_path' => '🦷'],
                            (object)['id' => 3, 'name' => 'Poli Anak', 'description' => 'Kesehatan dan tumbuh kembang anak.', 'icon_path' => '🧸'],
                            (object)['id' => 4, 'name' => 'Poli Mata', 'description' => 'Pemeriksaan mata dan visus.', 'icon_path' => '👓'],
                        ]);
                    @endphp
                    
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
            
            <section class="w-full">
                <h2 class="text-3xl font-bold mb-8 border-b border-gray-600 pb-2">Dokter Tersedia 🧑‍⚕️</h2>
                
                @php
                    // Dummy data untuk Doctor jika variabel $doctors dari controller kosong
                    $doctors = $doctors ?? collect([
                        (object)['id' => 1, 'name' => 'Dr. Budi Santoso', 'poli_name' => 'Poli Umum', 'schedules' => [(object)['day' => 'Senin', 'time' => '09:00 - 12:00']]],
                        (object)['id' => 2, 'name' => 'Dr. Rina Wati', 'poli_name' => 'Poli Gigi', 'schedules' => [(object)['day' => 'Selasa', 'time' => '10:00 - 13:00']]],
                    ]);
                @endphp
                
                <div class="space-y-8">
                    @forelse ($doctors as $doctor)
                        <div id="dokter-{{ $doctor->id }}" class="card-glass p-6 flex flex-col md:flex-row gap-6 transition duration-300 hover:shadow-lg hover:shadow-indigo-500/30">
                            <div class="md:w-1/4 text-center border-b md:border-b-0 md:border-r border-gray-700 pb-4 md:pb-0 md:pr-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($doctor->name) }}&background=6366f1&color=fff&size=80&rounded=true" alt="{{ $doctor->name }}" class="rounded-full mx-auto mb-3">
                                <h4 class="text-xl font-semibold">{{ $doctor->name }}</h4>
                                <p class="text-pink-400">{{ $doctor->poli_name ?? 'Spesialis' }}</p>
                            </div>

                            <div class="md:w-3/4">
                                <h4 class="text-lg font-bold mb-3">Jadwal Praktik:</h4>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                    @foreach ($doctor->schedules as $schedule)
                                        <div class="flex justify-between items-center bg-white/10 p-2 rounded">
                                            <span class="font-medium text-indigo-300">{{ $schedule->day }}</span>
                                            <span class="text-white">{{ $schedule->time }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 text-right">
                                    <a href="{{ route('register') }}" class="btn-primary-custom text-sm px-4 py-2">
                                        Booking Janji Temu (Login Wajib)
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 col-span-4 text-center">Tidak ada dokter yang terdaftar saat ini.</p>
                    @endforelse
                </div>

            </section>

        </main>
        
        <footer class="mt-20 p-4 text-center text-gray-400 border-t border-gray-700">
            © {{ date('Y') }} Digital Hospital. All rights reserved. | <a href="#" class="hover:text-white">Tentang Kami</a> | <a href="#" class="hover:text-white">Kontak</a>
        </footer>
    </div>
</body>
</html>