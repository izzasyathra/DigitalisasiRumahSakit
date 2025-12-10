@extends('layouts.doctor')

@section('content')
<div class="container-fluid">

    {{-- Header & Tombol Tambah --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Jadwal Praktik</h3>
            <p class="text-muted mb-0 small">Kelola jam kerja Anda di rumah sakit.</p>
        </div>
        <a href="{{ route('doctor.schedules.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Jadwal
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Jadwal (Card Style) --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4 border-0">Hari</th>
                            <th class="py-3 border-0">Jam Mulai</th>
                            <th class="py-3 border-0">Jam Selesai</th>
                            <th class="py-3 pe-4 text-end border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                        <tr>
                            <td class="ps-4 fw-bold">
                                {{-- Badge Hari --}}
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    {{ $schedule->day }}
                                </span>
                            </td>
                            <td class="text-muted">
                                <i class="far fa-clock me-1 text-info"></i> 
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                            </td>
                            <td class="text-muted">
                                <i class="far fa-clock me-1 text-danger"></i> 
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('doctor.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-outline-warning me-1 rounded-circle" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('doctor.schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle p-3 mb-3">
                                        <i class="fas fa-calendar-times fa-2x text-secondary opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">Belum ada jadwal praktik.</h6>
                                    <a href="{{ route('doctor.schedules.create') }}" class="text-decoration-none small">Tambah Jadwal Baru</a>
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