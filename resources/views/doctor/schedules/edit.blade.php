@extends('layouts.doctor')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Header --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('doctor.schedules.index') }}" class="btn btn-light rounded-circle shadow-sm me-3">
                    <i class="fas fa-arrow-left text-muted"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Edit Jadwal</h4>
                    <p class="text-muted mb-0 small">Perbarui waktu praktik Anda.</p>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="{{ route('doctor.schedules.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Pilihan Hari --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Hari Praktik</label>
                            <select name="day" class="form-select form-select-lg @error('day') is-invalid @enderror" required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                            @error('day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Jam Mulai & Selesai --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Jam Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="far fa-clock text-primary"></i></span>
                                    <input type="time" name="start_time" 
                                           class="form-control border-start-0 ps-0 @error('start_time') is-invalid @enderror" 
                                           value="{{ $schedule->start_time }}" required>
                                </div>
                                @error('start_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Jam Selesai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="far fa-clock text-danger"></i></span>
                                    <input type="time" name="end_time" 
                                           class="form-control border-start-0 ps-0 @error('end_time') is-invalid @enderror" 
                                           value="{{ $schedule->end_time }}" required>
                                </div>
                                @error('end_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                            <a href="{{ route('doctor.schedules.index') }}" class="btn btn-light px-4 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm fw-bold">
                                <i class="fas fa-sync-alt me-2"></i> Update Jadwal
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection