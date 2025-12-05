@extends('layouts.app')

@section('title', 'Konfirmasi Janji Temu')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-3xl font-bold mb-2">
            <i class="fas fa-check-circle"></i> Konfirmasi Janji Temu
        </h1>
        <p class="text-blue-100">Pastikan data sudah benar sebelum melakukan booking</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pasien.appointments.store') }}" method="POST">
            @csrf

            <input type="hidden" name="dokter_id" value="{{ $dokter->id }}">
            <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

            <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-600">Dokter:</p>
                <p class="font-bold text-gray-800 text-lg">{{ $dokter->username }}</p>
                <p class="text-sm text-blue-600">{{ $dokter->poli->nama ?? 'N/A' }}</p>
            </div>

            <div class="mb-4 p-4 bg-green-50 rounded-lg">
                <p class="text-sm text-gray-600">Jadwal:</p>
                <p class="font-bold text-gray-800">{{ $jadwal->hari }}</p>
                <p class="text-sm text-green-600">{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Tanggal Konsultasi <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="tanggal_booking" 
                       value="{{ old('tanggal_booking', date('Y-m-d')) }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Keluhan / Gejala <span class="text-red-500">*</span>
                </label>
                <textarea name="keluhan" 
                          rows="5" 
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Jelaskan keluhan Anda..."
                          required>{{ old('keluhan') }}</textarea>
            </div>

            <div class="flex space-x-3">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    <i class="fas fa-check-circle"></i> Konfirmasi Booking
                </button>
                <a href="{{ route('pasien.appointments.select-poli') }}" 
                   class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 text-center">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection