@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <div class="mb-4">
        <h3 class="fw-bold text-dark">Dashboard Pasien</h3>
        <p class="text-muted">Riwayat konsultasi dan janji temu Anda.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3 bg-primary text-white">
                <div class="card-body">
                    <h6 class="mb-1">Total Janji Temu</h6>
                    <h3 class="fw-bold mb-0">{{ $appointments->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3 bg-warning text-dark">
                <div class="card-body">
                    <h6 class="mb-1">Menunggu Konfirmasi</h6>
                    <h3 class="fw-bold mb-0">{{ $appointments->where('status', 'Pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3 bg-success text-white">
                <div class="card-body">
                    <h6 class="mb-1">Siap Dikunjungi</h6>
                    <h3 class="fw-bold mb-0">{{ $appointments->where('status', 'Approved')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow rounded-3">
        
        <div class="card-body p-4">
            
            <div class="mb-4">
                <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus me-2"></i> Buat Janji Baru
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary">
                            <th class="py-3 ps-3">No</th>
                            <th class="py-3">Dokter</th>
                            <th class="py-3">Jadwal</th>
                            <th class="py-3">Keluhan</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $loop->iteration }}</td>
                                
                                <td>
                                    <span class="fw-bold text-dark">{{ $appointment->doctor_name }}</span>
                                    <br>
                                    <small class="text-muted">Poli Umum/Spesialis</small>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->tanggal_booking)->translatedFormat('d F Y') }} <br>
                                    <small class="text-muted">
                                        {{ $appointment->start_time ? substr($appointment->start_time, 0, 5) : '-' }} - 
                                        {{ $appointment->end_time ? substr($appointment->end_time, 0, 5) : '-' }}
                                    </small>
                                </td>

                                <td>{{ Str::limit($appointment->keluhan_singkat, 30) }}</td>

                                <td class="text-center">
                                    @if($appointment->status == 'Pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($appointment->status == 'Approved')
                                        <span class="badge bg-primary">Disetujui</span>
                                    @elseif($appointment->status == 'Selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($appointment->status == 'Rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                    @endif
                                </td>

                                <td class="text-end pe-3">
                                    <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="btn btn-sm btn-info text-white shadow-sm">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://img.icons8.com/ios/100/cccccc/nothing-found.png" alt="Empty" style="width: 60px; opacity: 0.5;" class="mb-3">
                                    <p class="text-muted mb-0">Belum ada riwayat janji temu.</p>
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