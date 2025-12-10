@extends('layouts.admin') 

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah Pengguna Baru</a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Poli </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop untuk menampilkan data pengguna --}}
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{-- Menampilkan badge berdasarkan peran --}}
                                <span class="badge bg-{{ ['admin' => 'danger', 'dokter' => 'info', 'pasien' => 'success'][$user->role] ?? 'secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                {{-- Menampilkan Poli hanya jika peran adalah Dokter --}}
                                @if ($user->role == 'dokter' && $user->poli)
                                    {{ $user->poli->nama_poli }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i> Edit</a>
                                
                                {{-- Tombol Hapus (Hanya Admin yang punya akses) --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    {{-- Nonaktifkan tombol hapus jika user mencoba menghapus akunnya sendiri --}}
                                    <button type="submit" class="btn btn-sm btn-danger" {{ $user->id === auth()->id() ? 'disabled' : '' }}><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pengguna terdaftar (selain diri Anda).</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Tautan Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection