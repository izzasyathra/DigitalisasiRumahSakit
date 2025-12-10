@extends('layouts.admin')
@section('title', 'Edit Obat: ' . $medicine->nama_obat)
@section('content')
<div class="container-fluid">
    <h1>Edit Obat: {{ $medicine->nama_obat }}</h1>
    <div class="card shadow">
        <div class="card-body">
            @include('admin.medicines.form', ['medicine' => $medicine])
        </div>
    </div>
</div>
@endsection