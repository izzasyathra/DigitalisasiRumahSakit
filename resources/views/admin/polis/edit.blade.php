@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Edit Poli: {{ $poli->name }}</h2>
        
        <form action="{{ route('admin.polis.update', $poli) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Metode untuk Update --}}
            
            <div>
                <label for="name">Nama Poli (Wajib, Unik):</label>
                <input type="text" id="name" name="name" value="{{ old('name', $poli->name) }}" required>
                @error('name') <div style="color: red;">{{ $message }}</div> @enderror
            </div>
            
            <div>
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description">{{ old('description', $poli->description) }}</textarea>
                @error('description') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            @if ($poli->icon_path)
                <p>Ikon Saat Ini:</p>
                <img src="{{ Storage::url($poli->icon_path) }}" alt="{{ $poli->name }}" width="100">
            @endif
            
            <div>
                <label for="icon_file">Ganti Ikon/Gambar:</label>
                <input type="file" id="icon_file" name="icon_file">
                @error('icon_file') <div style="color: red;">{{ $message }}</div> @enderror
            </div>
            
            <button type="submit">Perbarui Poli</button>
        </form>

        <a href="{{ route('admin.polis.index') }}">Kembali ke Daftar Poli</a>
    </div>
@endsection