@extends('layouts.admin')

@section('title', 'Manajemen Poli')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Poli</h1>
        <a href="{{ route('admin.poli.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Poli Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Poli</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($polis as $poli)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $poli->name }}</td>
                            <td>{{ Str::limit($poli->description, 50) ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.poli.edit', $poli->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.poli.destroy', $poli->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus Poli ini? Semua Dokter yang berelasi akan terpengaruh.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data Poli yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $polis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection