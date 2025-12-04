<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Buat Jadwal Praktik Baru 📅
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('schedules.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="day" class="block text-sm font-medium text-gray-700">Hari</label>
                        <select name="day" id="day" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            </select>
                    </div>

                    <div class="mb-4">
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                        <input type="time" name="start_time" id="start_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-6">
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Durasi</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" value="30" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                        <p class="text-xs text-gray-500 mt-1">Durasi konsultasi ditetapkan 30 menit sesuai aturan.</p>
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Simpan Jadwal
                    </button>
                    <a href="{{ route('schedules.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>