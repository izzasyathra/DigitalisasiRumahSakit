@extends('layouts.app')

@section('content')
{{-- Hero Section with Full Width Gradient --}}
<div class="hero-wrapper">
    <div class="hero-content">
        <div class="container">
            <div class="row align-items-center min-vh-80">
                <div class="col-lg-7">
                    <div class="badge-pill mb-4">
                        <i class="fas fa-shield-alt me-2"></i>Terpercaya 
                    </div>
                    <h1 class="hero-heading mb-4">
                        Solusi Kesehatan<br>
                        <span class="highlight-text">Modern & Terpadu</span>
                    </h1>
                    <p class="hero-description mb-5">
                        Platform digital yang memudahkan Anda dalam mengelola kesehatan. 
                        Booking cepat, konsultasi mudah, dan rekam medis aman dalam satu sistem.
                    </p>
                    @guest
                        <div class="button-group">
                            <a href="{{ route('register') }}" class="btn-hero btn-primary-hero">
                                Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                            <a href="{{ route('login') }}" class="btn-hero btn-outline-hero">
                                Login
                            </a>
                        </div>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-hero btn-primary-hero">
                            Ke Dashboard <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @endguest
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="hero-illustration">
                        <div class="illustration-card card-1">
                            <i class="fas fa-heartbeat"></i>
                            <span>Health Monitoring</span>
                        </div>
                        <div class="illustration-card card-2">
                            <i class="fas fa-calendar-check"></i>
                            <span>Easy Booking</span>
                        </div>
                        <div class="illustration-card card-3">
                            <i class="fas fa-user-md"></i>
                            <span>Expert Doctors</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,96L48,112C96,128,192,160,288,165.3C384,171,480,149,576,128C672,107,768,85,864,90.7C960,96,1056,128,1152,138.7C1248,149,1344,139,1392,133.3L1440,128L1440,200L1392,200C1344,200,1248,200,1152,200C1056,200,960,200,864,200C768,200,672,200,576,200C480,200,384,200,288,200C192,200,96,200,48,200L0,200Z" fill="#ffffff"/>
        </svg>
    </div>
</div>

{{-- Stats Bar --}}
<div class="stats-bar">
    <div class="container">
        <div class="row g-0">
            <div class="col-md-4">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $polis->count() }}+</h3>
                        <p class="stat-label">Poli Spesialis</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item stat-item-middle">
                    <div class="stat-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $dokters->count() }}+</h3>
                        <p class="stat-label">Dokter Berpengalaman</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">24/7</h3>
                        <p class="stat-label">Layanan Darurat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Poli Section with Modern Cards --}}
<div class="section-poli">
    <div class="container">
        <div class="section-head text-center mb-5">
            <span class="section-tag">Layanan Unggulan</span>
            <h2 class="section-heading mt-3">Poli Spesialis Kami</h2>
            <p class="section-subheading">Layanan kesehatan lengkap untuk semua kebutuhan Anda</p>
        </div>

        @if($polis->isEmpty())
            <div class="empty-box">
                <i class="fas fa-hospital-alt fa-4x mb-3"></i>
                <p>Belum ada poli tersedia saat ini</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($polis as $poli)
                <div class="col-md-6 col-lg-4">
                    <div class="modern-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern">
                                @if($poli->icon)
                                    <i class="{{ $poli->icon }}"></i>
                                @else
                                    <i class="fas fa-hospital"></i>
                                @endif
                            </div>
                            <span class="card-badge">{{ $poli->dokters_count }} Dokter</span>
                        </div>
                        <div class="card-body-modern">
                            <h5 class="card-title-modern">{{ $poli->name }}</h5>
                            <p class="card-text-modern">{{ Str::limit($poli->description, 90) }}</p>
                        </div>
                        <div class="card-footer-modern">
                            <a href="{{ route('public.polis.show', $poli->id) }}" class="card-link-modern">
                                Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Doctors Section with Grid Layout --}}
<div class="section-doctors">
    <div class="container">
        <div class="section-head text-center mb-5">
            <span class="section-tag">Tim Medis</span>
            <h2 class="section-heading mt-3">Bertemu Dengan Dokter Kami</h2>
            <p class="section-subheading">Profesional, berpengalaman, dan siap membantu Anda</p>
        </div>

        @if($dokters->isEmpty())
            <div class="empty-box">
                <i class="fas fa-user-md fa-4x mb-3"></i>
                <p>Belum ada dokter tersedia saat ini</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($dokters as $dokter)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="doctor-modern-card">
                        <div class="doctor-image-wrapper">
                            @if($dokter->photo)
                                <img src="{{ asset('storage/' . $dokter->photo) }}" alt="{{ $dokter->username }}" class="doctor-image">
                            @else
                                <div class="doctor-image-placeholder">
                                    <i class="fas fa-user-md fa-3x"></i>
                                </div>
                            @endif
                            @if($dokter->poli)
                                <div class="doctor-specialty-badge">
                                    {{ $dokter->poli->name }}
                                </div>
                            @endif
                        </div>
                        <div class="doctor-info-wrapper">
                            <h6 class="doctor-name-modern">{{ $dokter->username }}</h6>
                            <a href="{{ route('public.dokters.show', $dokter->id) }}" class="doctor-view-profile">
                                Lihat Profil <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('public.dokters') }}" class="btn-see-all">
                    Lihat Semua Dokter
                </a>
            </div>
        @endif
    </div>
</div>

{{-- CTA Section --}}
<div class="cta-modern">
    <div class="container text-center">
        <div class="cta-content">
            <h2 class="cta-heading">Siap Untuk Memulai?</h2>
            <p class="cta-text">Bergabunglah dengan ribuan pasien yang telah mempercayai kami</p>
            @guest
                <a href="{{ route('register') }}" class="btn-cta">
                    Daftar Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </a>
            @else
                @if(auth()->user()->role === 'pasien')
                    <a href="{{ route('pasien.appointments.select-poli') }}" class="btn-cta">
                        Buat Janji Temu <i class="fas fa-calendar-plus ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-cta">
                        Ke Dashboard <i class="fas fa-tachometer-alt ms-2"></i>
                    </a>
                @endif
            @endguest
        </div>
    </div>
</div>

{{-- Footer --}}
<footer class="modern-footer">
    <div class="container text-center">
        <p class="footer-copyright">© 2024 Hospital System. All rights reserved.</p>
    </div>
</footer>

<style>
/* Color Variables */
:root {
    --primary: #1e40af;
    --primary-dark: #1e3a8a;
    --secondary: #10b981;
    --text-dark: #1f2937;
    --text-muted: #6b7280;
    --bg-light: #f9fafb;
}

/* Hero Section */
.hero-wrapper {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
    position: relative;
    overflow: hidden;
}

.hero-content {
    padding: 80px 0 120px;
    position: relative;
    z-index: 2;
}

.min-vh-80 {
    min-height: 80vh;
}

.badge-pill {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
}

.hero-heading {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    line-height: 1.2;
}

.highlight-text {
    background: linear-gradient(to right, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-description {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.7;
    max-width: 600px;
}

.button-group {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.btn-hero {
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-primary-hero {
    background: white;
    color: var(--primary);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.btn-primary-hero:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    color: var(--primary-dark);
}

.btn-outline-hero {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-outline-hero:hover {
    background: white;
    color: var(--primary);
}

/* Hero Illustration */
.hero-illustration {
    position: relative;
    height: 400px;
}

.illustration-card {
    position: absolute;
    background: white;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    animation: float 3s ease-in-out infinite;
}

.illustration-card i {
    font-size: 2rem;
    color: var(--primary);
}

.illustration-card span {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
}

.card-1 {
    top: 50px;
    left: 50px;
}

.card-2 {
    top: 150px;
    right: 50px;
    animation-delay: 0.5s;
}

.card-3 {
    bottom: 50px;
    left: 80px;
    animation-delay: 1s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
}

.hero-wave svg {
    width: 100%;
    height: auto;
}

/* Stats Bar */
.stats-bar {
    margin-top: -60px;
    position: relative;
    z-index: 10;
    padding: 0 15px;
}

.stat-item {
    background: white;
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-item-middle {
    border-left: 1px solid #e5e7eb;
    border-right: 1px solid #e5e7eb;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

/* Section Styling */
.section-poli,
.section-doctors {
    padding: 100px 0;
}

.section-poli {
    background: white;
}

.section-doctors {
    background: var(--bg-light);
}

.section-tag {
    display: inline-block;
    background: #dbeafe;
    color: var(--primary);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.section-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
}

.section-subheading {
    font-size: 1.125rem;
    color: var(--text-muted);
    max-width: 600px;
    margin: 0 auto;
}

/* Modern Cards */
.modern-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.modern-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
}

.card-header-modern {
    padding: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-icon-modern {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.card-badge {
    background: #dbeafe;
    color: var(--primary);
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

.card-body-modern {
    padding: 0 24px 24px;
    flex: 1;
}

.card-title-modern {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 12px;
}

.card-text-modern {
    font-size: 0.9375rem;
    color: var(--text-muted);
    line-height: 1.6;
}

.card-footer-modern {
    padding: 0 24px 24px;
}

.card-link-modern {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
}

.card-link-modern:hover {
    color: var(--primary-dark);
}

/* Doctor Modern Cards */
.doctor-modern-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.doctor-modern-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.doctor-image-wrapper {
    position: relative;
    width: 100%;
    height: 240px;
    overflow: hidden;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
}

.doctor-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.doctor-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}

.doctor-specialty-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: white;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.doctor-info-wrapper {
    padding: 20px;
    text-align: center;
}

.doctor-name-modern {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 12px;
}

.doctor-view-profile {
    color: var(--primary);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.doctor-view-profile:hover {
    color: var(--primary-dark);
}

.btn-see-all {
    padding: 14px 40px;
    background: white;
    color: var(--primary);
    border: 2px solid var(--primary);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-see-all:hover {
    background: var(--primary);
    color: white;
}

/* CTA Modern */
.cta-modern {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 100px 0;
}

.cta-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 16px;
}

.cta-text {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 40px;
}

.btn-cta {
    padding: 16px 40px;
    background: white;
    color: var(--primary);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.125rem;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.btn-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    color: var(--primary-dark);
}

/* Footer */
.modern-footer {
    background: white;
    padding: 32px 0;
    border-top: 1px solid #e5e7eb;
}

.footer-copyright {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin: 0;
}

/* Empty State */
.empty-box {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-muted);
}

/* Responsive */
@media (max-width: 992px) {
    .hero-heading {
        font-size: 2.5rem;
    }
    
    .section-heading {
        font-size: 2rem;
    }
    
    .cta-heading {
        font-size: 2rem;
    }
    
    .stat-item-middle {
        border: none;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }
}

@media (max-width: 768px) {
    .hero-heading {
        font-size: 2rem;
    }
    
    .hero-content {
        padding: 60px 0 100px;
    }
}
</style>
@endsection