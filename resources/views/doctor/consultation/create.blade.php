@extends('layouts.doctor')

@section('content')
<div class="container-fluid">
    
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('doctor.consultation.index') }}" class="text-decoration-none text-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Antrean
        </a>
    </div>

    {{-- Notifikasi Error (Misal stok habis) --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        {{-- KOLOM KIRI: INFO PASIEN --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body text-center p-4">
                    {{-- Avatar --}}
                    <div class="mb-3">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                            {{ substr($appointment->patient->name ?? $appointment->user->name, 0, 1) }}
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark">{{ $appointment->patient->name ?? $appointment->user->name }}</h5>
                    <p class="text-muted small mb-4">{{ $appointment->patient->email ?? $appointment->user->email }}</p>

                    <div class="text-start bg-light p-3 rounded-3">
                        <small class="text-uppercase text-secondary fw-bold" style="font-size: 0.7rem;">Keluhan Pasien</small>
                        <p class="mb-0 fw-semibold text-dark mt-1">
                            "{{ $appointment->keluhan_singkat ?? $appointment->complaint }}"
                        </p>
                    </div>

                    <div class="text-start bg-light p-3 rounded-3 mt-3">
                        <small class="text-uppercase text-secondary fw-bold" style="font-size: 0.7rem;">Jadwal Booking</small>
                        <p class="mb-0 text-dark mt-1 small">
                            <i class="far fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($appointment->tanggal_booking)->translatedFormat('l, d F Y') }} <br>
                            <i class="far fa-clock me-2 mt-2"></i> {{ $appointment->schedule->start_time }} - {{ $appointment->schedule->end_time }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM REKAM MEDIS --}}
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="m-0 fw-bold text-primary"><i class="fas fa-file-medical me-2"></i> Rekam Medis & Resep</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('doctor.consultation.store', $appointment->id) }}" method="POST">
                        @csrf
                        
                        {{-- 1. DIAGNOSA --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Diagnosa Dokter <span class="text-danger">*</span></label>
                            <textarea name="diagnosis" class="form-control bg-light border-0" rows="3" placeholder="Tuliskan hasil diagnosa..." required>{{ old('diagnosis') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-dark">Tindakan Medis</label>
                                <textarea name="tindakan" class="form-control bg-light border-0" rows="2" placeholder="Contoh: Pemberian infus, jahit luka...">{{ old('tindakan') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-dark">Catatan / Saran</label>
                                <textarea name="catatan" class="form-control bg-light border-0" rows="2" placeholder="Saran untuk pasien...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4 border-secondary opacity-10">

                        {{-- 2. RESEP OBAT --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-bold text-dark mb-0"><i class="fas fa-pills me-2 text-danger"></i> Resep Obat</label>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="add-medicine">
                                <i class="fas fa-plus me-1"></i> Tambah Obat
                            </button>
                        </div>

                        {{-- Container Input Obat --}}
                        <div id="medicine-container">
                            {{-- Baris Pertama (Default) --}}
                            <div class="row mb-2 medicine-row align-items-center">
                                <div class="col-7">
                                    <select name="medicines[]" class="form-select form-select-sm">
                                        <option value="">-- Pilih Obat --</option>
                                        @foreach($medicines as $med)
                                            <option value="{{ $med->id }}">{{ $med->name }} (Sisa: {{ $med->stok }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input type="number" name="quantities[]" class="form-control form-select-sm" placeholder="Jml" min="1">
                                </div>
                                <div class="col-2 text-end">
                                    <button type="button" class="btn btn-sm text-danger remove-medicine p-0" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted fst-italic">*Kosongkan jika tidak ada resep obat.</small>

                        {{-- TOMBOL SUBMIT --}}
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                <i class="fas fa-save me-2"></i> Simpan & Selesaikan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT TAMBAH OBAT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('medicine-container');
        const addButton = document.getElementById('add-medicine');

        // Fungsi Tambah Baris
        addButton.addEventListener('click', function() {
            // Clone baris pertama
            const firstRow = container.querySelector('.medicine-row');
            const newRow = firstRow.cloneNode(true);

            // Reset value input di baris baru
            newRow.querySelector('select').value = "";
            newRow.querySelector('input').value = "";
            
            // Tambahkan ke container
            container.appendChild(newRow);
        });

        // Fungsi Hapus Baris (Delegasi Event)
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-medicine')) {
                // Pastikan minimal sisa 1 baris
                if (container.querySelectorAll('.medicine-row').length > 1) {
                    e.target.closest('.medicine-row').remove();
                } else {
                    // Jika cuma 1 baris, reset saja isinya jangan dihapus
                    const row = e.target.closest('.medicine-row');
                    row.querySelector('select').value = "";
                    row.querySelector('input').value = "";
                }
            }
        });
    });
</script>
@endsection