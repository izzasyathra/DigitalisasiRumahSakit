<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Dashboard Administrator 👑
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-red-100 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-bold">Janji Temu Pending</h3>
                        <p class="text-3xl font-extrabold text-red-700">[COUNT]</p>
                        <p class="text-sm">Perlu Approval</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-bold">Total Pengguna</h3>
                        <p class="text-3xl font-extrabold text-blue-700">[COUNT]</p>
                        <p class="text-sm">Admin, Dokter, & Pasien</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-bold">Dokter Hari Ini</h3>
                        <p class="text-3xl font-extrabold text-green-700">[COUNT]</p>
                        <p class="text-sm">Sedang Bertugas</p>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-4 border-b pb-2">Manajemen Konten (CMS)</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="/admin/users" class="bg-gray-200 p-4 rounded-lg hover:bg-gray-300 text-center">User Management</a>
                    <a href="/admin/polis" class="bg-gray-200 p-4 rounded-lg hover:bg-gray-300 text-center">Poli Management</a>
                    <a href="/admin/medicines" class="bg-gray-200 p-4 rounded-lg hover:bg-gray-300 text-center">Medicine Management</a>
                    <a href="/admin/appointments" class="bg-gray-200 p-4 rounded-lg hover:bg-gray-300 text-center">Verifikasi Janji Temu</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>