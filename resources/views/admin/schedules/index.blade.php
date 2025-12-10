@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Praktik')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Jadwal Praktik</h1>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Tambah Jadwal Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Hari</th>
                        <th>Waktu Praktik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule->user->name }}</td>
                            <td>{{ $schedule->user->poli->nama_poli ?? 'N/A' }}</td>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada Jadwal Praktik yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $schedules->links() }}
            </div>
        </div>
    </div>
</div>
@endsection