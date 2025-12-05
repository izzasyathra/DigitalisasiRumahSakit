@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    @if($dokter->photo)
                        <img src="{{ asset('storage/' . $dokter->photo) }}" 
                             class="rounded-circle mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;"
                             alt="{{ $dokter->username }}">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 150px; height: 150px; font-size: 48px;">
                            {{ strtoupper(substr($dokter->username, 0, 1)) }}
                        </div>
                    @endif
                    
                    <h4 class="fw-bold">{{ $dokter->username }}</h4>
                    
                    @if($dokter->poli)
                        <p class="text-muted mb-1">{{ $dokter->poli->name }}</p>
                    @endif
                    
                    @if($dokter->email)
                        <p class="text-muted mb-1">{{ $dokter->email }}</p>
                    @endif
                    
                    @if($dokter->phone)
                        <p class="text-muted">{{ $dokter->phone }}</p>
                    @endif
                </div>
            </div>

            @if($dokter->address)
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Alamat</h6>
                    <p class="mb-0">{{ $dokter->address }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Jadwal Praktik</h5>
                </div>
                <div class="card-body">
                    @if($dokter->schedules && $dokter->schedules->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam Mulai</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dokter->schedules as $schedule)
                                    <tr>
                                        <td class="fw-semibold">{{ $schedule->hari }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}</td>
                                        <td>30 Menit</td>
                                        <td>
                                            <span class="badge bg-success">Tersedia</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            Jadwal praktik belum tersedia untuk dokter ini.
                        </div>
                    @endif
                </div>
            </div>

            @if($dokter->poli)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Poli</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">{{ $dokter->poli->name }}</h6>
                    <p class="mb-0">{{ $dokter->poli->description ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
            @endif

            <div class="d-flex gap-2">
                <a href="{{ route('public.dokters') }}" class="btn btn-secondary">
                    Kembali ke Daftar Dokter
                </a>
                
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Login untuk Buat Janji Temu
                    </a>
                @else
                    @if(auth()->user()->role === 'pasien')
                        <a href="{{ route('pasien.appointments.select-poli') }}" class="btn btn-primary">
                            Buat Janji Temu
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection