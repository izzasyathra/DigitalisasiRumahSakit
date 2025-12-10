@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Obat</h1>
        <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Obat
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel Data --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jenis</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicines as $key => $medicine)
                        <tr>
                            {{-- Nomor Urut --}}
                            <td>{{ $medicines->firstItem() + $key }}</td>

                            {{-- Nama Obat (Sesuai kolom 'nama') --}}
                            <td>{{ $medicine->nama }}</td>

                            {{-- Tipe/Jenis (Sesuai kolom 'tipe') --}}
                            <td>
                                <span class="badge bg-secondary">{{ $medicine->tipe }}</span>
                            </td>

                            {{-- Stok (Sesuai kolom 'stok') --}}
                            <td>
                                @if($medicine->stok <= 10)
                                    <span class="text-danger fw-bold">{{ $medicine->stok }}</span>
                                @else
                                    {{ $medicine->stok }}
                                @endif
                            </td>

                            <td>Rp {{ number_format($medicine->harga, 0, ',', '.') }}</td>

                            {{-- Tombol Aksi --}}
                            <td>
                                <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="btn btn-sm btn-info text-white">
                                    Edit
                                </a>

                                <form action="{{ route('admin.medicines.destroy', $medicine->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus obat ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data obat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $medicines->links() }}
            </div>
        </div>
    </div>
</div>
@endsection