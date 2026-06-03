@extends('layouts.app')

@section('title', 'Pembayaran — Sick Safe ON')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}">
@endpush

@section('content')

<div class="bayar-page">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <h1>Pembayaran 💳</h1>
            <p>Kelola dan pantau semua transaksi pembayaran Anda</p>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon stat-icon--teal">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stat-text">
                <div class="num">Rp 507.500</div>
                <div class="lbl">Total Dibayar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--warning">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color:var(--ss-warning);">1</div>
                <div class="lbl">Menunggu Bayar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--success">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color:var(--ss-success);">8</div>
                <div class="lbl">Lunas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--info">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color:var(--ss-info);">BPJS</div>
                <div class="lbl">Metode Utama</div>
            </div>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="main-grid">

        {{-- TABEL RIWAYAT --}}
        <div class="table-card">
            <div class="card-head">
                <h2>Riwayat Pembayaran</h2>
                <span class="badge-count">9 Transaksi</span>
            </div>

            <div class="filter-bar">
                <div class="search-wrap">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" placeholder="Cari invoice...">
                </div>
                <select class="filter-select">
                    <option>Semua Status</option>
                    <option value="lunas">Lunas</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="proses">Diproses</option>
                    <option value="gagal">Gagal</option>
                </select>
                <select class="filter-select">
                    <option>Semua Metode</option>
                    <option>BPJS</option>
                    <option>Mandiri</option>`
                </select>
            </div>

            <table class="bayar-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Diisi oleh JavaScript -->
                </tbody>
            </table>

            <div class="pagination-wrap">
                <div class="pagination-info"></div>
                <div class="pagination-btns"></div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="side-col">

            {{-- TAGIHAN AKTIF --}}
            <div class="side-card">
                <div class="side-card-head">
                    <h3>Tagihan Aktif</h3>
                </div>
                <div class="side-card-body">
                    <div class="tagihan-list">
                        <div class="tagihan-row">
                            <span class="lbl">NO. INVOICE</span>
                            <span class="val" style="color:var(--ss-primary);">INV-2026-0077</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Resep</span>
                            <span class="val">RSP-2026–0051</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Dokter & Obat</span>
                            <span class="val">Dr. Budi Santoso • 3 Obat</span>
                        </div>
                        <div class="tagihan-divider"></div>
                        <div class="tagihan-row">
                            <span class="lbl">Subtotal obat</span>
                            <span class="val">Rp 75.000</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Biaya layanan</span>
                            <span class="val">Rp 12.500</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Diskon BPJS</span>
                            <span class="val">– Rp 0</span>
                        </div>
                        <div class="tagihan-divider"></div>
                        <div class="tagihan-total">
                            <span class="lbl">Total Bayar</span>
                            <span class="val">Rp 87.500</span>
                        </div>
                    </div>
                    <button class="btn-bayar">Bayar Sekarang</button>
                </div>
            </div>

            {{-- METODE PEMBAYARAN --}}
            <div class="side-card">
                <div class="side-card-head">
                    <h3>Metode Pembayaran</h3>
                </div>
                <div class="side-card-body">
                    <div class="metode-list">
                        <div class="metode-item active" data-metode="BPJS">
                            <div class="metode-item-left">
                                <div class="metode-badge metode-badge--bpjs">📋</div>
                                <div>
                                    <div class="metode-name">BPJS Kesehatan</div>
                                    <div class="metode-desc">Peserta aktif</div>
                                </div>
                            </div>
                            <div class="metode-check"></div>
                        </div>
                        <div class="metode-item" data-metode="Mandiri">
                            <div class="metode-item-left">
                                <div class="metode-badge metode-badge--mandiri">🏦</div>
                                <div>
                                    <div class="metode-name">Bank Mandiri</div>
                                    <div class="metode-desc">Transfer mudah</div>
                                </div>
                            </div>
                            <div class="metode-check"></div>
                        </div>
                        <div class="metode-item" data-metode="Tunai">
                            <div class="metode-item-left">
                                <div class="metode-badge metode-badge--tunai">💵</div>
                                <div>
                                    <div class="metode-name">Tunai / Kasir</div>
                                    <div class="metode-desc">Bayar langsung</div>
                                </div>
                            </div>
                            <div class="metode-check"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/pembayaran.js') }}"></script>
@endpush
    