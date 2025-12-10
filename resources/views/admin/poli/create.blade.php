@extends('layouts.admin')
@section('title', 'Tambah Poli Baru')
@section('content')
<div class="container-fluid">
    <h1>Tambah Poli Baru</h1>
    <div class="card shadow">
        <div class="card-body">
            @include('admin.poli.form')
        </div>
    </div>
</div>
@endsection