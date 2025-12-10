@extends('layouts.admin')

@section('title', 'Edit Dokter')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Dokter: {{ $doctor->name }}</h1>

    {{-- Tampilkan Error Jika Ada --}}
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
            <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama Dokter</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $doctor->name) }}" required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $doctor->email) }}" required>
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

                {{-- Poli (Langsung Tampil & Wajib) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Spesialis Poli <span class="text-danger">*</span></label>
                    <select class="form-select" name="poli_id" required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $poli)
                            <option value="{{ $poli->id }}" {{ (old('poli_id', $doctor->poli_id) == $poli->id) ? 'selected' : '' }}>
                                {{ $poli->name ?? $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection