@extends('layouts.app')

@section('title', 'Dashboard Dokter - Sick Safe ON')

{{-- CSS dimuat di <head> via @stack('styles'), bukan di dalam @section('content') --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">

    <div class="page-header">
        <h1>Selamat datang, Dr. {{ Auth::user()->nama }} 👋</h1>
        <p>Dashboard Dokter &mdash; Sick Safe ON</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-list-ol"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Antrian Pasien</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-file-prescription"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Resep Hari Ini</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Pasien Dilayani</span>
            </div>
        </div>
    </div>

    {{-- MENU SHORTCUT --}}
    <div class="shortcut-grid">
        <a href="#" class="shortcut-card">
            <i class="fas fa-list-ol"></i>
            <span>Antrian Pasien</span>
        </a>
        <a href="#" class="shortcut-card">
            <i class="fas fa-user-check"></i>
            <span>Memilih Pasien</span>
        </a>
        <a href="#" class="shortcut-card">
            <i class="fas fa-file-prescription"></i>
            <span>Membuat Resep</span>
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboardDokter.js') }}"></script>
@endpush