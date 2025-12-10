<form action="{{ isset($poli) ? route('admin.poli.update', $poli->id) : route('admin.poli.store') }}" method="POST">
    @csrf
    @if (isset($poli))
        @method('PUT')
    @endif

    <div class="form-group mb-3">
        <label for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
        <input type="text" name="nama_poli" id="nama_poli" class="form-control @error('nama_poli') is-invalid @enderror" value="{{ old('nama_poli', $poli->nama_poli ?? '') }}" required>
        @error('nama_poli')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi', $poli->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- TODO: Tambahkan field Ikon/Gambar di sini --}}

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ isset($poli) ? 'Update Poli' : 'Simpan Poli' }}
    </button>
    <a href="{{ route('admin.poli.index') }}" class="btn btn-secondary">Batal</a>
</form>