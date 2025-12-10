@extends('layouts.guest_app') {{-- Pastikan pakai layout guest yg ada navbar publik --}}

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Layanan Poliklinik</h2>
        <p class="text-muted">Pilih layanan kesehatan spesialis yang sesuai dengan kebutuhan Anda.</p>
    </div>

    <div class="row g-4">
        @forelse($polis as $poli)
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-heartbeat fa-2x"></i> {{-- Bisa diganti icon dinamis jika ada --}}
                        </div>
                        <h4 class="card-title fw-bold">{{ $poli->name }}</h4>
                        <p class="card-text text-muted small mt-2">
                            {{ $poli->description ?? 'Melayani konsultasi dan pengobatan spesialis ' . $poli->name }}
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4 text-center">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">Daftar Berobat</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada data poli.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection