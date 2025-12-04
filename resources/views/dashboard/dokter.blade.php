<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Dashboard Dokter 👨‍⚕️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-red-100 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-bold">Janji Temu Pending</h3>
                        <p class="text-3xl font-extrabold text-red-700">{{ $pendingAppointments->count() ?? 0 }}</p>
                        <p class="text-sm">Menunggu Validasi Anda</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-bold">Antrean Konsultasi Hari Ini</h3>
                        <p class="text-3xl font-extrabold text-green-700">{{ $approvedAppointments->count() ?? 0 }}</p>
                        <p class="text-sm">Janji Temu Disetujui</p>
                    </div>
                    <a href="/dokter/schedules" class="bg-blue-100 p-4 rounded-lg shadow hover:bg-blue-200 flex flex-col justify-center text-center">
                        <h3 class="text-lg font-bold">Atur Jadwal Praktik</h3>
                        <p class="text-sm">Akses Cepat</p>
                    </a>
                </div>

                <h3 class="text-xl font-semibold mb-4 border-b pb-2">5 Pasien Terbaru Diperiksa</h3>
                </div>
        </div>
    </div>
</x-app-layout>