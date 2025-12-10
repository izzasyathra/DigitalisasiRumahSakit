<form action="{{ isset($medicine) ? route('admin.medicines.update', $medicine->id) : route('admin.medicines.store') }}" method="POST">
    @csrf
    
    {{-- WAJIB ADA INI UNTUK UPDATE (PUT) --}}
    @if (isset($medicine))
        @method('PUT')
    @endif

    <div class="row">
        {{-- 1. NAMA OBAT --}}
        <div class="col-md-8 mb-3">
            <label for="name">Nama Obat <span class="text-danger">*</span></label>
            {{-- Perhatikan value: old('name', $medicine->name ?? '') --}}
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $medicine->name ?? '') }}" required placeholder="Contoh: Paracetamol">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 2. TIPE OBAT --}}
        <div class="col-md-4 mb-3">
            <label for="type">Jenis Obat <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                <option value="">-- Pilih Jenis --</option>
                {{-- KITA PAKAI $types (Sesuai Controller) --}}
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ (old('type', $medicine->type ?? '') == $type) ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        {{-- 3. STOK --}}
        <div class="col-md-4 mb-3">
            <label for="stock">Stok <span class="text-danger">*</span></label>
            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" 
                   value="{{ old('stock', $medicine->stock ?? 0) }}" required min="0">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 4. HARGA --}}
        <div class="col-md-4 mb-3">
            <label for="price">Harga (Rp) <span class="text-danger">*</span></label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                   value="{{ old('price', $medicine->price ?? 0) }}" required min="0">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- 5. DESKRIPSI --}}
    <div class="mb-3">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $medicine->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> {{ isset($medicine) ? 'Update Obat' : 'Simpan Obat' }}
        </button>
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>