@extends('layouts.patient')
@section('patient-content')
<h4>Halo, {{ auth()->user()->name }}!</h4>
<p>Kelola janji temu Anda melalui dashboard ini.</p>
<a href="/patient/appointments/create" class="btn btn-primary">Buat Janji Temu</a>
@endsection