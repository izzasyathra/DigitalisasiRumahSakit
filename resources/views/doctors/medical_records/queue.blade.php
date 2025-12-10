@extends('layouts.doctor')

@section('title', 'Antrean Konsultasi')

@section('content')
<div class="container-fluid">
    <h1>Antrean Konsultasi Hari Ini</h1>
    <p class="text-secondary">Daftar Janji Temu yang telah disetujui untuk Anda hari ini ({{ \Carbon\Carbon::today()->format('d F Y') }}).</p>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Waktu Slot</th>
                        <th>Nama Pasien</th>
                        <th>Keluhan Singkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($queueAppointments as $appointment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }}</td>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->keluhan_singkat }}</td>
                            <td>
                                <a href="{{ route('doctor.medical-records.create', $appointment->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-medical"></i> Mulai Konsultasi & Catat MR
                                </a>
                                {{-- Link ke Riwayat Pasien --}}
                                <a href="{{ route('doctor.patients.history', $appointment->patient_id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-history"></i> Riwayat Pasien
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada Janji Temu yang disetujui untuk hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection