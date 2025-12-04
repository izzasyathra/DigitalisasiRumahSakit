@extends('layouts.admin') {{-- Asumsikan Anda memiliki layout Admin --}}

@section('content')
    <div class="container">
        <h2>Manajemen Poli</h2>
        
        @if (session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif
        
        <a href="{{ route('admin.polis.create') }}" class="btn-create">Tambah Poli Baru</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Poli</th>
                    <th>Deskripsi</th>
                    <th>Dokter Terkait</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($polis as $poli)
                    <tr>
                        <td>{{ $poli->id }}</td>
                        <td>{{ $poli->name }}</td>
                        <td>{{ Str::limit($poli->description, 50) }}</td>
                        <td>{{ $poli->doctors->count() }} Dokter</td> {{-- Menggunakan relasi doctors dari Model Poli --}}
                        <td>
                            <a href="{{ route('admin.polis.edit', $poli) }}">Edit</a>
                            
                            <form action="{{ route('admin.polis.destroy', $poli) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus Poli ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data Poli.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $polis->links() }}
    </div>
@endsection