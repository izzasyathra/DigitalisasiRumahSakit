@extends('layouts.app')

@section('title', 'Rekam Medis Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-file-medical-alt"></i> Rekam Medis Saya
                </h1>
                <p class="text-purple-100">Riwayat kesehatan dan konsultasi Anda</p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <p class="text-sm text-purple-100">Total Rekam Medis</p>
                    <p class="text-4xl font-bold">{{ $records->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 text-2xl mr-4 mt-1"></i>
            <div>
                <h4 class="font-bold text-gray-800 mb-1">Tentang Rekam Medis</h4>
                <p class="text-gray-600 text-sm">
                    Rekam medis berisi catatan lengkap hasil konsultasi, diagnosis, tindakan medis, dan resep obat dari setiap kunjungan Anda. 
                    Data ini penting untuk pemantauan kesehatan jangka panjang.
                </p>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="{{ route('pasien.medical-records.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari diagnosis atau catatan..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
            <a href="{{ route('pasien.medical-records.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Medical Records List -->
    @forelse($records as $record)
    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition mb-4">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-notes-medical text-3xl text-white"></i>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="px-3 py-1 bg-purple-600 text-white rounded-full text-xs font-bold">
                                <i class="fas fa-calendar"></i> {{ $record->created_at->format('d F Y') }}
                            </span>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $record->dokter->username }}</h3>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-hospital text-purple-600"></i> {{ $record->dokter->poli->nama ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('pasien.medical-records.show', $record->id) }}" 
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                    <i class="fas fa-eye"></i> Detail
                </a>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Diagnosis -->
                <div class="p-4 bg-purple-50 rounded-lg">
                    <div class="flex items-start mb-2">
                        <i class="fas fa-stethoscope text-purple-600 mr-2 mt-1"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-600 mb-1">Diagnosis:</p>
                            <p class="text-gray-800">{{ Str::limit($record->diagnosis, 100) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tindakan -->
                <div class="p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-start mb-2">
                        <i class="fas fa-procedures text-blue-600 mr-2 mt-1"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-600 mb-1">Tindakan:</p>
                            <p class="text-gray-800">{{ Str::limit($record->tindakan, 100) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescriptions Summary -->
            @if($record->prescriptions->count() > 0)
            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-pills text-green-600 text-2xl mr-3"></i>
                        <div>
                            <p class="font-semibold text-gray-800">Resep Obat</p>
                            <p class="text-sm text-gray-600">{{ $record->prescriptions->count() }} jenis obat diresepkan</p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-2">
                        @foreach($record->prescriptions->take(3) as $prescription)
                        <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">
                            {{ $prescription->medicine->nama }}
                        </span>
                        @endforeach
                        @if($record->prescriptions->count() > 3)
                        <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-semibold">
                            +{{ $record->prescriptions->count() - 3 }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Footer Info -->
            <div class="mt-4 pt-4 border-t border-gray-200 flex items-center justify-between text-sm text-gray-500">
                <span>
                    <i class="fas fa-clock"></i> Konsultasi: {{ $record->created_at->format('H:i') }} WIB
                </span>
                <span>
                    <i class="fas fa-hashtag"></i> ID: {{ str_pad($record->id, 6, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-file-medical text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Rekam Medis</h3>
        <p class="text-gray-500 mb-4">Rekam medis akan muncul setelah Anda menyelesaikan konsultasi dengan dokter</p>
        <a href="{{ route('pasien.appointments.select-poli') }}" 
           class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
            <i class="fas fa-calendar-plus"></i> Buat Janji Temu
        </a>
    </div>
    @endforelse

    <!-- Pagination -->
    @if($records->hasPages())
    <div class="mt-6">
        {{ $records->links() }}
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Konsultasi Tahun Ini</p>
                    <h3 class="text-3xl font-bold text-purple-600">
                        {{ auth()->user()->medicalRecordsAsPasien->where('created_at', '>=', now()->startOfYear())->count() }}
                    </h3>
                </div>
                <i class="fas fa-calendar-check text-4xl text-purple-200"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div>
                <p class="text-gray-500 text-sm font-semibold mb-2">Dokter yang Pernah Menangani</p>
                <div class="flex items-center">
                    <div class="flex -space-x-2">
                        @foreach(auth()->user()->medicalRecordsAsPasien->unique('dokter_id')->take(3) as $record)
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center border-2 border-white">
                            <span class="text-white text-xs font-bold">{{ substr($record->dokter->username, 0, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <span class="ml-3 text-2xl font-bold text-blue-600">
                        {{ auth()->user()->medicalRecordsAsPasien->unique('dokter_id')->count() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Resep Obat</p>
                    <h3 class="text-3xl font-bold text-green-600">
                        {{ auth()->user()->medicalRecordsAsPasien->sum(function($record) { return $record->prescriptions->count(); }) }}
                    </h3>
                </div>
                <i class="fas fa-pills text-4xl text-green-200"></i>
            </div>
        </div>
    </div>

    <!-- Download All Records Button -->
    <div class="mt-6 text-center">
        <button onclick="window.print()" 
                class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition">
            <i class="fas fa-download"></i> Download Semua Rekam Medis (PDF)
        </button>
    </div>
</div>

<style>
@media print {
    nav, button, .shadow-md, .sticky {
        display: none !important;
    }
    .bg-white {
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }
}
</style>
@endsection