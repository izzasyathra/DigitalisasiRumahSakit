@extends('layouts.admin')
@section('title', 'Tambah Pengguna Baru')
@section('content')
<div class="container-fluid">
    <h1>Tambah Pengguna Baru</h1>
    <div class="card shadow">
        <div class="card-body">
            @include('admin.users.form')
        </div>
    </div>
</div>
@endsection