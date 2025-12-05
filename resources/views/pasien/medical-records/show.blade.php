@extends('layouts.app')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('pasien.medical-records.index') }}" class="text-gray-700 hover:text-blue-600">
                            Rekam Medis
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-purple-600 font-semibold">Detail</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-file-medical-alt"></i> Rekam Medis
                </h1>
                <p class="text-purple-100">ID: #{{ str_pad($record->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <div class="bg-white bg-opacity-20 rounded-lg px-6 py-3">
                    <p class="text-sm text-purple-100">Tanggal Konsultasi</p>
                    <p class="text-2xl font-bold">{{ $record->created_at->format('d M Y') }}</p>
                    <p class="text-sm text-purple-100">{{ $record->created_at->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Doctor Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-md text-purple-600 mr-2"></i>
                    Dokter yang Menangani
                </h2>
                <div class="flex items-center space-x-4 p-4 bg-purple-50 rounded-lg">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-4xl text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $record->dokter->username }}</h3>
                        <p class="text-purple-600 font-semibold">
                            <i class="fas fa-hospital"></i> {{ $record->dokter->poli->nama ?? 'N/A' }}
                        </p>
                        @if($record->dokter->phone)
                        <p class="text-gray-600 text-sm mt-1">
                            <i class="fas fa-phone"></i> {{ $record->dokter->phone }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Patient Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Data Pasien
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Nama Lengkap</p>
                        <p class="font-bold text-gray-800">{{ $record->pasien->username }}</p>
                    </div>
                    @if($record->pasien->birth_date)
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Tanggal Lahir</p>
                        <p class="font-bold text-gray-800">{{ $record->pasien->birth_date->format('d F Y') }}</p>
                        <p class="text-xs text-gray-500">Usia: {{ $record->pasien->birth_date->age }} tahun</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-stethoscope text-red-600 mr-2"></i>
                    Diagnosis
                </h2>
                <div class="p-5 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <p class="text-gray-800 leading-relaxed text-lg">{{ $record->diagnosis }}</p>
                </div>
            </div>

            <!-- Tindakan Medis -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-procedures text-blue-600 mr-2"></i>
                    Tindakan Medis
                </h2>
                <div class="p-5 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                    <p class="text-gray-800 leading-relaxed">{{ $record->tindakan }}</p>
                </div>
            </div>

            <!-- Catatan Dokter -->
            @if($record->catatan)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-clipboard text-yellow-600 mr-2"></i>
                    Catatan Tambahan
                </h2>
                <div class="p-5 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                    <p class="text-gray-800 leading-relaxed">{{ $record->catatan }}</p>
                </div>
            </div>
            @endif

            <!-- Resep Obat -->
            @if($record->prescriptions->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-pills text-green-600 mr-2"></i>
                    Resep Obat ({{ $record->prescriptions->count() }} Item)
                </h2>
                
                <div class="space-y-3">
                    @foreach($record->prescriptions as $index => $prescription)
                    <div class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg hover:shadow-md transition">
                        <div class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-lg">{{ $prescription->medicine->nama }}</h4>
                            <p class="text-sm text-gray-600">{{ $prescription->medicine->deskripsi }}</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="px-3 py-1 bg-{{ $prescription->medicine->tipe == 'keras' ? 'red' : 'blue' }}-100 text-{{ $prescription->medicine->tipe == 'keras' ? 'red' : 'blue' }}-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-prescription-bottle"></i> 
                                    {{ ucfirst($prescription->medicine->tipe) }}
                                </span>
                                <span class="text-sm text-gray-600">
                                    <i class="fas fa-boxes"></i> Stok: {{ $prescription->medicine->stok }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Jumlah</p>
                            <p class="text-3xl font-bold text-green-600">{{ $prescription->jumlah }}</p>
                            <p class="text-xs text-gray-500">unit</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Prescription Summary -->
                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-700">Total Jenis Obat:</span>
                        <span class="text-2xl font-bold text-gray-800">{{ $record->prescriptions->count() }}</span>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-300 rounded-lg">
                    <h4 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                        Catatan Penting Penggunaan Obat
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Konsumsi sesuai dosis yang dianjurkan</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Jangan menghentikan pengobatan tanpa konsultasi dokter</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Simpan obat di tempat yang sejuk dan kering</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Segera hubungi dokter jika ada efek samping</li>
                    </ul>
                </div>
            </div>
            @endif

            <!-- Related Appointment -->
            @if($record->appointment)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-link text-gray-600 mr-2"></i>
                    Janji Temu Terkait
                </h2>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Booking ID</p>
                            <p class="font-bold text-gray-800">#{{ str_pad($record->appointment->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-sm text-gray-600 mt-2">Tanggal Booking</p>
                            <p class="text-gray-800">{{ $record->appointment->tanggal_booking->format('d F Y') }}</p>
                        </div>
                        <a href="{{ route('pasien.appointments.show', $record->appointment->id) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4 space-y-4">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-cog text-gray-600"></i> Aksi
                </h2>

                <!-- Action Buttons -->
                <a href="{{ route('pasien.medical-records.index') }}" 
                   class="block w-full bg-gray-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>

                <button onclick="window.print()" 
                        class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    <i class="fas fa-print"></i> Cetak Rekam Medis
                </button>

                <button onclick="downloadPDF()" 
                        class="w-full bg-green-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                    <i class="fas fa-download"></i> Download PDF
                </button>

                <!-- Quick Summary -->
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3">
                        <i class="fas fa-info-circle text-blue-600"></i> Ringkasan
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-semibold text-gray-800">{{ $record->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Waktu:</span>
                            <span class="font-semibold text-gray-800">{{ $record->created_at->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dokter:</span>
                            <span class="font-semibold text-gray-800">{{ Str::limit($record->dokter->username, 15) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Poli:</span>
                            <span class="font-semibold text-gray-800">{{ Str::limit($record->dokter->poli->nama ?? 'N/A', 15) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Resep Obat:</span>
                            <span class="font-semibold text-gray-800">{{ $record->prescriptions->count() }} item</span>
                        </div>
                    </div>
                </div>

                <!-- Health Tip -->
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3">
                        <i class="fas fa-lightbulb text-yellow-500"></i> Tips Kesehatan
                    </h3>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <p class="text-xs text-gray-700 leading-relaxed">
                            Simpan rekam medis Anda dengan baik. Ini berguna untuk konsultasi di masa mendatang dan membantu dokter memahami riwayat kesehatan Anda secara lengkap.
                        </p>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="pt-4">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <h4 class="font-bold text-red-700 text-sm mb-2">
                            <i class="fas fa-phone-alt"></i> Darurat?
                        </h4>
                        <p class="text-xs text-gray-700">
                            Hubungi nomor darurat rumah sakit: <br>
                            <span class="font-bold text-red-600">119 atau (0411) 123-4567</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadPDF() {
    alert('Fitur download PDF akan segera tersedia!');
    // TODO: Implementasi download PDF
}
</script>

<style>
@media print {
    nav, button, .sticky, form {
        display: none !important;
    }
    .bg-white {
        break-inside: avoid;
    }
}
</style>
@endsection