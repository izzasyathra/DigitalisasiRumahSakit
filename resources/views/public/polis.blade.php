@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Daftar Poli</h1>
    <div class="grid grid-cols-3 gap-6">
        @foreach($polis as $poli)
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold">{{ $poli->nama }}</h3>
            <p>{{ $poli->deskripsi }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection