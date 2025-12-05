@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Daftar Dokter</h1>
    <div class="grid grid-cols-3 gap-6">
        @foreach($dokters as $dokter)
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold">{{ $dokter->username }}</h3>
            <p>{{ $dokter->poli->nama ?? 'N/A' }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection