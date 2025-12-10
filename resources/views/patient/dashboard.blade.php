@extends('layouts.patient')

@section('content')
<div class="container-fluid">

    {{-- 1. BANNER SAMBUTAN (Gradient Modern) --}}
    <div class="card border-0 shadow-sm mb-4 text-white overflow-hidden" 
         style="background: linear-gradient(90deg, #2563eb 0%, #4f46e5 100%); border-radius: 15px;">
        <div class="card-body p-4 position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mb-0 text-white-50">Kesehatan Anda adalah prioritas kami. Segera buat janji temu jika Anda merasa kurang sehat.</p>
                </div>
                <div class="col-md-4 d-none d-md-block text-end">
                    <i class="fas fa-heartbeat fa-5x text-white opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        
        {{-- 2. KOLOM KIRI: SHORTCUT BUAT JANJI --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-plus fa-3x"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark">Daftar Berobat</h5>
                    <p class="text-muted small">Ingin konsultasi dengan dokter? Buat janji temu baru sekarang.</p>
                    <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold w-100 mt-3">
                        <i class="fas fa-plus-circle me-2"></i> Buat Janji Baru
                    </a>
                </div>
            </div>
        </div>

        {{-- 3. KOLOM KANAN: TABEL RIWAYAT TERAKHIR --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-history me-2 text-primary"></i> Riwayat Pendaftaran</h5>
                        <small class="text-muted">Status janji temu Anda</small>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-secondary small text-uppercase fw-bold">Tanggal</th>
                                    <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Dokter & Poli</th>
                                    <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Keluhan</th>
                                    <th class="py-3 border-0 text-secondary small text-uppercase fw-bold text-center">Status</th>
                                    <th class="pe-4 py-3 border-0 text-end">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $apt)
                                <tr>
                                    <td class="ps-4 fw-bold">
                                        {{ \Carbon\Carbon::parse($apt->tanggal_booking)->translatedFormat('d M Y') }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div>
                                                {{-- Handle relasi user/dokter agar aman dari error null --}}
                                                <h6 class="mb-0 fw-bold text-dark">{{ $apt->doctor_name ?? $apt->doctor?->name ?? 'Dokter' }}</h6>
                                                <small class="text-muted">{{ $apt->doctor?->poli?->nama_poli ?? 'Umum' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary fst-italic small">"{{ Str::limit($apt->keluhan_singkat, 30) }}"</span>
                                    </td>
                                    <td class="text-center">
                                        @if($apt->status == 'Pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">Menunggu</span>
                                        @elseif($apt->status == 'Approved')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">Disetujui</span>
                                        @elseif($apt->status == 'Rejected')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">Ditolak</span>
                                        @elseif($apt->status == 'Selesai' || $apt->status == 'Completed')
                                            <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $apt->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('patient.appointments.show', $apt->id) }}" class="btn btn-sm btn-outline-primary rounded-circle shadow-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="bg-light rounded-circle p-3 mb-3">
                                                <i class="fas fa-clipboard-list fa-2x text-secondary opacity-50"></i>
                                            </div>
                                            <h6 class="text-muted fw-bold">Belum ada riwayat</h6>
                                            <p class="small text-muted mb-0">Anda belum pernah mendaftar berobat.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    @if(method_exists($appointments, 'links'))
                    <div class="d-flex justify-content-center p-3">
                        {{ $appointments->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection