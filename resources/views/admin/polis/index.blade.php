@extends('layouts.app')

@section('content')
<div class="container mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Poli</h1>
        <a href="{{ route('polis.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Poli</a>
    </div>

    <table class="w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Nama Poli</th>
                <th class="py-3 px-4">Deskripsi</th>
                <th class="py-3 px-4">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($polis as $p)
            <tr class="border-b">
                <td class="py-3 px-4">{{ $p->id }}</td>
                <td class="py-3 px-4">{{ $p->name }}</td>
                <td class="py-3 px-4">{{ $p->description }}</td>
                <td class="py-3 px-4 flex gap-2">
                    <a href="{{ route('polis.edit', $p->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>

                    <form action="{{ route('polis.destroy', $p->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus?')" class="bg-red-600 text-white px-3 py-1 rounded">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>
@endsection
