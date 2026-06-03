<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sick Safe ON')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-shared.css') }}">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- CSS tambahan dari halaman anak (misal dashboardDokter.css) --}}
    @stack('styles')

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            z-index: 300;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-250px);
        }

        .dashboard-header {
            position: fixed;
            top: 0;
            left: 250px;
            width: calc(100% - 250px);
            z-index: 1000;
            transition: left 0.3s ease, width 0.3s ease;
            overflow: hidden;
        }

        body.sidebar-collapsed .dashboard-header {
            left: 0;
            width: 100%;
        }

        .header-row {
            width: 100%;
        }

        .page-wrapper {
            margin-left: 250px;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
            width: calc(100% - 250px);
        }

        body.sidebar-collapsed .page-wrapper {
            margin-left: 0;
            width: 100%;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .site-footer {
            width: 100% !important;
            margin-left: 0 !important;
            box-sizing: border-box;
        }
        .site-footer {
            width: 100% !important;
            margin-left: 0 !important;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-250px); }
            .dashboard-header { left: 0; }
            .page-wrapper { margin-left: 0; margin-top: 60px; width: 100%; }
            body.sidebar-open .sidebar { transform: translateX(0); }
        }
    </style>
</head>

<body>

    @include('layouts.partials.sidebar')
    @include('layouts.partials.header')

    {{-- KONTEN + FOOTER --}}
    <div class="page-wrapper">
        <main class="content">
            @yield('content')
        </main>

        @include('layouts.partials.footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed', isCollapsed);
        }

        // Tutup dropdown profil saat klik di luar
        document.addEventListener('click', function (event) {
            const wrapper  = document.querySelector('.profile-wrapper');
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown && wrapper && !wrapper.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

    {{-- Script tambahan dari halaman anak --}}
    @stack('scripts')

</body>
</html>