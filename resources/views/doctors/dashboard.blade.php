@extends('layouts.doctor') 

@section('title', 'Dashboard Dokter')

@section('content')
<div class="container-fluid">
    <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>
    <p>Anda bertugas di Poli: {{ auth()->user()->poli->nama_poli ?? 'Tidak Ditentukan' }}</p>

    {{-- Layout Requirement Dashboard Dokter --}}
    <div class="row">
        {{-- Card 1: Janji Temu Pending (Perlu Validasi) --}}
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-header">Janji Temu Menunggu Validasi</div>
                <div class="card-body">
                    {{-- Data diisi dari Controller --}}
                    <h4 class="card-title">0 Janji Temu</h4> 
                    <a href="{{ route('validation.index') }}" class="btn btn-sm btn-outline-light">Lihat Daftar Validasi</a>
                </div>
            </div>
        </div>
        
        {{-- Card 2: Antrean Hari Ini (Approved) --}}
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-header">Antrean Konsultasi Hari Ini</div>
                <div class="card-body">
                    {{-- Data diisi dari Controller --}}
                    <h4 class="card-title">0 Pasien</h4>
                    <a href="{{ route('doctor.medical-records.index') }}" class="btn btn-sm btn-outline-light">Mulai Konsultasi</a>
                </div>
            </div>
        </div>
        
        {{-- Card 3: Akses Cepat Jadwal --}}
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-header">Pengaturan Jadwal Praktik</div>
                <div class="card-body">
                    <h4 class="card-title">Atur Ketersediaan</h4>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-sm btn-outline-light">Kelola Jadwal</a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- TODO: Tampilkan 5 pasien terbaru yang telah diperiksa di sini --}}

</div>
@endsection