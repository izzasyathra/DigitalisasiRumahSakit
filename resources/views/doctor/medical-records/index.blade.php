@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-700 mb-6 flex items-center">
        <i class="fas fa-history text-blue-500 mr-3"></i> Riwayat Pemeriksaan
    </h2>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Nama Pasien</th>
                    <th class="px-6 py-4">Diagnosis</th>
                    <th class="px-6 py-4">Tindakan</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($records as $record)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($record->tanggal_berobat)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $record->patient->name }}</td>
                    <td class="px-6 py-4 text-blue-600 font-medium">{{ $record->diagnosis }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ Str::limit($record->tindakan_medis, 50) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                        Belum ada riwayat pemeriksaan medis.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection