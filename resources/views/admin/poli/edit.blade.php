@extends('layouts.admin')
@section('title', 'Edit Poli: ' . $poli->nama_poli)
@section('content')
<div class="container-fluid">
    <h1>Edit Poli: {{ $poli->nama_poli }}</h1>
    <div class="card shadow">
        <div class="card-body">
            @include('admin.poli.form', ['poli' => $poli])
        </div>
    </div>
</div>
@endsection