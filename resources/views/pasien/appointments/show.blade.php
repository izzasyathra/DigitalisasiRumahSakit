@extends('layouts.app')

@section('title', 'Detail Janji Temu')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Janji Temu</h1>
                <p class="text-blue-100">ID: #{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div>
                @if($appointment->status == 'pending')
                    <span class="px-6 py-3 bg-yellow-500 text-white rounded-lg text-lg font-bold">Pending</span>
                @elseif($appointment->status == 'approved')
                    <span class="px-6 py-3 bg-green-500 text-white rounded-lg text-lg font-bold">Disetujui</span>
                @elseif($appointment->status == 'rejected')
                    <span class="px-6 py-3 bg-red-500 text-white rounded-lg text-lg font-bold">Ditolak</span>
                @else
                    <span class="px-6 py-3 bg-blue-500 text-white rounded-lg text-lg font-bold">Selesai</span>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Dokter</h2>
        <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg">
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-md text-4xl text-white"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $appointment->dokter->username }}</h3>
                <p class="text-blue-600 font-semibold">{{ $appointment->dokter->poli->nama ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Jadwal Konsultasi</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="p-4 bg-green-50 rounded-lg text-center">
                <p class="text-sm text-gray-600">Tanggal</p>
                <p class="font-bold text-gray-800">{{ $appointment->tanggal_booking->format('d F Y') }}</p>
            </div>
            <div class="p-4 bg-green-50 rounded-lg text-center">
                <p class="text-sm text-gray-600">Waktu</p>
                <p class="font-bold text-gray-800">{{ date('H:i', strtotime($appointment->jadwal->jam_mulai)) }}</p>
            </div>
            <div class="p-4 bg-green-50 rounded-lg text-center">
                <p class="text-sm text-gray-600">Hari</p>
                <p class="font-bold text-gray-800">{{ $appointment->jadwal->hari }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Keluhan Pasien</h2>
        <div class="p-4 bg-purple-50 rounded-lg">
            <p class="text-gray-800">{{ $appointment->keluhan }}</p>
        </div>
    </div>

    @if($appointment->status == 'rejected' && $appointment->alasan_reject)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-red-500">
        <h2 class="text-xl font-bold text-red-700 mb-4">Alasan Penolakan</h2>
        <p class="text-red-800">{{ $appointment->alasan_reject }}</p>
    </div>
    @endif

    <div class="flex space-x-3">
        <a href="{{ route('pasien.appointments.index') }}" 
           class="flex-1 bg-gray-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-gray-700 text-center">
            Kembali
        </a>

        @if($appointment->status == 'pending')
        <form action="{{ route('pasien.appointments.cancel', $appointment->id) }}" 
              method="POST" 
              class="flex-1"
              onsubmit="return confirm('Yakin ingin batalkan?')">
            @csrf
            <button type="submit" 
                    class="w-full bg-red-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-red-700">
                Batalkan Janji
            </button>
        </form>
        @endif
    </div>
</div>
@endsection