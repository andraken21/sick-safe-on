@extends('layouts.app')

@section('title', 'Dashboard Pasien - Sick Safe ON')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')

<div class="pasien-dashboard">

    {{-- ===== TOP BAR ===== --}}
    <div class="dash-topbar">
        <div class="dash-greeting">
            <h1 class="greeting-title">Halo, {{ Auth::user()->name ?? 'Andra Kenzie' }} 👋</h1>
            <p class="greeting-sub">Berikut ringkasan akun Anda</p>
        </div>
        <div class="topbar-actions">
           
            </button>
            
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-file-prescription"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Resep Aktif</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-credit-card"></i></div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Tagihan Tertunda</span>
            </div>
        </div>
    </div>

    {{-- MENU SHORTCUT --}}
    <div class="shortcut-grid">
        <a href="{{ route('pasien.resep.index') }}" class="shortcut-card">
            <i class="fas fa-file-prescription"></i>
            <span>Lihat Resep Saya</span>
        </a>
        <a href="{{ route('pasien.pembayaran.index') }}" class="shortcut-card">
            <i class="fas fa-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </div>

</div>
@endsection