@extends('layouts.guest_app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Tim Dokter Kami</h2>
        <p class="text-muted">Dokter profesional dan berpengalaman siap melayani Anda.</p>
    </div>

    <div class="row g-4">
        @forelse($doctors as $doctor)
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow rounded-3 h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                            {{ substr($doctor->name, 0, 1) }}
                        </div>
                        
                        <h5 class="fw-bold text-dark mb-1">{{ $doctor->name }}</h5>
                        <span class="badge bg-info text-white mb-3">
                            {{ $doctor->poli->name ?? 'Dokter Umum' }}
                        </span>
                        
                        <p class="text-muted small">Siap memberikan pelayanan medis terbaik untuk kesehatan Anda.</p>
                        
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 rounded-pill mt-2">Buat Janji</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Data dokter belum tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection