@extends('layouts.app')

@section('title', 'Dashboard Admin - Sick Safe ON')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">

    <div class="page-header">
        <h1>Selamat datang, {{ Auth::user()->nama }} 👋</h1>
        <p>Panel Admin &mdash; Sick Safe ON</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-pills"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Total Obat</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-exchange-alt"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Transaksi Hari Ini</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Total Pengguna</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Laporan Bulan Ini</span>
            </div>
        </div>
    </div>

    {{-- MENU SHORTCUT --}}
    <div class="shortcut-grid">
        <a href="#" class="shortcut-card">
            <i class="fas fa-pills"></i>
            <span>Kelola Data Obat</span>
        </a>
        <a href="#" class="shortcut-card">
            <i class="fas fa-exchange-alt"></i>
            <span>Pantau Transaksi</span>
        </a>
        <a href="#" class="shortcut-card">
            <i class="fas fa-users-cog"></i>
            <span>Kelola Akun Pengguna</span>
        </a>
        <a href="#" class="shortcut-card">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan &amp; Analisis</span>
        </a>
    </div>

</div>
@endsection