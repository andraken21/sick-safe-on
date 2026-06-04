@extends('layouts.app')

@section('title', 'Resep Saya — Sick Safe ON')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/resep.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
<div class="resep-page">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <h1>Resep Saya </h1>
            <p>Kelola semua resep digital Anda di sini</p>
        </div>
        
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon stat-icon--teal">
                <i class="fas fa-file-medical"></i>
            </div>
            <div class="stat-text">
                <div class="num">12</div>
                <div class="lbl">Total Resep</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--info">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color: var(--ss-info);">2</div>
                <div class="lbl">Sedang Diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color: var(--ss-warning);">1</div>
                <div class="lbl">Menunggu Bayar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color: var(--ss-success);">9</div>
                <div class="lbl">Selesai</div>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="filter-bar">
        <div class="search-wrap">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" placeholder="Cari nomor resep atau nama dokter...">
        </div>
        <select class="filter-select filter-status">
            <option value="">Semua Status</option>
            <option value="proses">Sedang Diproses</option>
            <option value="tunggu">Menunggu Pembayaran</option>
            <option value="selesai">Selesai</option>
            <option value="batal">Dibatalkan</option>
        </select>
        <select class="filter-select filter-bulan">
            <option value="">Semua Bulan</option>
            <option value="2026-05">Mei 2026</option>
            <option value="2026-04">April 2026</option>
            <option value="2026-03">Maret 2026</option>
        </select>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-head-row">
            <h2>Daftar Resep</h2>
            <span class="badge-count" id="resep-count">12 Resep</span>
        </div>

        <table class="resep-table">
            <thead>
                <tr>
                    <th>No. Resep</th>
                    <th>Dokter</th>
                    <th>Obat</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="resep-tbody">
                
            </tbody>
        </table>

        <div class="pagination-wrap">
            <div class="pagination-info" id="pagination-info"></div>
            <div class="pagination-btns" id="pagination-btns"></div>
        </div>
    </div>

</div>

@endsection
    
@push('scripts')
<script src="{{ asset('js/resep.js') }}"></script>
@endpush