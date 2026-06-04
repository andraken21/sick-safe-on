@extends('layouts.app')

@section('title', 'Dashboard Dokter - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/antrian.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <h1>Selamat datang, Dr. {{ Auth::user()->nama }} 👋</h1>
        <p>Dashboard Dokter &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/antrian.js') }}"></script>
@endpush