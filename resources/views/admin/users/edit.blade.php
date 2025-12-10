@extends('layouts.admin')

@section('title', 'Edit Data Pengguna')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Pengguna: {{ $user->name }}</h1>

    {{-- TAMBAHAN: Tampilkan Error Validasi (PENTING UNTUK DEBUGGING) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT') 

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                
                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password Baru <small class="text-danger">(Kosongkan jika tidak ingin mengubah)</small></label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>

                {{-- Role Selection --}}
                <div class="mb-3">
                    <label class="form-label">Peran (Role)</label>
                    <select class="form-select" name="role" id="roleSelect">
                        <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                        <option value="dokter" {{ (old('role', $user->role) == 'dokter') ? 'selected' : '' }}>Dokter</option>
                        <option value="pasien" {{ (old('role', $user->role) == 'pasien') ? 'selected' : '' }}>Pasien</option>
                    </select>
                </div>

                {{-- Pilihan Poli (Hidden by default, shown by JS) --}}
                <div class="mb-3" id="poliContainer" style="display: none;">
                    <label class="form-label">Spesialis Poli <small class="text-danger">*Wajib untuk Dokter</small></label>
                    <select class="form-select" name="poli_id" id="poliSelect">
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $poli)
                            {{-- Cek apakah pakai 'nama_poli' atau 'name'. Sesuaikan di sini --}}
                            <option value="{{ $poli->id }}" {{ (old('poli_id', $user->poli_id) == $poli->id) ? 'selected' : '' }}>
                                {{ $poli->nama_poli ?? $poli->name }} 
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('roleSelect');
        const poliContainer = document.getElementById('poliContainer');
        const poliSelect = document.getElementById('poliSelect');

        function togglePoli() {
            // Kita cek value 'dokter' (sesuai value di <option> dan database)
            if (roleSelect.value === 'dokter') {
                poliContainer.style.display = 'block';
                poliSelect.setAttribute('required', 'required'); 
            } else {
                poliContainer.style.display = 'none';
                poliSelect.removeAttribute('required');
                poliSelect.value = ""; 
            }
        }

        togglePoli(); // Jalankan saat load
        roleSelect.addEventListener('change', togglePoli); // Jalankan saat user ganti role
    });
</script>
@endsection