@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Validasi Janji Temu</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter / Poli</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $key => $apt)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $apt->tanggal_booking }}</td>
                            <td>{{ $apt->nama_pasien }}</td>
                            <td>
                                <strong>{{ $apt->nama_dokter }}</strong><br>
                                <small class="text-muted">{{ $apt->nama_poli }}</small>
                            </td>
                            <td>{{ $apt->keluhan_singkat }}</td>
                            <td>
                                @if($apt->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($apt->status == 'Approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($apt->status == 'Rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $apt->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($apt->status == 'Pending')
                                    <form action="{{ route('admin.validation.update', $apt->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Approved">
                                        <button class="btn btn-success btn-sm" title="Setujui">✔</button>
                                    </form>
                                    <form action="{{ route('admin.validation.update', $apt->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Rejected">
                                        <button class="btn btn-danger btn-sm" title="Tolak">✖</button>
                                    </form>
                                @else
                                    <small class="text-muted">Selesai</small>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data janji temu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection