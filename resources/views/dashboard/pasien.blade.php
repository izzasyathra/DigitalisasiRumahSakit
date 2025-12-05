@extends('layouts.app')

@section('title', 'Dashboard Pasien')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-hand-wave"></i> Selamat Datang, {{ auth()->user()->username }}!
                </h1>
                <p class="text-blue-100">Dashboard Pasien - Kelola kesehatan Anda dengan mudah</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-circle text-6xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Appointments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Janji Temu</p>
                    <h3 class="text-3xl font-bold text-gray-800">
                        {{ $latestAppointment ? auth()->user()->appointmentsAsPasien->count() : 0 }}
                    </h3>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-calendar-check text-3xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Approved Appointments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Janji Disetujui</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $approvedAppointments->count() }}</h3>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-check-circle text-3xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Medical Records -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Rekam Medis</p>
                    <h3 class="text-3xl font-bold text-purple-600">{{ $medicalRecords->count() }}</h3>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <i class="fas fa-file-medical text-3xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Appointment Status -->
    @if($latestAppointment)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-calendar-alt text-blue-600"></i> Status Janji Temu Terakhir
        </h2>
        
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div class="flex-1">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $latestAppointment->dokter->username }}</h3>
                        <p class="text-sm text-gray-600">{{ $latestAppointment->dokter->poli->nama ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-calendar"></i> {{ $latestAppointment->tanggal_booking->format('d M Y') }}
                            - <i class="fas fa-clock"></i> {{ $latestAppointment->jadwal->jam_mulai }}
                        </p>
                    </div>
                </div>
            </div>
            <div>
                @if($latestAppointment->status == 'pending')
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                        <i class="fas fa-hourglass-half"></i> Menunggu Konfirmasi
                    </span>
                @elseif($latestAppointment->status == 'approved')
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                        <i class="fas fa-check-circle"></i> Disetujui
                    </span>
                @elseif($latestAppointment->status == 'rejected')
                    <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                        <i class="fas fa-times-circle"></i> Ditolak
                    </span>
                @else
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        <i class="fas fa-check-double"></i> Selesai
                    </span>
                @endif
            </div>
        </div>

        @if($latestAppointment->status == 'rejected' && $latestAppointment->alasan_reject)
        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-sm text-red-800">
                <strong><i class="fas fa-info-circle"></i> Alasan Penolakan:</strong> {{ $latestAppointment->alasan_reject }}
            </p>
        </div>
        @endif
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
        <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Janji Temu</h3>
        <p class="text-gray-500 mb-4">Buat janji temu pertama Anda sekarang</p>
        <a href="{{ route('pasien.appointments.select-poli') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-plus-circle"></i> Buat Janji Temu
        </a>
    </div>
    @endif

    <!-- Approved Appointments -->
    @if($approvedAppointments->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-calendar-check text-green-600"></i> Janji Temu Mendatang
            </h2>
            <a href="{{ route('pasien.appointments.index') }}" class="text-blue-600 hover:underline text-sm font-semibold">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="space-y-3">
            @foreach($approvedAppointments as $appointment)
            <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg hover:shadow-md transition">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $appointment->dokter->username }}</h3>
                        <p class="text-sm text-gray-600">{{ $appointment->dokter->poli->nama ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-800">
                        <i class="fas fa-calendar"></i> {{ $appointment->tanggal_booking->format('d M Y') }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-clock"></i> {{ $appointment->jadwal->jam_mulai }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent Medical Records -->
    @if($medicalRecords->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-file-medical text-purple-600"></i> Rekam Medis Terbaru
            </h2>
            <a href="{{ route('pasien.medical-records.index') }}" class="text-blue-600 hover:underline text-sm font-semibold">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="space-y-3">
            @foreach($medicalRecords as $record)
            <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="px-3 py-1 bg-purple-600 text-white rounded-full text-xs font-semibold">
                                {{ $record->created_at->format('d M Y') }}
                            </span>
                            <span class="text-sm text-gray-600">{{ $record->dokter->username }}</span>
                        </div>
                        <p class="font-semibold text-gray-800 mb-1">
                            <i class="fas fa-stethoscope text-purple-600"></i> Diagnosis: {{ Str::limit($record->diagnosis, 50) }}
                        </p>
                        @if($record->prescriptions->count() > 0)
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-pills text-purple-600"></i> 
                            Resep: {{ $record->prescriptions->count() }} Obat
                        </p>
                        @endif
                    </div>
                    <a href="{{ route('pasien.medical-records.show', $record->id) }}" 
                       class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-purple-700 transition">
                        Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('pasien.appointments.select-poli') }}" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition group">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-4 rounded-full group-hover:bg-blue-600 transition">
                    <i class="fas fa-calendar-plus text-3xl text-blue-600 group-hover:text-white transition"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition">Buat Janji Temu</h3>
                    <p class="text-gray-600">Booking konsultasi dengan dokter</p>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien.medical-records.index') }}" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition group">
            <div class="flex items-center space-x-4">
                <div class="bg-purple-100 p-4 rounded-full group-hover:bg-purple-600 transition">
                    <i class="fas fa-file-medical-alt text-3xl text-purple-600 group-hover:text-white transition"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition">Rekam Medis</h3>
                    <p class="text-gray-600">Lihat riwayat kesehatan Anda</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection