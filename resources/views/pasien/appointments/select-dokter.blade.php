@extends('layouts.app')

@section('title', 'Pilih Dokter')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-user-md"></i> Pilih Dokter
                </h1>
                <p class="text-blue-100">{{ $poli->nama }}</p>
            </div>
            <a href="{{ route('pasien.appointments.select-poli') }}" 
               class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @forelse($dokters as $dokter)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center space-x-4 mb-4">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-md text-3xl text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $dokter->username }}</h3>
                <p class="text-gray-600">
                    <i class="fas fa-hospital"></i> {{ $dokter->poli->nama ?? 'N/A' }}
                </p>
                @if($dokter->phone)
                <p class="text-sm text-gray-500">
                    <i class="fas fa-phone"></i> {{ $dokter->phone }}
                </p>
                @endif
            </div>
        </div>

        <div class="border-t pt-4">
            <h4 class="font-bold text-gray-800 mb-3">
                <i class="fas fa-calendar-alt text-blue-600"></i> Jadwal Praktik:
            </h4>
            
            @if($dokter->schedules->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($dokter->schedules as $schedule)
                <a href="{{ route('pasien.appointments.create') }}?dokter_id={{ $dokter->id }}&jadwal_id={{ $schedule->id }}"
                   class="block p-4 bg-blue-50 border-2 border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-400 transition">
                    <div class="text-center">
                        <p class="font-bold text-gray-800 text-lg">{{ $schedule->hari }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            <i class="fas fa-clock"></i> {{ date('H:i', strtotime($schedule->jam_mulai)) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Durasi: {{ $schedule->durasi }} menit
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                <i class="fas fa-calendar-times text-gray-400 text-3xl mb-2"></i>
                <p class="text-gray-600">Tidak ada jadwal tersedia</p>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-user-md-slash text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-600 mb-2">Tidak Ada Dokter Tersedia</h3>
        <p class="text-gray-500 mb-4">Belum ada dokter di poli ini</p>
        <a href="{{ route('pasien.appointments.select-poli') }}" 
           class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
            <i class="fas fa-arrow-left"></i> Pilih Poli Lain
        </a>
    </div>
    @endforelse
</div>
@endsection