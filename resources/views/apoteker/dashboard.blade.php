@extends('layouts.app')

@section('title', 'Dashboard Apoteker - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">
@endpush

@section('content')

    <div class="dashboard-wrapper">

        {{-- WELCOME CARD --}}
        <div class="dashboard-card welcome-card">
            <div class="welcome-content">
                <h2 class="section-title">
                    Halo, {{ Auth::user()->name }}
                </h2>

                <p class="welcome-description">
                    Selamat datang di Sistem Informasi Farmasi Rumah Sakit.
                </p>

                <p class="welcome-description">
                    Kelola seluruh alur pelayanan resep mulai dari validasi resep dokter,
                    verifikasi pembayaran pasien, hingga proses penyiapan obat dalam satu
                    dashboard terintegrasi.
                </p>

                <div class="welcome-footer">
                    <span>Apt. Cindy Christina Rajagukguk</span>
                    <span>{{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="stats-container">

            <div class="stat-card">
                <div class="stat-info">
                    <h3>Menunggu Validasi</h3>
                    <h2>{{ $menungguValidasi ?? 12 }}</h2>
                    <p>Resep</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>Menunggu Pembayaran</h3>
                    <h2>{{ $menungguPembayaran ?? 8 }}</h2>
                    <p>Resep</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>Sedang Diproses</h3>
                    <h2>{{ $diproses ?? 5 }}</h2>
                    <p>Resep</p>
                </div>
            </div>

            <div class="stat-card total-card">
                <div class="stat-info">
                    <h3>Total Resep Hari Ini</h3>
                    <h2>{{ $totalResepHariIni ?? 25 }}</h2>
                    <p>Resep</p>
                </div>
            </div>

        </div>


        {{-- AKSI CEPAT --}}
        <div class="dashboard-card welcome-card">
            <div class="welcome-content">
                <div class="dashboard-row">
                    <div class="section-title">
                        <h4>Aksi Cepat</h4>
                    </div>
                </div>
                <div class="action-grid">

                    <a href="{{ route('apoteker.validasi') }}" class="action-card">
                        <h4>Validasi Resep</h4>
                        <p>Periksa dan validasi resep yang baru diterima dari dokter.</p>
                    </a>

                    <a href="{{ route('apoteker.pembayaran') }}" class="action-card">
                        <h4>Verifikasi Pembayaran</h4>
                        <p>Pastikan pembayaran pasien telah berhasil dilakukan.</p>
                    </a>

                    <a href="{{ route('apoteker.diproses') }}" class="action-card">
                        <h4>Proses Obat</h4>
                        <p>Siapkan dan proses obat yang telah dikonfirmasi.</p>
                    </a>

                </div>
            </div>
        </div>

        {{-- INFORMASI --}}
        <div class="dashboard-card welcome-card">
            <div class="welcome-content">
                <div class="dashboard-row">
                    <div class="section-title">
                        <h4>Informasi Pelayanan Farmasi</h4>
                    </div>
                    <div class="action-grid">
                        <div class="info-item">
                            <h4>Jam Operasional</h4>
                            <p>08.00 - 21.00 WIB</p>
                        </div>

                        <div class="info-item">
                            <h4>Petugas Aktif</h4>
                            <p>{{ Auth::user()->name }}</p>
                        </div>

                        <div class="info-item">
                            <h4>Status Sistem</h4>
                            <p class="status-online">Online</p>
                        </div>

                        <div class="info-item">
                            <h4>Tanggal</h4>
                            <p>{{ now()->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <div id="toast-container" class="toast-container"></div>
@endsection

@push('scripts')

    <script src="{{ asset('js/dashboardApoteker.js') }}"></script>

@endpush