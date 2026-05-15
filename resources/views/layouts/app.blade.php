<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sick Safe ON')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            z-index: 9999;
            transform: translateX(-250px);
            transition: transform 0.3s ease;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .page-wrapper {
            margin-left: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .page-wrapper.sidebar-open {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .dashboard-header {
            position: sticky !important; 
            top: 0 !important;
            left: auto !important;       
            right: auto !important;      
            width: 100% !important;      
            z-index: 1000;
        }

        .content {
            flex: 1;
            padding: 24px;
            box-sizing: border-box;
            width: 100%;
        }

        .site-footer {
            width: 100% !important;
            margin-left: 0 !important;
            box-sizing: border-box;
        }

        .sidebar-overlay {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 9998;
        }


        @media (max-width: 768px) {
            .page-wrapper.sidebar-open {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- OVERLAY --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- PAGE WRAPPER: header + konten + footer semua di dalam sini --}}
    <div class="page-wrapper" id="pageWrapper">

        {{-- HEADER di dalam page-wrapper --}}
        @include('layouts.partials.header')

        {{-- KONTEN --}}
        <main class="content">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('layouts.partials.footer')

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/footer.js') }}"></script>

    <script>
    function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const pageWrapper = document.getElementById('pageWrapper');

    const isOpen = sidebar.classList.toggle('open');
    pageWrapper.classList.toggle('sidebar-open', isOpen);
}
    </script>

</body>
</html>