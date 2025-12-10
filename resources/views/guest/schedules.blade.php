@extends('layouts.guest_app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Jadwal Praktik Dokter</h2>
        <p class="text-muted">Cek jadwal dokter favorit Anda sebelum berkunjung.</p>
    </div>

    <div class="card border-0 shadow rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="py-3 ps-4">Hari</th>
                        <th class="py-3">Jam Praktik</th>
                        <th class="py-3">Nama Dokter</th>
                        <th class="py-3">Poli / Spesialis</th>
                        <th class="py-3 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $schedule->day }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="far fa-clock me-1"></i> {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-weight: bold; font-size: 0.8rem;">
                                        {{ substr($schedule->doctor->name ?? 'D', 0, 1) }}
                                    </div>
                                    <span class="fw-semibold">{{ $schedule->doctor->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>{{ $schedule->doctor->poli->name ?? 'Umum' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    Booking
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Belum ada jadwal praktik yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection