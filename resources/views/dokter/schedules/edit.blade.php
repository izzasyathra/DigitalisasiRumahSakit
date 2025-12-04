<x-app-layout>
    <x-slot name="header">
        </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('schedules.update', $schedule) }}">
                    @csrf
                    @method('PUT') 

                    <div class="mb-4">
                        <label for="day" class="block text-sm font-medium text-gray-700">Hari</label>
                        <select name="day" id="day" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                                <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                        <input type="time" name="start_time" id="start_time" 
                               value="{{ old('start_time', $schedule->start_time) }}" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-6">
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Durasi</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" 
                            value="{{ old('duration_minutes', $schedule->duration_minutes) }}" readonly 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Update Jadwal
                    </button>
                    <a href="{{ route('schedules.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Batal</a>
                
                </form> </div>
        </div>
    </div>
</x-app-layout>