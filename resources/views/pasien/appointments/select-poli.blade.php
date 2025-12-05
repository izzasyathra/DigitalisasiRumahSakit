@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Buat Janji Temu</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary mb-2">Buat Janji Temu</h4>
                    <p class="text-muted">Pilih poli yang Anda inginkan</p>

                    {{-- Progress Steps --}}
                    <div class="progress-steps mb-4">
                        <div class="step active">
                            <div class="step-circle">1</div>
                            <div class="step-label">Pilih Poli</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-circle">2</div>
                            <div class="step-label">Pilih Dokter</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-circle">3</div>
                            <div class="step-label">Konfirmasi</div>
                        </div>
                    </div>
                </div>
            </div>

            @if($polis->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada poli tersedia saat ini.
                </div>
            @else
                <div class="row g-4">
                    @foreach($polis as $poli)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm poli-card-select">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="poli-icon-select me-3">
                                        @if($poli->icon)
                                            <i class="{{ $poli->icon }} fa-2x"></i>
                                        @else
                                            <i class="fas fa-hospital fa-2x"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fw-bold mb-1">{{ $poli->name }}</h5>
                                        <span class="badge bg-primary-soft text-primary">
                                            <i class="fas fa-user-md me-1"></i>{{ $poli->dokters_count }} Dokter
                                        </span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3">{{ Str::limit($poli->description, 100) }}</p>
                                <a href="{{ route('pasien.appointments.select-dokter', $poli->id) }}" 
                                   class="btn btn-primary w-100">
                                    Pilih Poli Ini <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Progress Steps */
.progress-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 0;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 8px;
}

.step.active .step-circle {
    background: #0d6efd;
    color: white;
}

.step-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.step.active .step-label {
    color: #0d6efd;
    font-weight: 600;
}

.step-line {
    width: 80px;
    height: 2px;
    background: #e9ecef;
    margin: 0 10px 24px;
}

/* Poli Card */
.poli-card-select {
    transition: all 0.3s ease;
    cursor: pointer;
}

.poli-card-select:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
}

.poli-icon-select {
    width: 60px;
    height: 60px;
    background: #e7f3ff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0d6efd;
    flex-shrink: 0;
}

.bg-primary-soft {
    background-color: rgba(13, 110, 253, 0.1);
}

@media (max-width: 768px) {
    .step-line {
        width: 40px;
    }
    
    .step-label {
        font-size: 0.75rem;
    }
}
</style>
@endsection