<!DOCTYPE html>
<html>
<head>
    <title>Digital Hospital - Layanan & Jadwal Dokter</title>
</head>
<body>
    <header>
        <a href="{{ route('login') }}">Log in</a>
        <a href="{{ route('register') }}">Register</a>
    </header>

    <h1>Layanan & Jadwal Dokter</h1>
    
    <h2>Daftar Poli 🏥</h2>
    
    <div class="poli-list">
        @foreach ($polis as $poli)
            <div class="card">
                <h3>{{ $poli->name }}</h3>
                <p>{{ $poli->description }}</p>
                <a href="{{ route('public.doctors', ['poli_id' => $poli->id]) }}">Lihat Dokter & Jadwal</a>            </div>
        @endforeach
    </div>
    
    <p><a href="{{ route('public.doctors') }}">Lihat Semua Dokter</a></p>
</body>
</html>