@extends('layouts.doctor')

@section('content')
<div class="container-fluid">

    {{-- Header Halaman --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Validasi Janji Temu</h3>
            <p class="text-muted mb-0 small">Setujui atau tolak permintaan masuk dari pasien.</p>
        </div>
        {{-- Badge Jumlah Pending --}}
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm">
            <i class="fas fa-clock me-1"></i> Menunggu: {{ $appointments->count() }}
        </span>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Daftar Pending (Style Card Modern) --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-secondary small text-uppercase fw-bold">Pasien</th>
                            <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Jadwal Diminta</th>
                            <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Keluhan</th>
                            <th class="py-3 pe-4 text-end border-0 text-secondary small text-uppercase fw-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            {{-- Info Pasien dengan Avatar --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" 
                                         style="width: 40px; height: 40px; font-weight: bold; font-size: 0.9rem;">
                                        {{ substr($appointment->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $appointment->user->name ?? 'Pasien' }}</h6>
                                        <span class="badge bg-light text-secondary border rounded-pill" style="font-size: 0.7rem;">Pasien Baru</span>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Info Jadwal --}}
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($appointment->tanggal_booking)->translatedFormat('d F Y') }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1 text-info"></i>
                                        {{ $appointment->schedule->start_time ?? '-' }} - {{ $appointment->schedule->end_time ?? '-' }}
                                    </small>
                                </div>
                            </td>

                            {{-- Keluhan Singkat (Dibatasi karakternya agar tabel rapi) --}}
                            <td>
                                <div class="p-2 bg-light rounded border border-light" style="max-width: 300px;">
                                    <small class="text-secondary fst-italic">
                                        "{{ Str::limit($appointment->keluhan_singkat, 60) }}"
                                    </small>
                                </div>
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="text-end pe-4">
                                <form action="{{ route('doctor.appointments.approve', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm text-white fw-bold me-1" title="Terima">
                                        <i class="fas fa-check me-1"></i> Terima
                                    </button>
                                </form>
                                <form action="{{ route('doctor.appointments.reject', $appointment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak janji temu ini?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm fw-bold" title="Tolak">
                                        <i class="fas fa-times me-1"></i> Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 mb-3">
                                        <i class="fas fa-check-double fa-2x text-success"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Tidak ada permintaan baru</h6>
                                    <p class="text-muted small mb-0">Semua janji temu sudah divalidasi.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection