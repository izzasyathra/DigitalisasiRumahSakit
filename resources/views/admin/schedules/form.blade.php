<form action="{{ isset($schedule) ? route('admin.schedules.update', $schedule->id) : route('admin.schedules.store') }}" method="POST">
    @csrf
    @if (isset($schedule))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="user_id">Dokter <span class="text-danger">*</span></label>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('user_id', $schedule->user_id ?? '') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }} (Poli: {{ $doctor->poli->nama_poli ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="day">Hari Praktik <span class="text-danger">*</span></label>
            <select name="day" id="day" class="form-control @error('day') is-invalid @enderror" required>
                <option value="">-- Pilih Hari --</option>
                @foreach ($days as $day)
                    <option value="{{ $day }}" {{ old('day', $schedule->day ?? '') == $day ? 'selected' : '' }}>
                        {{ $day }}
                    </option>
                @endforeach
            </select>
            @error('day')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="start_time">Waktu Mulai Praktik (HH:MM) <span class="text-danger">*</span></label>
            {{-- Tipe time input memudahkan pengguna --}}
            <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $schedule->start_time ?? '') }}" required>
            @error('start_time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="end_time">Waktu Selesai Praktik (HH:MM) <span class="text-danger">*</span></label>
            <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $schedule->end_time ?? '') }}" required>
            @error('end_time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ isset($schedule) ? 'Update Jadwal' : 'Simpan Jadwal' }}
    </button>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Batal</a>
</form>