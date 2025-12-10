@extends('layouts.patient')

@section('content')
<div class="container-fluid">

    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('patient.dashboard') }}" class="text-decoration-none text-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- 1. HEADER & STATUS --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body p-4 bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Detail Riwayat Medis</h4>
                        <p class="text-muted mb-0 small">
                            Kode Janji Temu: <span class="fw-bold text-primary">#APT-{{ $appointment->id }}</span>
                        </p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        @if($appointment->status == 'Pending')
                            <span class="badge bg-warning text-dark px-4 py-2 rounded-pill fs-6 shadow-sm"><i class="fas fa-clock me-2"></i>Menunggu Konfirmasi</span>
                        @elseif($appointment->status == 'Approved')
                            <span class="badge bg-primary px-4 py-2 rounded-pill fs-6 shadow-sm"><i class="fas fa-calendar-check me-2"></i>Disetujui Dokter</span>
                        @elseif($appointment->status == 'Rejected')
                            <span class="badge bg-danger px-4 py-2 rounded-pill fs-6 shadow-sm"><i class="fas fa-times-circle me-2"></i>Dibatalkan</span>
                        @elseif($appointment->status == 'Selesai' || $appointment->status == 'Completed')
                            <span class="badge bg-success px-4 py-2 rounded-pill fs-6 shadow-sm"><i class="fas fa-check-circle me-2"></i>Pemeriksaan Selesai</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- 2. KOLOM KIRI: INFO PENDAFTARAN --}}
                <div class="col-md-5 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-header bg-light py-3 border-bottom-0">
                            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-info-circle me-2 text-primary"></i>Info Pendaftaran</h6>
                        </div>
                        <div class="card-body p-4">
                            
                            {{-- Dokter Info --}}
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Dokter Pemeriksa</small>
                                    <h6 class="fw-bold text-dark mb-0">{{ $appointment->doctor_name }}</h6>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-2">
                                        {{ $appointment->poli_name ?? 'Spesialis' }}
                                    </span>
                                </div>
                            </div>

                            <hr class="border-secondary opacity-10">

                            {{-- Tanggal & Waktu --}}
                            <div class="mb-3">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Jadwal Konsultasi</small>
                                <p class="mb-0 fw-semibold text-dark">
                                    <i class="far fa-calendar-alt me-2 text-warning"></i>
                                    {{ \Carbon\Carbon::parse($appointment->tanggal_booking)->translatedFormat('l, d F Y') }}
                                </p>
                                <p class="mb-0 text-muted small ms-4">
                                    {{ $appointment->start_time }} - {{ $appointment->end_time }}
                                </p>
                            </div>

                            {{-- Keluhan Awal --}}
                            <div class="bg-light p-3 rounded-3 mt-3">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Keluhan Awal</small>
                                <p class="mb-0 text-dark fst-italic">"{{ $appointment->keluhan_singkat }}"</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. KOLOM KANAN: HASIL PEMERIKSAAN (Hanya muncul jika Selesai) --}}
                <div class="col-md-7 mb-4">
                    @if($medicalRecord)
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                            <div class="card-header bg-success text-white py-3 border-bottom-0" style="background: linear-gradient(90deg, #10b981 0%, #059669 100%);">
                                <h6 class="m-0 fw-bold"><i class="fas fa-notes-medical me-2"></i>Hasil Pemeriksaan Dokter</h6>
                            </div>
                            <div class="card-body p-4">
                                
                                {{-- Diagnosa --}}
                                <div class="mb-4">
                                    <label class="fw-bold text-secondary small text-uppercase">Diagnosa</label>
                                    <div class="p-3 bg-light rounded border-start border-4 border-success">
                                        <p class="mb-0 fw-bold text-dark">{{ $medicalRecord->diagnosis }}</p>
                                    </div>
                                </div>

                                {{-- Tindakan & Catatan --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="fw-bold text-secondary small text-uppercase">Tindakan Medis</label>
                                        <p class="text-dark">{{ $medicalRecord->tindakan ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold text-secondary small text-uppercase">Catatan Dokter</label>
                                        <p class="text-dark">{{ $medicalRecord->catatan ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Resep Obat --}}
                                <label class="fw-bold text-secondary small text-uppercase mb-2"><i class="fas fa-pills me-1"></i> Resep Obat</label>
                                @if($medicalRecord->medicines && $medicalRecord->medicines->count() > 0)
                                    <div class="table-responsive rounded border">
                                        <table class="table table-sm table-borderless mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="ps-3">Nama Obat</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th class="pe-3 text-end">Aturan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($medicalRecord->medicines as $med)
                                                <tr>
                                                    <td class="ps-3 border-bottom">{{ $med->name }}</td>
                                                    <td class="text-center border-bottom">{{ $med->pivot->quantity }}</td>
                                                    <td class="pe-3 text-end border-bottom text-muted small">Sesuai anjuran</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-muted small fst-italic border rounded p-2 text-center bg-light">
                                        Tidak ada resep obat.
                                    </div>
                                @endif

                            </div>
                        </div>
                    @else
                        {{-- JIKA BELUM DIPERIKSA --}}
                        <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center bg-light text-center p-5" style="border-radius: 15px; border: 2px dashed #cbd5e1 !important;">
                            <div class="opacity-50">
                                <i class="fas fa-user-clock fa-4x mb-3 text-secondary"></i>
                                <h5 class="fw-bold text-secondary">Belum Ada Hasil Medis</h5>
                                <p class="small text-muted mb-0">Dokter belum menginput hasil pemeriksaan untuk kunjungan ini.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection