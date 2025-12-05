@extends('layouts.app')

@section('title', 'Riwayat Janji Temu')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-calendar-alt"></i> Riwayat Janji Temu
                </h1>
                <p class="text-blue-100">Kelola dan lihat semua janji temu Anda</p>
            </div>
            <a href="{{ route('pasien.appointments.select-poli') }}" 
               class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50">
                <i class="fas fa-plus-circle"></i> Buat Janji Baru
            </a>
        </div>
    </div>

    @forelse($appointments as $appointment)
    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-3xl text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $appointment->dokter->username }}</h3>
                        <p class="text-gray-600">{{ $appointment->dokter->poli->nama ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-gray-600">
                        <i class="fas fa-calendar"></i> {{ $appointment->tanggal_booking->format('d F Y') }}
                        - <i class="fas fa-clock"></i> {{ date('H:i', strtotime($appointment->jadwal->jam_mulai)) }}
                    </p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 font-semibold">Keluhan:</p>
                    <p class="text-gray-800">{{ Str::limit($appointment->keluhan, 150) }}</p>
                </div>
            </div>

            <div class="ml-6 text-right">
                @if($appointment->status == 'pending')
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold inline-block mb-4">
                        Pending
                    </span>
                @elseif($appointment->status == 'approved')
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold inline-block mb-4">
                        Disetujui
                    </span>
                @elseif($appointment->status == 'rejected')
                    <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold inline-block mb-4">
                        Ditolak
                    </span>
                @else
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold inline-block mb-4">
                        Selesai
                    </span>
                @endif

                <div class="space-y-2">
                    <a href="{{ route('pasien.appointments.show', $appointment->id) }}" 
                       class="block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 text-center">
                        Detail
                    </a>

                    @if($appointment->status == 'pending')
                    <form action="{{ route('pasien.appointments.cancel', $appointment->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin batalkan?')">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700">
                            Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Janji Temu</h3>
        <a href="{{ route('pasien.appointments.select-poli') }}" 
           class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 mt-4">
            Buat Janji Temu
        </a>
    </div>
    @endforelse

    @if($appointments->hasPages())
    <div class="mt-6">
        {{ $appointments->links() }}
    </div>
    @endif
</div>
@endsection