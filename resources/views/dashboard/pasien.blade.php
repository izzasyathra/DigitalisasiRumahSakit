<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard Pasien: {{ Auth::user()->name }} 🏥
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-[calc(100vh-64px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2 space-y-6">

                    <div class="bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg">
                        <h3 class="text-2xl font-bold text-indigo-400 mb-4 flex justify-between items-center">
                            Status Janji Temu Terakhir
                            <a href="{{ route('pasien.appointments.my') }}" class="text-sm font-normal text-pink-400 hover:underline">Lihat Semua</a>
                        </h3>
                        
                        @if ($latestAppointment)
                            @php
                                $status = $latestAppointment->status;
                                $statusClass = [
                                    'Pending' => 'bg-yellow-500',
                                    'Approved' => 'bg-green-500',
                                    'Rejected' => 'bg-red-500',
                                    'Selesai' => 'bg-blue-500',
                                ][$status] ?? 'bg-gray-500';
                            @endphp
                            
                            <div class="p-4 border border-gray-700 rounded-lg">
                                <span class="{{ $statusClass }} text-white text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block">{{ $status }}</span>
                                
                                <p class="text-lg text-white mt-1">
                                    Dengan: <span class="font-semibold text-green-300">Dr. {{ $latestAppointment->doctor?->name ?? 'N/A' }}</span>
                                </p>
                                <p class="text-sm text-gray-400">Poli: {{ $latestAppointment->doctor?->poli?->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-400">Tanggal: {{ \Carbon\Carbon::parse($latestAppointment->booking_date)->format('d F Y') }}</p>
                            </div>
                        @else
                            <div class="text-center py-4 border border-gray-700 rounded-lg">
                                <p class="text-gray-400">Anda belum memiliki janji temu.</p>
                                <a href="{{ route('pasien.appointments.create') }}" class="btn-primary-custom text-sm mt-3 inline-block">
                                    Buat Janji Temu Baru
                                </a>
                            </div>
                        @endif

                    </div>

                    <div class="bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg">
                        <h3 class="text-2xl font-bold text-green-400 mb-4 flex justify-between items-center">
                            Riwayat 5 Rekam Medis Terakhir
                            <a href="{{ route('pasien.rm.my') }}" class="text-sm font-normal text-pink-400 hover:underline">Lihat Detail</a>
                        </h3>
                        
                        <div class="space-y-3">
                            @forelse ($medicalRecords as $record)
                                <div class="p-3 bg-gray-700/50 rounded-lg border-l-4 border-green-500">
                                    <p class="font-semibold text-white">Diagnosis: {{ Str::limit($record->diagnosis, 50) }}</p>
                                    <p class="text-xs text-gray-400">Tgl: {{ $record->created_at->format('d M Y') }} | Dokter: {{ $record->doctor?->name ?? 'N/A' }}</p>
                                </div>
                            @empty
                                <p class="text-gray-400">Belum ada riwayat rekam medis yang tercatat.</p>
                            @endforelse
                        </div>
                    </div>

                </div> <div class="md:col-span-1 space-y-6">

                    <div class="bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg">
                        <h3 class="text-lg font-bold text-indigo-400 mb-4">Janji Temu Mendatang (Approved)</h3>
                        @forelse ($upcomingAppointments as $appointment)
                            <div class="p-3 bg-indigo-900/50 border border-indigo-500 rounded-lg mb-2">
                                <p class="text-white font-semibold">Dr. {{ $appointment->doctor?->name ?? 'N/A' }}</p>
                                <p class="text-xs text-indigo-300">{{ \Carbon\Carbon::parse($appointment->booking_date)->format('d M Y') }}</p>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm">Tidak ada janji temu mendatang.</p>
                        @endforelse
                    </div>

                    <div class="bg-gray-800 card-glass p-6 overflow-hidden shadow-xl rounded-lg">
                        <h3 class="text-lg font-bold text-purple-400 mb-4">Aksi Cepat</h3>
                        <a href="{{ route('pasien.appointments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 w-full block text-center mb-3">
                            Buat Janji Temu Baru
                        </a>
                        <a href="{{ route('pasien.rm.my') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 w-full block text-center">
                            Lihat Riwayat Perawatan
                        </a>
                    </div>
                </div> </div>
        </div>
    </div>
</x-app-layout>