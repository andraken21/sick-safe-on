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

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    {{-- HEADER --}}
    @include('layouts.partials.header')

    <div class="main-layout">

        {{-- MENU SAMPING --}}
        @include('layouts.partials.sidebar')

        {{-- ISI HALAMAN --}}
        <main class="content">
            @yield('content')
        </main>

    </div>

    {{-- FOOTER --}}
    @include('layouts.partials.footer')

   <script src="{{ asset('js/app.js') }}"></script>
   <script src="{{ asset('js/header.js') }}"></script>
   <script src="{{ asset('js/sidebar.js') }}"></script>
   <script src="{{ asset('js/footer.js') }}"></script>
</body>
</html>
