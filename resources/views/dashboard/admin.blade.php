<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard Admin 📊
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-[calc(100vh-64px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="md:col-span-1 bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg text-center">
                    <p class="text-4xl font-extrabold text-indigo-400">{{ $totalUsers ?? 0 }}</p>
                    <h3 class="text-lg text-gray-300 mt-2">Total Pengguna</h3>
                </div>

                <div class="md:col-span-1 bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg text-center">
                    <p class="text-4xl font-extrabold text-red-400">{{ $pendingAppointmentsCount ?? 0 }}</p>
                    <h3 class="text-lg text-gray-300 mt-2">Janji Temu Pending</h3>
                </div>

                <div class="md:col-span-1 bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg text-center">
                    <p class="text-4xl font-extrabold text-green-400">{{ $totalDoctors ?? 0 }}</p>
                    <h3 class="text-lg text-gray-300 mt-2">Total Dokter</h3>
                </div>

                <div class="md:col-span-1 bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg text-center">
                    <p class="text-4xl font-extrabold text-pink-400">📊</p>
                    <h3 class="text-lg text-gray-300 mt-2">Laporan & Analitik</h3>
                </div>
            </div>

            <div class="mt-8 bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg">
                <h3 class="text-2xl font-bold text-white mb-4 border-b border-gray-700 pb-2">Validasi Janji Temu Terbaru</h3>
                
                <table class="min-w-full leading-normal text-gray-300">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wider text-left text-indigo-400 uppercase border-b border-gray-700">
                            <th class="px-5 py-3">Pasien</th>
                            <th class="px-5 py-3">Dokter</th>
                            <th class="px-5 py-3">Tgl Booking</th>
                            <th class="px-5 py-3">Keluhan</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestPending as $appointment)
                            <tr class="border-b border-gray-700 hover:bg-gray-700 transition duration-150">
                                <td class="px-5 py-5 text-sm">{{ $appointment->patient->name }}</td>
                                <td class="px-5 py-5 text-sm text-green-300">{{ $appointment->doctor->name }}</td>
                                <td class="px-5 py-5 text-sm">{{ \Carbon\Carbon::parse($appointment->booking_date)->format('d M Y') }}</td>
                                <td class="px-5 py-5 text-sm text-gray-400">{{ Str::limit($appointment->short_complaint ?? 'N/A', 30) }}</td>
                                <td class="px-5 py-5 text-sm text-center">
                                    <button class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded">Approve</button>
                                    <button class="bg-red-700 hover:bg-red-800 text-white text-xs px-3 py-1 rounded ml-1">Reject</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-gray-400">Semua janji temu sudah divalidasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>