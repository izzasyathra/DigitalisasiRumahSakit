@extends('layouts.doctor')

@section('title', 'Rekam Medis Baru')

@section('content')
<div class="container-fluid">
    <h1>Pencatatan Rekam Medis</h1>
    <p>Pasien: <strong>{{ $appointment->patient->name }}</strong> | Janji Temu: {{ $appointment->tanggal_booking }}</p>
    
    <form action="{{ route('doctor.medical-records.store', $appointment->id) }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                {{-- DIAGNOSIS & TINDAKAN --}}
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">Informasi Konsultasi</div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
                            <textarea name="diagnosis" id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3" required>{{ old('diagnosis') }}</textarea>
                            @error('diagnosis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tindakan_medis">Tindakan Medis</label>
                            <textarea name="tindakan_medis" id="tindakan_medis" class="form-control @error('tindakan_medis') is-invalid @enderror" rows="3">{{ old('tindakan_medis') }}</textarea>
                            @error('tindakan_medis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan">Catatan Tambahan</label>
                            <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="2">{{ old('catatan') }}</textarea>
                            @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                {{-- RESEP OBAT --}}
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">Resep Obat</div>
                    <div class="card-body">
                        
                        <div id="prescription-list">
                            {{-- Baris Resep Dinamis akan ditambahkan di sini --}}
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addPrescriptionRow()">
                            <i class="fas fa-plus"></i> Tambah Obat
                        </button>
                        
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-lg btn-primary mb-5">
            <i class="fas fa-check"></i> Selesaikan Konsultasi & Simpan Rekam Medis
        </button>
    </form>
</div>

<script>
    // FUNGSI JAVASCRIPT DINAMIS UNTUK TAMBAH RESEP
    const medicines = @json($medicines); // Ambil data obat dari PHP

    function addPrescriptionRow() {
        const list = document.getElementById('prescription-list');
        const count = list.children.length;

        let options = medicines.map(med => 
            `<option value="${med.id}">${med.nama_obat} (Stok: ${med.stok})</option>`
        ).join('');

        const newRow = document.createElement('div');
        newRow.className = 'row border-bottom py-2';
        newRow.innerHTML = `
            <div class="col-md-4 mb-2">
                <select name="medicine_id[]" class="form-control form-control-sm" required>
                    <option value="">-- Pilih Obat --</option>
                    ${options}
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <input type="number" name="jumlah[]" class="form-control form-control-sm" placeholder="Jumlah" min="1" required>
            </div>
            <div class="col-md-5 mb-2">
                <input type="text" name="aturan_minum[]" class="form-control form-control-sm" placeholder="Aturan Minum (e.g., 3x sehari)">
            </div>
            <div class="col-md-1 mb-2 text-center">
                <button type="button" class="btn btn-sm btn-danger" onclick="removePrescriptionRow(this)"><i class="fas fa-times"></i></button>
            </div>
        `;
        list.appendChild(newRow);
    }

    function removePrescriptionRow(button) {
        button.closest('.row').remove();
    }
    
    // Tambahkan baris pertama saat dimuat
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('prescription-list').children.length === 0) {
            addPrescriptionRow();
        }
    });
</script>
@endsection