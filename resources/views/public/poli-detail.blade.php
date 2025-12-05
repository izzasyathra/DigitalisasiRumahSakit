@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            {{-- Bagian Detail Poli --}}
            {{-- Sesuaikan field name: gunakan 'name' atau 'nama_poli' sesuai database --}}
            <h1 class="mb-3 fw-bold">{{ $poli->name ?? $poli->nama_poli }}</h1>
            <p class="lead">{{ $poli->description ?? $poli->deskripsi }}</p>
            
            <hr>
            
            {{-- Bagian Daftar Dokter --}}
            <h2 class="mt-5">Dokter yang Bertugas di Poli Ini</h2>
            
            @if($dokters->isEmpty())
                <div class="alert alert-warning">
                    Saat ini tidak ada dokter yang terdaftar di poli ini.
                </div>
            @else
                @foreach($dokters as $dokter)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            {{-- Foto Dokter (Opsional) --}}
                            {{-- <img src="..." class="rounded-circle me-3" style="width: 60px; height: 60px;"> --}}
                            
                            <div>
                                <h5 class="card-title fw-semibold">{{ $dokter->username }}</h5>
                                <p class="card-text text-muted">Spesialis: {{ $poli->name ?? $poli->nama_poli }}</p>
                            </div>
                        </div>

                        {{-- Tampilkan Jadwal Dokter --}}
                        <div class="mt-3">
                            <h6 class="fw-bold">Jadwal Praktik:</h6>
                            @if($dokter->schedules && $dokter->schedules->isEmpty())
                                <small class="text-danger">Jadwal belum tersedia.</small>
                            @elseif($dokter->schedules)
                                <ul class="list-group list-group-flush">
                                    @foreach($dokter->schedules as $schedule)
                                        <li class="list-group-item py-1">
                                            {{ $schedule->hari }}: {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} (Durasi: 30 Menit)
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <small class="text-danger">Jadwal belum tersedia.</small>
                            @endif
                        </div>
                        
                        {{-- Tombol Janji Temu (Akan berfungsi setelah user login) --}}
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary mt-3">Login untuk Buat Janji Temu</a>
                        @else
                            @if(auth()->user()->role === 'pasien')
                                <a href="{{ route('pasien.appointments.create', ['dokter_id' => $dokter->id]) }}" class="btn btn-sm btn-primary mt-3">Buat Janji Temu</a>
                            @endif
                        @endguest
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection