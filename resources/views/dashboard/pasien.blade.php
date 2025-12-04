<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Dashboard Pasien 🏥
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Status Janji Temu Terakhir Anda</h3>
                
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6" role="alert">
                    <p class="font-bold">Status: [STATUS JANJI TEMU]</p>
                    <p>Dokter: [NAMA DOKTER] - Tanggal: [TANGGAL]</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="/appointment/create" class="bg-indigo-600 text-white p-4 rounded-lg text-center hover:bg-indigo-700 text-lg">
                        Buat Janji Temu Baru Sekarang
                    </a>
                    <a href="/pasien/riwayat-medis" class="bg-gray-200 p-4 rounded-lg text-center hover:bg-gray-300 text-lg">
                        Akses Riwayat Rekam Medis
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>