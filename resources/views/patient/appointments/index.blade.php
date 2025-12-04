@extends('layouts.patient')

@section('content')
    <h2>Riwayat Janji Temu Saya</h2>
    
    @if (session('success')) <div style="color: green;">{{ session('success') }}</div> @endif

    <table>
        <thead>
            <tr>
                <th>Tanggal/Waktu</th>
                <th>Dokter Tujuan</th>
                <th>Poli</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ Carbon\Carbon::parse($appointment->booking_date)->format('d M Y') }} - {{ Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->doctor->poli->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->short_complaint }}</td>
                    <td>
                        <strong style="color: 
                            @if($appointment->status == 'Approved') green 
                            @elseif($appointment->status == 'Rejected') red 
                            @elseif($appointment->status == 'Selesai') blue
                            @else orange 
                            @endif;">
                            {{ $appointment->status }}
                        </strong>
                    </td>
                    <td>{{ $appointment->rejection_reason ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Anda belum memiliki riwayat Janji Temu. <a href="{{ route('patient.appointments.book') }}">Buat sekarang!</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection