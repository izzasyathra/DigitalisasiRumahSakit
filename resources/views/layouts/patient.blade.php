<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien | Digital Hospital</title>

    {{-- Bootstrap 5 & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- jQuery (Wajib untuk Dropdown Dokter Dinamis) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            overflow-x: hidden;
        }

        /* --- SIDEBAR PASIEN (Biru Segar) --- */
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -17rem;
            transition: margin .25s ease-out;
            /* Gradient Biru Royal ke Navy */
            background: linear-gradient(180deg, #2563eb 0%, #1e3a8a 100%);
            color: white;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem;
            font-size: 1.3rem;
            font-weight: 700;
            text-align: center;
            background: rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
        }

        #sidebar-wrapper .list-group { width: 17rem; padding: 1rem; }

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
            color: #2563eb !important;
            font-weight: 700;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #page-content-wrapper { min-width: 100vw; transition: all 0.3s ease; }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
            padding: 1rem 1.5rem;
        }

        /* Responsive */
        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
            body.sb-sidenav-toggled #sidebar-wrapper { margin-left: -17rem; }
        }
        
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <i class="fas fa-heartbeat me-2"></i> RS Digital
        </div>
        <div class="list-group list-group-flush">
            <small class="text-white-50 px-3 mb-2 text-uppercase" style="font-size: 0.75rem;">Menu Pasien</small>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}" 
               href="{{ route('patient.dashboard') }}">
               <i class="fas fa-home me-3" style="width: 20px;"></i> Beranda
            </a>

            <a class="list-group-item list-group-item-action {{ request()->routeIs('patient.appointments.create') ? 'active' : '' }}" 
               href="{{ route('patient.appointments.create') }}">
               <i class="fas fa-plus-circle me-3" style="width: 20px;"></i> Buat Janji Baru
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
                <button class="btn text-primary fs-5 border-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-2 text-muted small d-none d-md-block">Halo, Pasien</span>
                    <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center ms-3" 
                         style="width: 35px; height: 35px; font-weight: bold;">
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