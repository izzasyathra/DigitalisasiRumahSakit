@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Dashboard Dokter</h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->username }}!</p>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        {{-- Pending Appointments --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Janji Temu Pending</p>
                            <h2 class="fw-bold mb-0">{{ $pendingAppointments }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <a href="{{ route('appointments.pending') }}" class="btn btn-sm btn-outline-warning mt-3 w-100">
                        Validasi Sekarang
                    </a>
                </div>
            </div>
        </div>

        {{-- Today's Appointments --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Konsultasi Hari Ini</p>
                            <h2 class="fw-bold mb-0">{{ $todayAppointments->count() }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-check fa-2x text-success"></i>
                        </div>
                    </div>
                    <a href="{{ route('dokter.medical-records.queue') }}" class="btn btn-sm btn-outline-success mt-3 w-100">
                        Lihat Antrean
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Schedules --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Jadwal Praktik</p>
                            <h2 class="fw-bold mb-0">{{ $totalSchedules }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                        </div>
                    </div>
                    <a href="{{ route('dokter.schedules.index') }}" class="btn btn-sm btn-outline-primary mt-3 w-100">
                        Kelola Jadwal
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Patients --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Pasien Diperiksa</p>
                            <h2 class="fw-bold mb-0">{{ $recentPatients->count() }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Today's Approved Appointments (Antrean Konsultasi) --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-list-ol me-2"></i>
                        Antrean Konsultasi Hari Ini ({{ \Carbon\Carbon::now()->format('d F Y') }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($todayAppointments->isEmpty())
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada konsultasi yang dijadwalkan untuk hari ini.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Pasien</th>
                                        <th>Keluhan</th>
                                        <th>Jam</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todayAppointments as $index => $appointment)
                                    <tr>
                                        <td class="fw-bold">{{ $index + 1 }}</td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $appointment->pasien->username }}</div>
                                                <small class="text-muted">{{ $appointment->pasien->email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($appointment->keluhan ?? '-', 50) }}</small>
                                        </td>
                                        <td>
                                            @if($appointment->schedule)
                                                {{ \Carbon\Carbon::parse($appointment->schedule->jam_mulai)->format('H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('dokter.medical-records.create', ['appointment_id' => $appointment->id]) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-notes-medical me-1"></i>Buat Rekam Medis
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Patients Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user-injured me-2"></i>
                        5 Pasien Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentPatients->isEmpty())
                        <div class="alert alert-secondary mb-0 small">
                            Belum ada pasien yang diperiksa
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentPatients as $appointment)
                            <div class="list-group-item px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 small fw-semibold">{{ $appointment->pasien->username }}</h6>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($appointment->tanggal_booking)->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-success">Selesai</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Schedule Access --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Pengaturan Jadwal
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Kelola jadwal praktik Anda dengan mudah
                    </p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('dokter.schedules.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Lihat Jadwal
                        </a>
                        <a href="{{ route('dokter.schedules.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row g-3 mt-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Menu Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('dokter.medical-records.queue') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-list-ol fa-2x mb-2 d-block"></i>
                                Antrean Konsultasi
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('appointments.pending') }}" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-clock fa-2x mb-2 d-block"></i>
                                Validasi Janji Temu
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('dokter.schedules.index') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-calendar-alt fa-2x mb-2 d-block"></i>
                                Kelola Jadwal
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('dokter.medical-records.index') }}" class="btn btn-info w-100 py-3">
                                <i class="fas fa-file-medical fa-2x mb-2 d-block"></i>
                                Rekam Medis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection