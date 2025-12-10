<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digitalisasi Rumah Sakit | Beranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    {{-- Memuat aset CSS dari Vite/NPM --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    
    <header id="navbar">
        <div class="logo">
            <i class="fas fa-hospital-alt"></i> RS Digital
        </div>
        <nav class="nav-links">
            <a href="#" class="active">Beranda</a>
            <a href="{{ route('login') }}" class="btn-primary">Login / Register</a> {{-- Menggunakan helper route Laravel --}}
        </nav>
        <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
    </header>

    <section id="hero-section" class="section">
        <div class="hero-content">
            <h1>Layanan Kesehatan Digital di Genggaman Anda</h1>
            <p>Jadwalkan janji temu, akses rekam medis, dan temukan dokter terbaik dengan mudah dan cepat.</p>
            <a href="{{ route('login') }}" class="btn-cta">Buat Janji Temu Sekarang</a>
            {{-- Sesuaikan rute di bawah ini nanti, untuk sementara kembali ke home --}}
            <a href="{{ route('guest.home') }}" class="btn-secondary">Lanjutkan Sebagai Tamu</a>
        </div>
    </section>

    <section id="feature-section" class="section">
        <div class="container">
            <h2 class="section-title">Akses Informasi Publik</h2>
            <div class="feature-grid">
                
                <a href="{{ route('guest.poli.index') }}" class="feature-item-link"> 
                    <div class="feature-item">
                        <i class="fas fa-list-alt"></i>
                        <h3>Daftar Poli</h3>
                        <p>Lihat seluruh spesialisasi Poli yang tersedia di rumah sakit kami.</p>
                    </div>
                </a>
                
                <a href="{{ route('guest.poli.index') }}" class="feature-item-link"> 
                    <div class="feature-item">
                        <i class="fas fa-user-md"></i>
                        <h3>Profil Dokter</h3>
                        <p>Cek profil dan kualifikasi setiap dokter secara detail.</p>
                    </div>

                    <a href="{{ route('guest.poli.index') }}" class="feature-item-link"> 
                    <div class="feature-item">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Jadwal Praktik</h3>
                        <p>Ketahui jadwal praktik dokter secara real-time untuk kunjungan Anda.</p>
                    </div>
                </div>
            </div>
        </section>

    <footer>
        <p>&copy; 2025 RS Digital. Hak Cipta Dilindungi.</p>
    </footer>

    {{-- Script JS sudah dimuat di bagian head menggunakan @vite --}}
</body>
</html>