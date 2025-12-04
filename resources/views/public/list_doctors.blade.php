@extends('layouts.public') {{-- Asumsi ada layout publik --}}

@section('content')
    <h2>Daftar Dokter Kami</h2>

    @forelse ($doctors as $doctor)
        <div class="doctor-card">
            <h3>{{ $doctor->name }}</h3>
            <p>Poli: <strong>{{ $doctor->poli->name ?? 'Belum Terdaftar' }}</strong></p>
            
            <a href="{{ route('public.doctor.profile', $doctor->id) }}">Lihat Profil & Jadwal</a>
        </div>
    @empty
        <p>Belum ada Dokter terdaftar saat ini.</p>
    @endforelse

    <a href="{{ route('home') }}">Kembali ke Beranda</a>
@endsection