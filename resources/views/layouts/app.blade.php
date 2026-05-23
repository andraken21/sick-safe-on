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

        body { overflow-x: hidden; overflow-y: auto; }

        .dashboard-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
        }

        .page-wrapper {
            margin-left: 0;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            width: 100%;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* Saat sidebar terbuka, hanya konten yang terdorong */
        body.sidebar-open .page-wrapper {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .content { flex: 1; padding: 20px; }

        .site-footer {
            width: 100% !important;
            margin-left: 0 !important;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            body.sidebar-open .page-wrapper { margin-left: 0; width: 100%; }
        }
    </style>
</head>

<body>

    @include('layouts.partials.sidebar')
    @include('layouts.partials.header')

    <div class="page-wrapper">
        <main class="content">
            @yield('content')
        </main>
        @include('layouts.partials.footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/footer.js') }}"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const body    = document.body;
            if (!sidebar) return;
            const isOpen = body.classList.toggle('sidebar-open');
            sidebar.classList.toggle('open', isOpen);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.body.classList.remove('sidebar-open');
                document.getElementById('sidebar').classList.remove('open');
            }
        });
    </script>

</body>
</html>
