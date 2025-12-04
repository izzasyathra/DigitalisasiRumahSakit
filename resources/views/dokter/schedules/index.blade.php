<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Manajemen Jadwal Praktik 🗓️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('schedules.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg mb-4 inline-block hover:bg-indigo-700">
                    + Tambah Jadwal Baru
                </a>

                <h3 class="text-xl font-semibold mb-4 border-b pb-2">Jadwal Anda</h3>

                @if ($schedules->isEmpty())
                    <p class="text-gray-500">Anda belum memiliki jadwal praktik. Silakan tambahkan!</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Mulai</th>
                                <th>Durasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->day }}</td>
                                    <td>{{ $schedule->start_time }}</td>
                                    <td>{{ $schedule->duration_minutes }} menit</td>
                                    <td>
                                        </td>
                                </tr>
    <td>
        <a href="{{ route('schedules.edit', $schedule) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
        
        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900" 
                    onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">Hapus</button>
        </form>
    </td>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>