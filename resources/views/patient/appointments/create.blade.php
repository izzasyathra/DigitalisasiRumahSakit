@extends('layouts.patient')

@section('content')
<div class="container-fluid">
    
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            {{-- Header --}}
            <div class="mb-4 text-center">
                <h3 class="fw-bold text-dark">Formulir Pendaftaran</h3>
                <p class="text-muted">Silakan isi data di bawah untuk membuat janji temu baru.</p>
            </div>

            {{-- Card Form --}}
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-5">
                    
                    {{-- Error Alerts --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3 mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('patient.appointments.store') }}" method="POST">
                        @csrf
                        
                        {{-- 1. Pilih Poli --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Pilih Poliklinik</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-hospital"></i></span>
                                <select name="poli_id" id="poli_id" class="form-select border-start-0 ps-0 bg-light" required>
                                    <option value="">-- Pilih Poli Tujuan --</option>
                                    @foreach($polis as $poli)
                                        {{-- Sesuaikan 'nama_poli' atau 'name' --}}
                                        <option value="{{ $poli->id }}">{{ $poli->name ?? $poli->nama_poli }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- 2. Pilih Dokter (AJAX) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Pilih Dokter</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-user-md"></i></span>
                                <select name="doctor_id" id="doctor_id" class="form-select border-start-0 ps-0 bg-light" required>
                                    <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                                </select>
                            </div>
                            <small class="text-muted fst-italic" style="font-size: 0.8rem;">*Daftar dokter akan muncul setelah Anda memilih Poli.</small>
                        </div>

                        {{-- 3. Tanggal Booking --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Rencana Tanggal Berobat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" name="appointment_date" class="form-control border-start-0 ps-0 bg-light" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        {{-- 4. Keluhan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Keluhan Utama</label>
                            <textarea name="complaint" class="form-control bg-light" rows="4" 
                                      placeholder="Jelaskan secara singkat gejala yang Anda rasakan..." required></textarea>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Pendaftaran
                            </button>
                            <a href="{{ route('patient.dashboard') }}" class="btn btn-link text-decoration-none text-muted">Batal, kembali ke dashboard</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT AJAX DOKTER (Sama seperti sebelumnya, tapi disesuaikan selectornya) --}}
<script>
    $(document).ready(function() {
        $('#poli_id').on('change', function() {
            var poliId = $(this).val();
            if(poliId) {
                // Tampilkan loading
                $('#doctor_id').html('<option>Sedang memuat...</option>');
                
                $.ajax({
                    url: '/patient/get-doctors/' + poliId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#doctor_id').empty();
                        if(data.length > 0) {
                            $('#doctor_id').append('<option value="">-- Pilih Dokter Tersedia --</option>');
                            $.each(data, function(key, value) {
                                // Pastikan field nama dokter sesuai database (name/nama_dokter)
                                var drName = value.name ? value.name : value.nama_dokter;
                                $('#doctor_id').append('<option value="'+ value.id +'">'+ drName +'</option>');
                            });
                        } else {
                            $('#doctor_id').append('<option value="">Tidak ada dokter di poli ini</option>');
                        }
                    },
                    error: function() {
                        $('#doctor_id').html('<option value="">Gagal memuat dokter</option>');
                    }
                });
            } else {
                $('#doctor_id').empty();
                $('#doctor_id').append('<option value="">-- Pilih Poli Terlebih Dahulu --</option>');
            }
        });
    });
</script>
@endsection