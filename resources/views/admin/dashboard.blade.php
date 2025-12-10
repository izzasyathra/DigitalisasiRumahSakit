@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- 1. WELCOME BANNER --}}
    {{-- Menggunakan gradient biru yang sama dengan sidebar agar senada --}}
    <div class="card border-0 shadow-sm mb-4 text-white" 
         style="background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 15px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold mb-1">Selamat Datang, Admin! 👋</h2>
                <p class="mb-0 text-white-50">Berikut adalah ringkasan aktivitas rumah sakit hari ini.</p>
            </div>
            <i class="fas fa-hospital-user fa-4x text-white opacity-25 d-none d-md-block"></i>
        </div>
    </div>

    {{-- 2. STATISTIC CARDS --}}
    <div class="row g-4 mb-4">
        
        {{-- Card 1: Janji Temu Pending (Paling Penting = Aksen Oranye/Warning) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: #fff7ed; color: #ea580c;">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-bold">Perlu Validasi</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $pendingCount }}</h2>
                        <small class="text-warning">Janji Temu Pending</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Dokter (Aksen Biru/Primary) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: #eff6ff; color: #2563eb;">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-bold">Total Dokter</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $doctorsCount }}</h2>
                        <small class="text-primary">Dokter Aktif</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Total Pasien (Aksen Hijau/Success) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: #f0fdf4; color: #16a34a;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-bold">Total Pasien</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $usersCount }}</h2>
                        <small class="text-success">Terdaftar di Sistem</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. SHORTCUTS (Menu Cepat) --}}
    <h5 class="fw-bold text-dark mb-3">Akses Cepat</h5>
    <div class="row g-3">
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.doctors.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card" style="border-radius: 12px;">
                    <i class="fas fa-user-plus fa-2x text-primary mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">Tambah Dokter</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.poli.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card" style="border-radius: 12px;">
                    <i class="fas fa-clinic-medical fa-2x text-info mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">Kelola Poli</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
             <a href="{{ route('admin.medicines.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card" style="border-radius: 12px;">
                    <i class="fas fa-pills fa-2x text-danger mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">Stok Obat</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card" style="border-radius: 12px;">
                    <i class="fas fa-users-cog fa-2x text-secondary mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">User List</h6>
                </div>
            </a>
        </div>
    </div>

</div>

{{-- CSS Tambahan Khusus Halaman Ini --}}
<style>
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
        background: white;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection