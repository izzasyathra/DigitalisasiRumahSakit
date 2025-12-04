@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Tambah Poli Baru</h2>
        
        <form action="{{ route('admin.polis.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div>
                <label for="name">Nama Poli (Wajib, Unik):</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <div style="color: red;">{{ $message }}</div> @enderror
            </div>
            
            <div>
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description') <div style="color: red;">{{ $message }}</div> @enderror
            </div>
            
            <div>
                <label for="icon_file">Ikon/Gambar (Opsional, JPG/PNG Max 2MB):</label>
                <input type="file" id="icon_file" name="icon_file">
                @error('icon_file') <div style="color: red;">{{ $message }}</div> @enderror
            </div>
            
            <button type="submit">Simpan Poli</button>
        </form>

        <a href="{{ route('admin.polis.index') }}">Kembali ke Daftar Poli</a>
    </div>
@endsection