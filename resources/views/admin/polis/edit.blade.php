<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Edit Poli: {{ $poli->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.polis.update', $poli) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Poli</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $poli->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $poli->description) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="icon" class="block text-sm font-medium text-gray-700">Ikon/Gambar (URL)</label>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $poli->icon) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Perbarui Poli
                    </button>
                    <a href="{{ route('admin.polis.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>