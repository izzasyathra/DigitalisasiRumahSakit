@extends('layouts.admin')

@section('title', 'Daftar Dokter')

@section('content')
<div class="container-fluid">
    
    {{-- Header Halaman --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Dokter</h1>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Dokter
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Dokter --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Dokter</th>
                            <th>Email</th>
                            <th>Spesialis Poli</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $doctor->name }}</td>   {{-- Sesuaikan dengan kolom DB 'name' --}}
                            <td>{{ $doctor->email }}</td>  {{-- Tampilkan Email --}}
                            <td>
                                {{-- Ambil nama poli dari relasi. Cek apakah kolomnya 'name' atau 'nama_poli' --}}
                                {{ $doctor->poli->name ?? $doctor->poli->nama_poli ?? '-' }}
                            </td>
                            <td>
                                {{-- ERROR SEBELUMNYA DISINI ($item diganti $doctor) --}}
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus dokter ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data dokter.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="mt-3">
                {{ $doctors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection