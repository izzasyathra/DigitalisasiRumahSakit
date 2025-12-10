<form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
    @csrf
    @if (isset($user))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="role">Peran (Role) <span class="text-danger">*</span></label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="">-- Pilih Peran --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-8 mb-3" id="poli-field" style="display: {{ old('role', $user->role ?? '') == 'dokter' ? 'block' : 'none' }};">
            <label for="poli_id">Poli (Khusus Dokter) <span class="text-danger">*</span></label>
            <select name="poli_id" id="poli_id" class="form-control @error('poli_id') is-invalid @enderror">
                <option value="">-- Pilih Poli --</option>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id }}" {{ old('poli_id', $user->poli_id ?? '') == $poli->id ? 'selected' : '' }}>
                        {{ $poli->nama_poli }}
                    </option>
                @endforeach
            </select>
            @error('poli_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="password">Password {{ isset($user) ? '(Biarkan kosong jika tidak diubah)' : '*' }}</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" {{ isset($user) ? '' : 'required' }}>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ isset($user) ? 'Update Pengguna' : 'Simpan Pengguna' }}
    </button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
    // Logika JavaScript untuk menampilkan/menyembunyikan field Poli
    document.getElementById('role').addEventListener('change', function() {
        const poliField = document.getElementById('poli-field');
        if (this.value === 'dokter') {
            poliField.style.display = 'block';
        } else {
            poliField.style.display = 'none';
            document.getElementById('poli_id').value = ''; // Kosongkan nilai saat disembunyikan
        }
    });
</script>