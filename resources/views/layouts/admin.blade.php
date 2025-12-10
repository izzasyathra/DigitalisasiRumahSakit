<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Digital Hospital</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Google Fonts: Poppins (Agar sama dengan Guest) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- GLOBAL STYLE (Meniru Gaya Guest) --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6; /* Abu-abu sangat muda (mirip Tailwind bg-gray-50) */
            overflow-x: hidden;
        }

        /* --- SIDEBAR MODERN GRADIENT --- */
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -17rem;
            transition: margin .25s ease-out;
            /* Gradient Biru Elegan (Sama dengan Guest Hero) */
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1.5rem;
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            text-align: center;
            background: rgba(0, 0, 0, 0.1); /* Sedikit gelap di header sidebar */
            letter-spacing: 1px;
        }

        #sidebar-wrapper .list-group {
            width: 17rem;
            padding: 1rem;
        }

        /* --- MENU ITEM STYLE --- */
        .list-group-item {
            border: none;
            padding: 12px 20px;
            margin-bottom: 5px;
            border-radius: 10px !important; /* Membuat sudut membulat modern */
            background-color: transparent;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        /* Efek Hover Menu */
        .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.15); /* Glass effect */
            color: #fff;
            transform: translateX(5px); /* Animasi geser sedikit */
        }

        /* Menu Aktif */
        .list-group-item.active {
            background-color: white !important;
            color: #1e40af !important; /* Teks jadi biru */
            font-weight: 700;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Tombol Logout Spesial */
        .menu-logout {
            margin-top: 2rem;
            color: #fca5a5 !important; /* Merah muda soft */
        }
        .menu-logout:hover {
            background-color: rgba(220, 38, 38, 0.1) !important;
            color: #fca5a5 !important;
        }

        /* --- CONTENT WRAPPER --- */
        #page-content-wrapper {
            min-width: 100vw;
            transition: all 0.3s ease;
        }

        /* --- NAVBAR STYLE --- */
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04); /* Bayangan halus */
            padding: 1rem 1.5rem;
        }

        .btn-toggle {
            color: #1e40af;
            font-size: 1.2rem;
            border: none;
            background: transparent;
        }

        /* Responsive Logic */
        body.sb-sidenav-toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
            body.sb-sidenav-toggled #sidebar-wrapper { margin-left: -17rem; }
        }

        /* Style Card di dalam konten agar senada */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .card-header {
            background-color: white;
            border-bottom: 1px solid #f3f4f6;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <i class="fas fa-hospital-alt me-2"></i> RS Digital
        </div>
        <div class="list-group list-group-flush">
            
            <small class="text-white-50 px-3 mb-2 text-uppercase" style="font-size: 0.75rem;">Menu Utama</small>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
               href="{{ route('admin.dashboard') }}">
               <i class="fas fa-th-large me-3" style="width: 20px;"></i> Dashboard
            </a>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}" 
               href="{{ route('admin.doctors.index') }}">
               <i class="fas fa-user-md me-3" style="width: 20px;"></i> Data Dokter
            </a>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.medicines.*') ? 'active' : '' }}" 
               href="{{ route('admin.medicines.index') }}">
               <i class="fas fa-pills me-3" style="width: 20px;"></i> Manajemen Obat
            </a>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.polis.*') ? 'active' : '' }}" 
               href="{{ route('admin.poli.index') }}">
               <i class="fas fa-clinic-medical me-3" style="width: 20px;"></i> Data Poli
            </a>
            
            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
               href="{{ route('admin.users.index') }}">
               <i class="fas fa-users me-3" style="width: 20px;"></i> Kelola Pengguna
            </a>

            <a class="list-group-item list-group-item-action menu-logout" 
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fas fa-sign-out-alt me-3" style="width: 20px;"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="btn-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="ms-auto d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Administrator</div>
                    </div>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 40px; height: 40px; font-weight: bold;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>
    </div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Script Toggle Sidebar --}}
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const sidebarToggle = document.body.querySelector('#sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
            });
        }
    });
</script>

</body>
</html>