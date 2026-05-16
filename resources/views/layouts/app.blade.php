<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sick Safe ON')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @stack('styles')

</head>

<body>

<div class="main-layout">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- CONTENT --}}
    <main class="content">
        @yield('content')
    </main>

</div>

@stack('scripts')

</body>
</html>