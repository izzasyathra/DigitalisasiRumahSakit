@extends('layouts.public')

@section('content')
    <h2>Profil Dokter: {{ $doctor->name }}</h2>
    
    <p>Email: {{ $doctor->email }}</p>
    <p>Poli Spesialisasi: <strong>{{ $doctor->poli->name ?? 'N/A' }}</strong></p>
    
    <h3>Jadwal Praktik (Read-Only)</h3>
    @if ($schedules->isEmpty())
        <p>Dokter ini belum memiliki jadwal praktik yang diatur.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Durasi Slot</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</td>
                        <td>{{ $schedule->duration_minutes }} Menit</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    <p>
        <a href="{{ route('login') }}">Login untuk Membuat Janji Temu</a>
    </p>

    <a href="{{ route('public.doctors') }}">Kembali ke Daftar Dokter</a>
@endsection