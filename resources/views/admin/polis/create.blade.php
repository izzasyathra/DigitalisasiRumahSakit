@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg bg-white p-6 shadow rounded">

    <h1 class="text-2xl font-bold mb-4">Tambah Poli</h1>

    <form method="POST" action="{{ route('polis.store') }}">
        @csrf

        <label class="block mb-2 font-semibold">Nama Poli</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2 mb-4" required>

        <label class="block mb-2 font-semibold">Deskripsi</label>
        <textarea name="description" class="w-full border rounded px-3 py-2 mb-4"></textarea>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>

</div>
@endsection
