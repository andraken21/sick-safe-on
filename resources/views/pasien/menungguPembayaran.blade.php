@extends('layouts.app')

@section('title', 'Menunggu Pembayaran - Sick Safe ON')

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

            {{-- Flash messages --}}
            @if(session('success'))
            <div style="padding:12px 16px; background:#dcfce7; border:1px solid #86efac; border-radius:8px; color:#15803d; font-size:.85rem; font-weight:600; margin-bottom:16px;">
                ✅ {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div style="padding:12px 16px; background:#fee2e2; border:1px solid #fca5a5; border-radius:8px; color:#b91c1c; font-size:.85rem; font-weight:600; margin-bottom:16px;">
                ❌ {{ session('error') }}
            </div>
            @endif

            {{-- TABS --}}
            <div class="tabs">
                <a href="{{ route('apoteker.menunggu-validasi') }}" class="tab">
                    <span class="tab-label">Menunggu Validasi</span>
                    <span class="tab-badge badge-warning">3</span>
                </a>
                <a href="{{ route('apoteker.menunggu-pembayaran') }}" class="tab active">
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
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="selected">
                            <td>1</td>
                            <td><span class="resep-id">RSP-2024-0048</span></td>
                            <td>Rini Wulandari</td>
                            <td>Dr. Ahmad Fauzi</td>
                            <td>19 Mei 2024</td>
                            <td>Rp 85.000</td>
                            <td><span class="status-badge status-info">Menunggu Pembayaran</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="resep-id">RSP-2024-0049</span></td>
                            <td>Doni Prakasa</td>
                            <td>Dr. Citra Dewi</td>
                            <td>19 Mei 2024</td>
                            <td>Rp 120.000</td>
                            <td><span class="status-badge status-info">Menunggu Pembayaran</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- DETAIL --}}
            <div class="detail-section">
                <div class="detail-header">
                    <h3>Detail Resep</h3>
                    <span class="detail-id">RSP-2024-0048</span>
                </div>
                <div class="detail-grid">
                    <div class="detail-info">
                        <div class="detail-item">
                            <span class="detail-label">Pasien</span>
                            <span class="detail-value">Rini Wulandari</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Dokter</span>
                            <span class="detail-value">Dr. Ahmad Fauzi</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tanggal</span>
                            <span class="detail-value">19 Mei 2024</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total Harga</span>
                            <span class="detail-value highlight">Rp 85.000</span>
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
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ibuprofen 400mg</td>
                                    <td>3× sehari</td>
                                    <td>10 Tablet</td>
                                    <td>Rp 45.000</td>
                                </tr>
                                <tr>
                                    <td>Antasida</td>
                                    <td>3× sehari</td>
                                    <td>15 Tablet</td>
                                    <td>Rp 40.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="actions">
                    <form method="POST" action="{{ route('apoteker.batalkan-pembayaran') }}" style="margin:0;">
                        @csrf
                        <input type="hidden" name="resep_id" value="RSP-2024-0048">
                        <button type="submit" class="btn-custom btn-outline" onclick="return confirm('Batalkan pembayaran ini?')">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            Batalkan
                        </button>
                    </form>
                    <form method="POST" action="{{ route('apoteker.konfirmasi-pembayaran') }}" style="margin:0;">
                        @csrf
                        <input type="hidden" name="resep_id" value="RSP-2024-0048">
                        <button type="submit" class="btn-custom btn-dark">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/dashboardApoteker.js') }}"></script>
@endpush