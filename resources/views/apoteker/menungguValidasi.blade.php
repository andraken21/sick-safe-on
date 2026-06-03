@extends('layouts.app')

@section('title', 'Menunggu Validasi - Sick Safe ON')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">
@endpush

@section('content')

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <main class="main-content">

            <div class="page-header">
                <h2 class="section-title">Resep Masuk</h2>
                <p class="section-subtitle">Kelola dan validasi resep yang masuk dari dokter</p>
            </div>

            {{-- TABS --}}
            <div class="tabs">
                <a href="{{ route('apoteker.menunggu-validasi') }}" class="tab active">
                    <span class="tab-label">Menunggu Validasi</span>
                    <span class="tab-badge badge-warning">3</span>
                </a>
                <a href="{{ route('apoteker.menunggu-pembayaran') }}" class="tab">
                    <span class="tab-label">Menunggu Pembayaran</span>
                    <span class="tab-badge badge-info">2</span>
                </a>
                <a href="{{ route('apoteker.diproses') }}" class="tab">
                    <span class="tab-label">Diproses</span>
                    <span class="tab-badge badge-success">4</span>
                </a>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="resepTable" class="resep-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Resep</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="selected">
                            <td>1</td>
                            <td><span class="resep-id">RSP-2024-0051</span></td>
                            <td>Andi Setiawan</td>
                            <td>Dr. Budi Santoso</td>
                            <td>20 Mei 2024</td>
                            <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="resep-id">RSP-2024-0052</span></td>
                            <td>Siti Rahayu</td>
                            <td>Dr. Citra Dewi</td>
                            <td>20 Mei 2024</td>
                            <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><span class="resep-id">RSP-2024-0053</span></td>
                            <td>Hendra Gunawan</td>
                            <td>Dr. Budi Santoso</td>
                            <td>21 Mei 2024</td>
                            <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- DETAIL --}}
            <div class="detail-section">
                <div class="detail-header">
                    <h3>Detail Resep</h3>
                    <span class="detail-id">RSP-2024-0051</span>
                </div>
                <div class="detail-grid">
                    <div class="detail-info">
                        <div class="detail-item">
                            <span class="detail-label">Pasien</span>
                            <span class="detail-value">Andi Setiawan</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Dokter</span>
                            <span class="detail-value">Dr. Budi Santoso</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tanggal</span>
                            <span class="detail-value">20 Mei 2024</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Catatan</span>
                            <span class="detail-value">Sesudah makan</span>
                        </div>
                    </div>
                    <div class="detail-obat">
                        <h4 class="obat-title">Daftar Obat</h4>
                        <table class="obat-table">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Dosis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Paracetamol 500mg</td>
                                    <td>3× sehari</td>
                                    <td>10 Tablet</td>
                                </tr>
                                <tr>
                                    <td>Amoxicillin 250mg</td>
                                    <td>2× sehari</td>
                                    <td>14 Kapsul</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="actions">
                    <button class="btn-custom btn-outline">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        Tolak
                    </button>
                    <button class="btn-custom btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                        Validasi
                    </button>
                    <button class="btn-custom btn-dark">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        Validasi & Proses
                    </button>
                </div>
            </div>

        </main>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/dashboardApoteker.js') }}"></script>
@endpush