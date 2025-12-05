@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Dashboard Admin</h2>
            <p class="text-muted">Kelola dan monitor sistem rumah sakit</p>
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
                            <p class="text-muted mb-1 small">Pending Appointments</p>
                            <h2 class="fw-bold mb-0">{{ $pendingAppointments }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <a href="{{ route('appointments.pending') }}" class="btn btn-sm btn-outline-warning mt-3 w-100">
                        Lihat Semua
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Admin --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Admin</p>
                            <h2 class="fw-bold mb-0">{{ $totalAdmins }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-shield fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Dokter --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Dokter</p>
                            <h2 class="fw-bold mb-0">{{ $totalDokters }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-md fa-2x text-success"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.index') }}?role=dokter" class="btn btn-sm btn-outline-success mt-3 w-100">
                        Lihat Dokter
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Pasien --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Pasien</p>
                            <h2 class="fw-bold mb-0">{{ $totalPasiens }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.index') }}?role=pasien" class="btn btn-sm btn-outline-info mt-3 w-100">
                        Lihat Pasien
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Dokter Bertugas Hari Ini --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-calendar-check text-success me-2"></i>
                        Dokter Bertugas Hari Ini ({{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($doktersOnDutyToday->isEmpty())
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada dokter yang bertugas hari ini.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Dokter</th>
                                        <th>Poli</th>
                                        <th>Jadwal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doktersOnDutyToday as $dokter)
                                        @foreach($dokter->schedules as $schedule)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user-md text-success"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $dokter->username }}</div>
                                                        <small class="text-muted">{{ $dokter->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $dokter->poli->name ?? '-' }}</span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}
                                                <small class="text-muted">(30 menit)</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Aktif</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Pending Appointments --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-hourglass-half text-warning me-2"></i>
                        Janji Temu Pending
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentPendingAppointments->isEmpty())
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle me-2"></i>
                            Semua janji temu sudah diproses!
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentPendingAppointments as $appointment)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $appointment->pasien->username }}</h6>
                                        <p class="mb-1 small text-muted">
                                            <i class="fas fa-user-md me-1"></i>{{ $appointment->dokter->username }}
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($appointment->tanggal_booking)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <span class="badge bg-warning">Pending</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('appointments.pending') }}" class="btn btn-warning w-100 mt-3">
                            Validasi Semua
                        </a>
                    @endif
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
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Tambah User
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.polis.create') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-hospital me-2"></i>Tambah Poli
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.medicines.create') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-pills me-2"></i>Tambah Obat
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-list me-2"></i>Kelola Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection