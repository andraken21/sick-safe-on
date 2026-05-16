@extends('layouts.app')

@section('title', 'Dashboard Dokter - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">  

    {{-- MAIN AREA --}}
    <div class="dash-main">

        {{-- CONTENT --}}
        <div class="dash-content">
            ISI DASHBOARD NYA LETAK SINI
        </div>
        {{-- /CONTENT --}}

    </div>
    {{-- /MAIN AREA --}}
<script src="{{ asset('js/dashboardDokter.js') }}"></script>
</div>
@endsection