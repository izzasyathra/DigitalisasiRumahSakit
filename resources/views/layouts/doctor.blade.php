<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Dokter | Digital Hospital</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- GLOBAL STYLE --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6; 
            overflow-x: hidden;
        }

        /* --- SIDEBAR DOKTER (Nuansa Biru-Teal agar sedikit beda tapi tetap senada) --- */
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -17rem;
            transition: margin .25s ease-out;
            /* Gradient Biru Sedikit Lebih Terang untuk Dokter */
            background: linear-gradient(180deg, #0ea5e9 0%, #0284c7 100%); 
            color: white;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1.5rem;
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            text-align: center;
            background: rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
        }

        #sidebar-wrapper .list-group { width: 17rem; padding: 1rem; }

        /* --- MENU ITEM --- */
        .list-group-item {
            border: none;
            padding: 12px 20px;
            margin-bottom: 5px;
            border-radius: 10px !important;
            background-color: transparent;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            transform: translateX(5px);
        }

        .list-group-item.active {
            background-color: white !important;
            color: #0284c7 !important; /* Teks Biru Laut */
            font-weight: 700;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* --- CONTENT & NAVBAR --- */
        #page-content-wrapper { min-width: 100vw; transition: all 0.3s ease; }
        
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
            padding: 1rem 1.5rem;
        }

        .btn-toggle { color: #0284c7; font-size: 1.2rem; border: none; background: transparent; }

        /* Responsive */
        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
            body.sb-sidenav-toggled #sidebar-wrapper { margin-left: -17rem; }
        }

        /* Card Custom */
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <i class="fas fa-user-md me-2"></i> Panel Dokter
        </div>
        <div class="list-group list-group-flush">
            
            <small class="text-white-50 px-3 mb-2 text-uppercase" style="font-size: 0.75rem;">Menu Utama</small>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}" 
               href="{{ route('doctor.dashboard') }}">
               <i class="fas fa-chart-pie me-3" style="width: 20px;"></i> Dashboard
            </a>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('doctor.schedules.*') ? 'active' : '' }}" 
               href="{{ route('doctor.schedules.index') }}">
               <i class="fas fa-calendar-alt me-3" style="width: 20px;"></i> Jadwal Praktik
            </a>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('doctor.appointments.*') ? 'active' : '' }}" 
               href="{{ route('doctor.appointments.index') }}">
               <i class="fas fa-calendar-check me-3" style="width: 20px;"></i> Validasi Janji
            </a>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('doctor.consultation.*') ? 'active' : '' }}" 
               href="{{ route('doctor.consultation.index') }}">
               <i class="fas fa-stethoscope me-3" style="width: 20px;"></i> Periksa Pasien
            </a>

            <a class="list-group-item list-group-item-action mt-4 text-danger-subtle" 
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               style="color: #ffcccc;">
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
                        <div class="text-muted" style="font-size: 0.75rem;">Dokter Spesialis</div>
                    </div>
                    {{-- Avatar Inisial --}}
                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" 
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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