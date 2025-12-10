@extends('layouts.doctor')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Pemeriksaan Pasien</h3>
            <p class="text-muted mb-0 small">Daftar pasien yang menunggu giliran diperiksa hari ini.</p>
        </div>
        <div class="bg-white p-2 rounded-pill shadow-sm px-3">
            <small class="fw-bold text-secondary">
                <i class="fas fa-calendar-day me-2 text-primary"></i> Hari ini: {{ now()->translatedFormat('d F Y') }}
            </small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Antrean --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-secondary small text-uppercase fw-bold">No</th>
                            <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Data Pasien</th>
                            <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Jadwal & Keluhan</th>
                            <th class="py-3 border-0 text-secondary small text-uppercase fw-bold text-center">Status</th>
                            <th class="py-3 pe-4 text-end border-0 text-secondary small text-uppercase fw-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 45px; height: 45px; font-weight: bold; font-size: 1.1rem;">
                                        {{ substr($appointment->patient->name ?? $appointment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $appointment->patient->name ?? $appointment->user->name }}</h6>
                                        <small class="text-muted">Pasien Umum</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-dark">
                                        <i class="far fa-clock me-1 text-primary"></i>
                                        {{ $appointment->schedule->start_time ?? '-' }} - {{ $appointment->schedule->end_time ?? '-' }}
                                    </span>
                                    <small class="text-secondary mt-1">
                                        <i class="fas fa-comment-medical me-1"></i> 
                                        "{{ Str::limit($appointment->keluhan_singkat, 30) }}"
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    Siap Diperiksa
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('doctor.consultation.create', $appointment->id) }}" 
                                   class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm fw-bold">
                                    <i class="fas fa-stethoscope me-2"></i> Periksa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle p-4 mb-3">
                                        <i class="fas fa-user-injured fa-3x text-secondary opacity-25"></i>
                                    </div>
                                    <h6 class="text-muted fw-bold">Antrean Kosong</h6>
                                    <p class="small text-muted mb-0">Belum ada pasien yang disetujui untuk diperiksa.</p>
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