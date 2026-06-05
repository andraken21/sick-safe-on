@extends('layouts.app')

@section('title', 'Dashboard Dokter - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <h1>Selamat datang, Dr. {{ Auth::user()->nama }} 👋</h1>
        <p>Dashboard Dokter &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon tosca">
                <i class="fas fa-list-ol"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Antrian Pasien</span>
                <span class="stat-sub">Hari ini</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-file-prescription"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Resep Dibuat</span>
                <span class="stat-sub">Hari ini</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">—</span>
                <span class="stat-label">Pasien Dilayani</span>
                <span class="stat-sub">Bulan ini</span>
            </div>
        </div>
    </div>

    {{-- MID GRID: AKSI CEPAT + ANTRIAN --}}
    <div class="mid-grid">

        {{-- AKSI CEPAT --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <div class="dash-card-title">Aksi Cepat</div>
                    <div class="dash-card-sub">Mulai tugas dokter hari ini</div>
                </div>
            </div>
            <div class="shortcut-grid">
                <a href="{{ route('dokter.pilih-pasien') }}" class="shortcut-card">
                    <div class="shortcut-icon tosca">
                        <i class="fas fa-users"></i>
                    </div>
                    <span>Pilih Pasien</span>
                </a>
                <a href="{{ route('dokter.pilih-pasien') }}" class="shortcut-card">
                    <div class="shortcut-icon blue">
                        <i class="fas fa-file-prescription"></i>
                    </div>
                    <span>Buat Resep</span>
                </a>
                <a href="#" class="shortcut-card">
                    <div class="shortcut-icon navy">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <span>Daftar Resep</span>
                </a>
                <a href="{{ route('dokter.antrian') }}" class="shortcut-card">
                    <div class="shortcut-icon pink">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span>Riwayat Kunjungan</span>
                </a>
            </div>
        </div>

        {{-- ANTRIAN PASIEN HARI INI --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <div class="dash-card-title">Antrian Pasien</div>
                    <div class="dash-card-sub">Hari ini</div>
                </div>
                <a href="{{ route('dokter.pilih-pasien') }}" class="btn-link">Lihat Semua →</a>
            </div>
            <div class="antrian-list">
                {{-- Placeholder — nanti diganti data dari DB --}}
                <div class="antrian-empty">
                    <i class="fas fa-user-clock"></i>
                    <p>Belum ada antrian hari ini</p>
                </div>
            </div>
        </div>

    </div>

    {{-- RESEP TERBARU --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <div>
                <div class="dash-card-title">Resep Terbaru</div>
                <div class="dash-card-sub">Resep yang baru saja dibuat</div>
            </div>
            <button class="btn-link">Lihat Semua →</button>
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID Resep</th>
                        <th>Nama Pasien</th>
                        <th>Diagnosa</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Placeholder statis — nanti diganti dari DB --}}
                    <tr>
                        <td><span class="trx-id">RSP-2024-0053</span></td>
                        <td><span class="trx-name">Rudi Hartono</span></td>
                        <td>Infeksi Saluran Napas</td>
                        <td class="trx-date">20 Mei 2024</td>
                        <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                        <td><a href="#" class="btn-aksi">Detail</a></td>
                    </tr>
                    <tr>
                        <td><span class="trx-id">RSP-2024-0052</span></td>
                        <td><span class="trx-name">Dinda Permata</span></td>
                        <td>Demam Tifoid</td>
                        <td class="trx-date">20 Mei 2024</td>
                        <td><span class="status-badge status-success">Diproses</span></td>
                        <td><a href="#" class="btn-aksi">Detail</a></td>
                    </tr>
                    <tr>
                        <td><span class="trx-id">RSP-2024-0051</span></td>
                        <td><span class="trx-name">Andi Setiawan</span></td>
                        <td>Hipertensi</td>
                        <td class="trx-date">19 Mei 2024</td>
                        <td><span class="status-badge status-selesai">Selesai</span></td>
                        <td><a href="#" class="btn-aksi">Detail</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboardDokter.js') }}"></script>
@endpush