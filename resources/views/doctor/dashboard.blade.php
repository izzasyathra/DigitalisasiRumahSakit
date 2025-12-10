@extends('layouts.doctor')

@section('content')
<div class="container-fluid">

    {{-- 1. WELCOME BANNER --}}
    <div class="card border-0 shadow-sm mb-4 text-white" 
         style="background: linear-gradient(90deg, #0ea5e9 0%, #3b82f6 100%); border-radius: 15px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👨‍⚕️</h2>
                <p class="mb-0 text-white-50">Siap melayani pasien hari ini? Cek jadwal Anda di bawah ini.</p>
            </div>
            <i class="fas fa-stethoscope fa-4x text-white opacity-25 d-none d-md-block"></i>
        </div>
    </div>

    {{-- 2. STATISTIC CARDS --}}
    <div class="row g-4 mb-4">
        
        {{-- Card 1: Perlu Validasi --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: #fff7ed; color: #ea580c;">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-bold">Perlu Validasi</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $pendingCount ?? 0 }}</h2>
                        <small class="text-warning">Menunggu Konfirmasi</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Pasien Hari Ini (Disetujui) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: #eff6ff; color: #2563eb;">
                        <i class="fas fa-user-injured fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-bold">Jadwal Hari Ini</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $todayCount ?? 0 }}</h2>
                        <small class="text-primary">Pasien Terjadwal</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Total Selesai --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: #f0fdf4; color: #16a34a;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-bold">Selesai Diperiksa</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $completedCount ?? 0 }}</h2>
                        <small class="text-success">Total Riwayat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. SHORTCUTS --}}
    <h5 class="fw-bold text-dark mb-3">Menu Cepat</h5>
    <div class="row g-3">
        <div class="col-md-6">
            <a href="{{ route('doctor.appointments.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 hover-card d-flex flex-row align-items-center">
                    <div class="bg-primary text-white rounded p-3 me-3">
                        <i class="fas fa-check-double fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-dark fw-bold mb-0">Validasi Janji Temu</h6>
                        <small class="text-muted">Setujui atau tolak permintaan pasien</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('doctor.consultation.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 hover-card d-flex flex-row align-items-center">
                    <div class="bg-success text-white rounded p-3 me-3">
                        <i class="fas fa-notes-medical fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-dark fw-bold mb-0">Mulai Pemeriksaan</h6>
                        <small class="text-muted">Input diagnosa dan resep obat</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .hover-card { transition: transform 0.2s; background: white; }
    .hover-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important; }
</style>
@endsection