@extends('layouts.app')

@section('title', 'Pembayaran — Sick Safe ON')

<<<<<<< HEAD
@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --ss-primary:       #2bbf8e;
    --ss-primary-light: #e6f9f4;
    --ss-primary-mid:   #d0f5ea;
    --ss-primary-dark:  #1a9e74;
    --ss-warning:       #e05e2e;
    --ss-info:          #1d6fd8;
    --ss-success:       #1fa85c;
    --ss-danger:        #dc2626;
    --ss-card:          #ffffff;
    --ss-border:        #e4e9f0;
    --ss-text:          #1a202c;
    --ss-muted:         #7a8499;
    --ss-font:          'Plus Jakarta Sans', sans-serif;
    --ss-radius:        14px;
    --ss-radius-sm:     8px;
    --ss-shadow:        0 2px 12px rgba(0,0,0,.07);
}

.bayar-page {
    font-family: var(--ss-font);
    color: var(--ss-text);
    animation: fadeUp .4s ease both;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: none; }
}

/* ── PAGE HEADER ── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}

.page-title-wrap h1 { font-size: 1.4rem; font-weight: 800; margin: 0; }
.page-title-wrap p  { font-size: .83rem; color: var(--ss-muted); margin: 3px 0 0; }

/* ── STAT ROW ── */
.stat-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}

.stat-card {
    background: var(--ss-card);
    border-radius: var(--ss-radius);
    padding: 18px 20px;
    border: 1px solid var(--ss-border);
    box-shadow: var(--ss-shadow);
    display: flex;
    align-items: center;
    gap: 14px;
    animation: fadeUp .5s ease both;
}
.stat-card:nth-child(1) { animation-delay:.05s; }
.stat-card:nth-child(2) { animation-delay:.10s; }
.stat-card:nth-child(3) { animation-delay:.15s; }
.stat-card:nth-child(4) { animation-delay:.20s; }

.stat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.1rem;
}
.stat-icon--teal    { background: var(--ss-primary-light); color: var(--ss-primary); }
.stat-icon--warning { background: #fff4ee; color: var(--ss-warning); }
.stat-icon--info    { background: #dbeafe; color: var(--ss-info); }
.stat-icon--success { background: #dcfce7; color: var(--ss-success); }

.stat-text .num { font-size: 1.4rem; font-weight: 800; line-height: 1; }
.stat-text .lbl { font-size: .75rem; color: var(--ss-muted); font-weight: 500; margin-top: 3px; }

/* ── MAIN GRID ── */
.main-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 18px;
    align-items: start;
}

/* ── TABLE CARD ── */
.table-card {
    background: var(--ss-card);
    border-radius: var(--ss-radius);
    border: 1px solid var(--ss-border);
    box-shadow: var(--ss-shadow);
    overflow: hidden;
    animation: fadeUp .5s ease .2s both;
}

.card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--ss-border);
}

.card-head h2 { font-size: .95rem; font-weight: 700; margin: 0; }

.badge-count {
    background: var(--ss-primary-light);
    color: var(--ss-primary);
    font-size: .72rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
}

/* Filter bar */
.filter-bar {
    display: flex;
    gap: 10px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--ss-border);
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    flex: 1;
    min-width: 180px;
}

.search-wrap input {
    width: 100%;
    padding: 8px 12px 8px 34px;
    border: 1.5px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    font-size: .83rem;
    font-family: var(--ss-font);
    outline: none;
    transition: border-color .2s;
}
.search-wrap input:focus { border-color: var(--ss-primary); }
.search-wrap svg {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); color: var(--ss-muted);
}

.filter-select {
    padding: 8px 12px;
    border: 1.5px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    font-size: .83rem;
    font-family: var(--ss-font);
    background: #fff; outline: none; cursor: pointer;
    transition: border-color .2s;
}
.filter-select:focus { border-color: var(--ss-primary); }

/* Table */
.bayar-table { width: 100%; border-collapse: collapse; }

.bayar-table thead tr { background: #f8fafc; }
.bayar-table thead th {
    padding: 10px 16px;
    font-size: .71rem; font-weight: 700;
    color: var(--ss-muted);
    text-transform: uppercase; letter-spacing: .5px;
    text-align: left;
    border-bottom: 1px solid var(--ss-border);
}

.bayar-table tbody tr {
    border-bottom: 1px solid var(--ss-border);
    transition: background .15s;
}
.bayar-table tbody tr:last-child { border-bottom: none; }
.bayar-table tbody tr:hover { background: var(--ss-primary-light); }
.bayar-table tbody td { padding: 13px 16px; font-size: .83rem; vertical-align: middle; }

.inv-cell { display: flex; align-items: center; gap: 10px; }

.inv-icon {
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 13px;
}
.inv-icon--done { background: #dcfce7; color: var(--ss-success); }
.inv-icon--pend { background: #fef9c3; color: #a16207; }
.inv-icon--fail { background: #fee2e2; color: var(--ss-danger); }
.inv-icon--proc { background: #dbeafe; color: var(--ss-info); }

.inv-no   { font-weight: 700; font-size: .83rem; }
.inv-date { font-size: .72rem; color: var(--ss-muted); margin-top: 2px; }

.metode-cell { display: flex; align-items: center; gap: 7px; font-size: .82rem; font-weight: 600; }
.metode-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.metode-dot--bpjs    { background: var(--ss-success); }
.metode-dot--mandiri { background: var(--ss-info); }
.metode-dot--bni     { background: #7c3aed; }
.metode-dot--tunai   { background: var(--ss-warning); }

.total-cell { font-weight: 700; }

.badge {
    display: inline-flex; align-items: center;
    padding: 4px 11px; border-radius: 999px;
    font-size: .72rem; font-weight: 600; white-space: nowrap;
}
.badge--lunas  { background: #dcfce7; color: #15803d; }
.badge--tunggu { background: #fef9c3; color: #a16207; }
.badge--gagal  { background: #fee2e2; color: #b91c1c; }
.badge--proses { background: #dbeafe; color: #1d4ed8; }
.badge--menunggu { background: #fef9c3; color: #a16207; }

/* Pagination */
.pagination-wrap {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid var(--ss-border);
    flex-wrap: wrap; gap: 10px;
}
.pagination-info { font-size: .78rem; color: var(--ss-muted); }
.pagination-btns { display: flex; gap: 6px; }
.pg-btn {
    width: 32px; height: 32px;
    border-radius: 7px;
    border: 1.5px solid var(--ss-border);
    background: #fff;
    font-size: .8rem; font-weight: 600;
    font-family: var(--ss-font);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s; color: var(--ss-text);
}
.pg-btn:hover, .pg-btn.active {
    background: var(--ss-primary);
    border-color: var(--ss-primary);
    color: #fff;
}
.pg-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ── SIDE CARDS ── */
.side-col { display: flex; flex-direction: column; gap: 16px; }

.side-card {
    background: var(--ss-card);
    border-radius: var(--ss-radius);
    border: 1px solid var(--ss-border);
    box-shadow: var(--ss-shadow);
    overflow: hidden;
    animation: fadeUp .5s ease .3s both;
}

.side-card-head {
    padding: 16px 18px 12px;
    border-bottom: 1px solid var(--ss-border);
}
.side-card-head h3 { font-size: .88rem; font-weight: 700; margin: 0; }

.side-card-body { padding: 16px 18px; }

/* Metode pembayaran */
.metode-list { display: flex; flex-direction: column; gap: 10px; }

.metode-item {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 11px 14px;
    border: 1.5px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    cursor: pointer;
    transition: all .2s;
}
.metode-item:hover, .metode-item.active {
    border-color: var(--ss-primary);
    background: var(--ss-primary-light);
}

.metode-item-left { display: flex; align-items: center; gap: 10px; }

.metode-badge {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 800;
    flex-shrink: 0;
}
.metode-badge--bpjs    { background: #dcfce7; color: var(--ss-success); }
.metode-badge--mandiri { background: #dbeafe; color: var(--ss-info); }
.metode-badge--bni     { background: #ede9fe; color: #7c3aed; }
.metode-badge--tunai   { background: #fff4ee; color: var(--ss-warning); }

.metode-name  { font-size: .83rem; font-weight: 600; }
.metode-desc  { font-size: .72rem; color: var(--ss-muted); margin-top: 1px; }

.metode-check {
    width: 18px; height: 18px;
    border-radius: 50%;
    border: 2px solid var(--ss-border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: all .2s;
}
.metode-item.active .metode-check {
    background: var(--ss-primary);
    border-color: var(--ss-primary);
}

/* Ringkasan tagihan */
.tagihan-list { display: flex; flex-direction: column; gap: 10px; }

.tagihan-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: .83rem;
}
.tagihan-row .lbl { color: var(--ss-muted); }
.tagihan-row .val { font-weight: 600; }

.tagihan-divider { height: 1px; background: var(--ss-border); margin: 4px 0; }

.tagihan-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 4px;
}
.tagihan-total .lbl { font-size: .88rem; font-weight: 700; }
.tagihan-total .val { font-size: 1.1rem; font-weight: 800; color: var(--ss-primary); }

.btn-bayar {
    display: block;
    width: 100%;
    margin-top: 16px;
    padding: 12px;
    background: var(--ss-primary);
    color: #fff;
    border: none;
    border-radius: var(--ss-radius-sm);
    font-size: .88rem;
    font-weight: 700;
    font-family: var(--ss-font);
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    transition: background .2s, transform .15s;
}
.btn-bayar:hover { background: var(--ss-primary-dark); transform: translateY(-1px); }

/* ── MODAL PAYMENT ── */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    animation: fadeIn .2s ease;
}
.modal-overlay.open { display: flex; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
.modal-box {
    background: #fff;
    border-radius: 18px;
    width: 100%;
    max-width: 420px;
    margin: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    overflow: hidden;
    animation: slideUp .25s ease;
}
@keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: none; opacity: 1; } }
.modal-header {
    background: linear-gradient(135deg, var(--ss-primary), var(--ss-primary-dark));
    padding: 20px 24px;
    display: flex; align-items: center; justify-content: space-between;
    color: #fff;
}
.modal-header-left h2 { font-size: 1rem; font-weight: 800; margin: 0; }
.modal-header-left p  { font-size: .75rem; opacity: .8; margin: 2px 0 0; }
.modal-close {
    background: rgba(255,255,255,.2); border: none; color: #fff;
    width: 30px; height: 30px; border-radius: 50%; cursor: pointer;
    font-size: 1rem; display: flex; align-items: center; justify-content: center;
    transition: background .2s;
}
.modal-close:hover { background: rgba(255,255,255,.35); }
.modal-body { padding: 20px 24px; }
.modal-invoice {
    background: #f8fafc; border-radius: 10px;
    padding: 14px 16px; margin-bottom: 18px; font-size: .8rem;
}
.modal-invoice-row {
    display: flex; justify-content: space-between;
    margin-bottom: 6px; color: var(--ss-muted);
}
.modal-invoice-row:last-child { margin-bottom: 0; }
.modal-invoice-row span:last-child { font-weight: 600; color: var(--ss-text); }
.modal-invoice-total {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 10px; border-top: 1px solid var(--ss-border); margin-top: 8px;
}
.modal-invoice-total .lbl { font-weight: 700; font-size: .88rem; }
.modal-invoice-total .val { font-size: 1.15rem; font-weight: 800; color: var(--ss-primary); }
.panel-bpjs { display: none; }
.panel-bpjs.show { display: block; }
.bpjs-number-wrap {
    background: linear-gradient(135deg, #e6f9f4, #d0f5ea);
    border: 2px solid var(--ss-primary-mid);
    border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 16px;
}
.bpjs-label {
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .8px;
    color: var(--ss-primary-dark); margin-bottom: 8px;
}
.bpjs-number {
    font-family: 'Courier New', monospace;
    font-size: 1.5rem; font-weight: 800; letter-spacing: .15em; color: var(--ss-text);
}
.bpjs-name { font-size: .8rem; color: var(--ss-muted); margin-top: 6px; }
.bpjs-status {
    display: inline-flex; align-items: center; gap: 5px;
    background: #dcfce7; color: #15803d;
    font-size: .72rem; font-weight: 700;
    padding: 4px 12px; border-radius: 999px; margin-top: 10px;
}
.bpjs-info {
    background: #fffbeb; border: 1px solid #fcd34d;
    border-radius: 10px; padding: 12px 14px;
    font-size: .78rem; color: #92400e; line-height: 1.5;
}
.panel-mandiri { display: none; }
.panel-mandiri.show { display: block; }
.barcode-dashed {
    border: 2px dashed #cbd5e1; border-radius: 12px;
    padding: 18px; text-align: center;
    background: linear-gradient(to bottom, #f8fafc, #fff); margin-bottom: 14px;
}
.barcode-lbl {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .8px;
    color: var(--ss-muted); margin-bottom: 12px;
}
.barcode-img-wrap {
    width: 200px; height: 200px; margin: 0 auto 12px;
    border-radius: 8px; overflow: hidden; border: 1px solid var(--ss-border);
    display: flex; align-items: center; justify-content: center; background: #f0f9ff;
}
.barcode-img-wrap img { width: 100%; height: 100%; object-fit: contain; }
.barcode-placeholder { color: var(--ss-muted); font-size: .75rem; text-align: center; padding: 12px; }
.barcode-ref {
    font-family: 'Courier New', monospace;
    font-size: .82rem; font-weight: 700; letter-spacing: .12em;
    color: var(--ss-text); margin-bottom: 4px;
}
.barcode-hint { font-size: .72rem; color: var(--ss-muted); }
.modal-processing { display: none; text-align: center; padding: 24px 0; }
.modal-processing.show { display: block; }
.modal-spinner {
    width: 44px; height: 44px;
    border: 4px solid var(--ss-border); border-top-color: var(--ss-primary);
    border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 14px;
}
@keyframes spin { to { transform: rotate(360deg); } }
.modal-success { display: none; text-align: center; padding: 24px 0; }
.modal-success.show { display: block; }
.modal-success .icon { font-size: 3rem; margin-bottom: 10px; }
.modal-success .title { font-weight: 800; font-size: 1rem; margin-bottom: 4px; }
.modal-success .sub { font-size: .8rem; color: var(--ss-muted); }
.btn-konfirmasi {
    display: block; width: 100%; padding: 13px;
    background: var(--ss-primary); color: #fff; border: none;
    border-radius: 10px; font-size: .9rem; font-weight: 700;
    font-family: var(--ss-font); cursor: pointer; margin-top: 4px;
    transition: background .2s, transform .15s;
}
.btn-konfirmasi:hover { background: var(--ss-primary-dark); transform: translateY(-1px); }

/* Responsive */
@media (max-width: 1000px) {
    .main-grid { grid-template-columns: 1fr; }
    .stat-row  { grid-template-columns: repeat(2, 1fr); }
}
</style>

=======
@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
>>>>>>> main
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
<<<<<<< HEAD
                <span class="badge-count">9 Transaksi</span>
=======
                <span class="badge-count">{{ count($pembayaranList) }} Transaksi</span>
>>>>>>> main
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
<<<<<<< HEAD
                    <option>Semua Status</option>
=======
                    <option value="Semua Status">Semua Status</option>
>>>>>>> main
                    <option value="lunas">Lunas</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="proses">Diproses</option>
                    <option value="gagal">Gagal</option>
                </select>
                <select class="filter-select">
<<<<<<< HEAD
                    <option>Semua Metode</option>
                    <option>BPJS</option>
                    <option>Mandiri</option>
=======
                    <option value="Semua Metode">Semua Metode</option>
                    <option value="BPJS">BPJS</option>
                    <option value="Mandiri">Mandiri</option>
>>>>>>> main
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
<<<<<<< HEAD
                    <!-- Diisi oleh JavaScript -->
=======
                    {{-- Baris awal diisi oleh pembayaran.js (renderTable()) --}}
>>>>>>> main
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
<<<<<<< HEAD
                    {{-- Data tagihan aktif disimpan sebagai data attributes --}}
                    <div class="tagihan-list"
                         id="tagihanData"
                         data-subtotal="75000"
                         data-layanan="12500"
                         data-total-normal="87500"
                         data-invoice="INV-2026-0077"
                         data-status="menunggu">
                        <div class="tagihan-row">
                            <span class="lbl">NO. INVOICE</span>
                            <span class="val" style="color:var(--ss-primary);">INV-2026-0077</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Resep</span>
                            <span class="val">RSP-2026–0051</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Dokter &amp; Obat</span>
                            <span class="val">Dr. Budi Santoso • 3 Obat</span>
=======
                    @if($detailPembayaran)
                    {{--
                        Semua nilai PHP disimpan di data-* agar JS bisa
                        membacanya tanpa Blade syntax di dalam file .js
                    --}}
                    <div class="tagihan-list"
                         id="tagihanData"
                         data-subtotal="{{ $detailPembayaran['subtotal_obat'] }}"
                         data-layanan="{{ $detailPembayaran['biaya_layanan'] }}"
                         data-total-normal="{{ $detailPembayaran['total'] }}"
                         data-invoice="{{ $detailPembayaran['nomor_invoice'] }}"
                         data-status="{{ strtolower($detailPembayaran['status']) }}"
                         data-bayar-url="{{ route('pasien.pembayaran.bayar', $detailPembayaran['nomor_invoice']) }}"
                         data-proses-url="{{ route('pasien.pembayaran.proses') }}">

                        <div class="tagihan-row">
                            <span class="lbl">NO. INVOICE</span>
                            <span class="val" style="color:var(--ss-primary);">{{ $detailPembayaran['nomor_invoice'] }}</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Resep</span>
                            <span class="val">{{ $detailPembayaran['resep_id'] }}</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Dokter &amp; Obat</span>
                            <span class="val">{{ $detailPembayaran['dokter'] }}</span>
>>>>>>> main
                        </div>
                        <div class="tagihan-divider"></div>
                        <div class="tagihan-row">
                            <span class="lbl">Subtotal obat</span>
<<<<<<< HEAD
                            <span class="val" id="tagihanSubtotal">Rp 75.000</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Biaya layanan</span>
                            <span class="val" id="tagihanLayanan">Rp 12.500</span>
                        </div>
                        <div class="tagihan-row" id="tagihanDiskonRow">
                            <span class="lbl">Diskon BPJS</span>
                            <span class="val" id="tagihanDiskon">– Rp 0</span>
=======
                            <span class="val" id="tagihanSubtotal">Rp {{ number_format($detailPembayaran['subtotal_obat'], 0, ',', '.') }}</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Biaya layanan</span>
                            <span class="val" id="tagihanLayanan">Rp {{ number_format($detailPembayaran['biaya_layanan'], 0, ',', '.') }}</span>
                        </div>
                        <div class="tagihan-row" id="tagihanDiskonRow">
                            <span class="lbl" id="tagihanDiskonLbl">Diskon {{ $detailPembayaran['metode'] }}</span>
                            <span class="val" id="tagihanDiskon">- Rp {{ number_format($detailPembayaran['diskon'], 0, ',', '.') }}</span>
>>>>>>> main
                        </div>
                        <div class="tagihan-divider"></div>
                        <div class="tagihan-total">
                            <span class="lbl">Total Bayar</span>
<<<<<<< HEAD
                            <span class="val" id="tagihanTotal">Rp 87.500</span>
                        </div>
                    </div>
                    {{-- Tombol Bayar Sekarang: hanya aktif kalau status = menunggu --}}
                    <a href="#" id="btnBayarSekarang" class="btn-bayar" style="margin-top:12px;">Bayar Sekarang</a>
                    <p id="btnBayarInfo" style="display:none; text-align:center; font-size:.78rem; color:var(--ss-muted); margin-top:8px;"></p>
=======
                            <span class="val" id="tagihanTotal">Rp {{ number_format($detailPembayaran['total_bayar'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if(strtolower($detailPembayaran['status']) === 'menunggu')
                    {{-- href diisi oleh JS berdasarkan metode terpilih --}}
                    <a href="#" id="btnBayarSekarang" class="btn-bayar" style="margin-top:12px;">
                        Bayar Sekarang
                    </a>
                    @endif

                    <p id="btnBayarInfo" style="display:none; text-align:center; font-size:.78rem; color:var(--ss-muted); margin-top:8px;"></p>
                    @else
                    <p style="text-align: center; color: var(--ss-muted);">Tidak ada tagihan aktif.</p>
                    @endif
>>>>>>> main
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
                                    <div class="metode-name">Mandiri</div>
<<<<<<< HEAD
                                   
=======
>>>>>>> main
                                </div>
                            </div>
                            <div class="metode-check"></div>
                        </div>
<<<<<<< HEAD

=======
>>>>>>> main
                    </div>
                </div>
            </div>

        </div>
<<<<<<< HEAD

=======
>>>>>>> main
    </div>

    {{-- MODAL PEMBAYARAN --}}
    <div class="modal-overlay" id="modalPayment">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-left">
                    <h2 id="modalTitle">Konfirmasi Pembayaran</h2>
                    <p id="modalSubtitle">INV-2026-0077</p>
                </div>
                <button class="modal-close" id="modalCloseBtn">✕</button>
            </div>
            <div class="modal-body">
<<<<<<< HEAD

                {{-- Ringkasan invoice --}}
=======
>>>>>>> main
                <div class="modal-invoice" id="modalInvoice">
                    <div class="modal-invoice-row">
                        <span>Resep</span><span>RSP-2026-0051</span>
                    </div>
                    <div class="modal-invoice-row">
                        <span>Dokter</span><span>Dr. Budi Santoso</span>
                    </div>
                    <div class="modal-invoice-row">
                        <span>Subtotal Obat</span><span>Rp 75.000</span>
                    </div>
                    <div class="modal-invoice-row">
                        <span>Biaya Layanan</span><span>Rp 12.500</span>
                    </div>
                    <div class="modal-invoice-total">
                        <span class="lbl">Total Bayar</span>
                        <span class="val">Rp 87.500</span>
                    </div>
                </div>

<<<<<<< HEAD
                {{-- Panel BPJS --}}
=======
>>>>>>> main
                <div class="panel-bpjs" id="panelBpjs">
                    <div class="bpjs-number-wrap">
                        <div class="bpjs-label">📋 Nomor BPJS Kesehatan</div>
                        <div class="bpjs-number" id="bpjsNumber">0001 2345 6789 01</div>
                        <div class="bpjs-name" id="bpjsName">Nama Peserta Aktif</div>
                        <div class="bpjs-status">✅ Peserta Aktif</div>
                    </div>
                    <div class="bpjs-info">
                        ℹ️ Tunjukkan nomor BPJS ini kepada petugas apotek. Biaya ditanggung sesuai ketentuan BPJS Kesehatan.
                    </div>
                </div>

<<<<<<< HEAD
                {{-- Panel Mandiri Barcode --}}
=======
>>>>>>> main
                <div class="panel-mandiri" id="panelMandiri">
                    <div class="barcode-dashed">
                        <div class="barcode-lbl">Barcode Pembayaran Mandiri</div>
                        <div class="barcode-img-wrap">
<<<<<<< HEAD
                            {{-- Ganti src dengan path gambar barcode kamu --}}
=======
>>>>>>> main
                            <img id="barcodeImg" src="" alt="Barcode" style="display:none;">
                            <div class="barcode-placeholder" id="barcodePlaceholder">
                                🖼️<br>Tambahkan gambar barcode<br>di sini
                            </div>
                        </div>
                        <div class="barcode-ref" id="barcodeRef">MDR-00000000-000000</div>
                        <div class="barcode-hint">Scan barcode untuk transfer via Bank Mandiri</div>
                    </div>
                </div>

<<<<<<< HEAD
                {{-- Processing state --}}
=======
>>>>>>> main
                <div class="modal-processing" id="modalProcessing">
                    <div class="modal-spinner"></div>
                    <div style="font-weight:700;margin-bottom:4px;">Memproses Pembayaran…</div>
                    <div style="font-size:.8rem;color:var(--ss-muted);">Mohon tunggu sebentar</div>
                </div>

<<<<<<< HEAD
                {{-- Success state --}}
=======
>>>>>>> main
                <div class="modal-success" id="modalSuccess">
                    <div class="icon">✅</div>
                    <div class="title">Pembayaran Dikonfirmasi!</div>
                    <div class="sub">Invoice Anda telah berhasil diproses</div>
                    <div style="font-size:1.2rem;font-weight:800;color:var(--ss-primary);margin-top:12px;">Rp 87.500</div>
                </div>

<<<<<<< HEAD
                {{-- Tombol konfirmasi --}}
                <button class="btn-konfirmasi" id="btnKonfirmasi">Konfirmasi Bayar</button>

=======
                <button class="btn-konfirmasi" id="btnKonfirmasi">Konfirmasi Bayar</button>
>>>>>>> main
            </div>
        </div>
    </div>

</div>

<<<<<<< HEAD
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== DATA TRANSAKSI =====
    const allTransactions = [
        { id: 'INV-2026-0077', date: '08 Des 2026', ref: 'RSP-0051', metode: 'BPJS', total: 87500, status: 'menunggu', icon: 'fa-clock', iconClass: 'inv-icon--pend' },
        { id: 'INV-2026-0070', date: '20 Nov 2026', ref: 'RSP-0048', metode: 'BPJS', total: 85000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0065', date: '10 Nov 2026', ref: 'RSP-0045', metode: 'Mandiri', total: 210000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0058', date: '02 Nov 2026', ref: 'RSP-0040', metode: 'Mandiri', total: 0, status: 'gagal', icon: 'fa-times', iconClass: 'inv-icon--fail' },
        { id: 'INV-2026-0050', date: '15 Okt 2026', ref: 'RSP-0038', metode: 'BPJS', total: 125000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0045', date: '05 Okt 2026', ref: 'RSP-0035', metode: 'Mandiri', total: 92500, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0040', date: '25 Sep 2026', ref: 'RSP-0032', metode: 'BPJS', total: 67000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0035', date: '15 Sep 2026', ref: 'RSP-0028', metode: 'Mandiri', total: 156000, status: 'proses', icon: 'fa-sync-alt', iconClass: 'inv-icon--proc' },
        { id: 'INV-2026-0030', date: '05 Sep 2026', ref: 'RSP-0025', metode: 'BPJS', total: 94500, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' }
    ];

    const itemsPerPage = 5;
    let currentPage = 1;
    let filteredTransactions = [...allTransactions];
    let selectedPaymentMethod = 'BPJS';

    // ===== HELPER FORMAT RUPIAH =====
    function formatRp(num) {
        if (num === 0) return 'Rp 0';
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    // ===== UPDATE TAGIHAN AKTIF BERDASARKAN METODE =====
    function updateTagihan(metode) {
        const tagihanEl = document.getElementById('tagihanData');
        if (!tagihanEl) return;
        const subtotal  = parseInt(tagihanEl.dataset.subtotal);
        const layanan   = parseInt(tagihanEl.dataset.layanan);
        const totalNormal = parseInt(tagihanEl.dataset.totalNormal);
        const status    = tagihanEl.dataset.status;
        const invoice   = tagihanEl.dataset.invoice;

        const elSubtotal = document.getElementById('tagihanSubtotal');
        const elLayanan  = document.getElementById('tagihanLayanan');
        const elDiskon   = document.getElementById('tagihanDiskon');
        const elDiskonRow = document.getElementById('tagihanDiskonRow');
        const elTotal    = document.getElementById('tagihanTotal');
        const btnBayar   = document.getElementById('btnBayarSekarang');
        const btnInfo    = document.getElementById('btnBayarInfo');

        if (metode === 'BPJS') {
            // BPJS: semua ditanggung pemerintah → total 0
            if (elSubtotal) elSubtotal.textContent = formatRp(subtotal);
            if (elLayanan)  elLayanan.textContent  = formatRp(layanan);
            if (elDiskon)   elDiskon.textContent   = '– ' + formatRp(subtotal + layanan);
            if (elDiskonRow) elDiskonRow.style.display = '';
            if (elTotal)    elTotal.textContent    = 'Rp 0';
            if (elTotal)    elTotal.style.color    = 'var(--ss-success)';
        } else {
            // Mandiri/lainnya: total normal, tidak ada diskon BPJS
            if (elSubtotal) elSubtotal.textContent = formatRp(subtotal);
            if (elLayanan)  elLayanan.textContent  = formatRp(layanan);
            if (elDiskon)   elDiskon.textContent   = '– Rp 0';
            if (elDiskonRow) elDiskonRow.style.display = 'none';
            if (elTotal)    elTotal.textContent    = formatRp(totalNormal);
            if (elTotal)    elTotal.style.color    = '';
        }

        // Hitung total aktual untuk dikirim ke halaman bayar
        const totalAktual = metode === 'BPJS' ? 0 : totalNormal;

        // Tombol Bayar Sekarang — hanya bisa diklik kalau status = menunggu
        if (btnBayar) {
            if (status === 'menunggu') {
                const url = `{{ url('pasien/pembayaran/bayar') }}/${invoice}?metode=${metode}&total=${totalAktual}`;
                btnBayar.href = url;
                btnBayar.style.opacity = '1';
                btnBayar.style.pointerEvents = 'auto';
                btnBayar.style.cursor = 'pointer';
                if (btnInfo) btnInfo.style.display = 'none';
            } else {
                btnBayar.href = '#';
                btnBayar.style.opacity = '0.45';
                btnBayar.style.pointerEvents = 'none';
                btnBayar.style.cursor = 'not-allowed';
                if (btnInfo) {
                    btnInfo.style.display = 'block';
                    btnInfo.textContent = 'Menunggu konfirmasi apoteker sebelum dapat dibayar';
                }
            }
        }
    }

    // ===== METODE PEMBAYARAN =====
    const metodeItems = document.querySelectorAll('.metode-item');
    metodeItems.forEach(item => {
        item.addEventListener('click', function() {
            metodeItems.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            selectedPaymentMethod = this.dataset.metode;
            updateTagihan(selectedPaymentMethod);
        });
    });

    // Init tagihan saat halaman pertama dibuka
    updateTagihan(selectedPaymentMethod);

    // ===== FILTER SELECT =====
    const filterSelects = document.querySelectorAll('.filter-select');
    const statusSelect = filterSelects[0];
    const metodeSelect = filterSelects[1];

    if (statusSelect) {
        statusSelect.addEventListener('change', function() { currentPage = 1; applyFilters(); });
    }
    if (metodeSelect) {
        metodeSelect.addEventListener('change', function() { currentPage = 1; applyFilters(); });
    }

    // ===== FUNGSI FILTER =====
    function applyFilters() {
        const selectedMetode = metodeSelect ? metodeSelect.value : 'Semua Metode';
        const selectedStatus = statusSelect ? statusSelect.value : 'Semua Status';
        filteredTransactions = allTransactions.filter(trans => {
            let metodeMatch = selectedMetode === 'Semua Metode' || trans.metode === selectedMetode;
            let statusMatch = selectedStatus === 'Semua Status' || trans.status === selectedStatus;
            return metodeMatch && statusMatch;
        });
        renderTable();
    }

    // ===== RENDER TABEL =====
    function renderTable() {
        const tbody = document.querySelector('.bayar-table tbody');
        if (!tbody) return;
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageItems = filteredTransactions.slice(start, end);
        tbody.innerHTML = pageItems.map(trans => `
            <tr>
                <td>
                    <div class="inv-cell">
                        <div class="inv-icon ${trans.iconClass}">
                            <i class="fas ${trans.icon}"></i>
                        </div>
                        <div>
                            <div class="inv-no">${trans.id}</div>
                            <div class="inv-date">${trans.date} • ${trans.ref}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="metode-cell">
                        <span class="metode-dot metode-dot--${trans.metode.toLowerCase()}"></span> ${trans.metode}
                    </div>
                </td>
                <td><span class="total-cell">${trans.total > 0 ? 'Rp ' + trans.total.toLocaleString('id-ID') : '-'}</span></td>
                <td><span class="badge badge--${trans.status}">${getStatusLabel(trans.status)}</span></td>
            </tr>
        `).join('');
        updatePagination();
    }

    // ===== PAGINATION =====
    function updatePagination() {
        const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
        const paginationInfo = document.querySelector('.pagination-info');
        const paginationBtns = document.querySelector('.pagination-btns');
        if (paginationInfo) {
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, filteredTransactions.length);
            paginationInfo.textContent = `Menampilkan ${start}–${end} dari ${filteredTransactions.length} transaksi`;
        }
        if (paginationBtns) {
            paginationBtns.innerHTML = '';
            const prevBtn = document.createElement('button');
            prevBtn.className = 'pg-btn';
            prevBtn.innerHTML = '‹';
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', (e) => { e.preventDefault(); if (currentPage > 1) { currentPage--; renderTable(); } });
            paginationBtns.appendChild(prevBtn);
            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `pg-btn ${i === currentPage ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.addEventListener('click', (e) => { e.preventDefault(); currentPage = i; renderTable(); });
                paginationBtns.appendChild(pageBtn);
            }
            const nextBtn = document.createElement('button');
            nextBtn.className = 'pg-btn';
            nextBtn.innerHTML = '›';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', (e) => { e.preventDefault(); if (currentPage < totalPages) { currentPage++; renderTable(); } });
            paginationBtns.appendChild(nextBtn);
        }
    }

    // ===== HELPER =====
    function getStatusLabel(status) {
        const labels = { 'lunas': 'Lunas', 'menunggu': 'Menunggu', 'gagal': 'Gagal', 'proses': 'Diproses' };
        return labels[status] || status;
    }

    // ===== SEARCH =====
    const searchInput = document.querySelector('.search-wrap input');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const selectedMetode = metodeSelect ? metodeSelect.value : 'Semua Metode';
            const selectedStatus = statusSelect ? statusSelect.value : 'Semua Status';
            filteredTransactions = allTransactions.filter(trans => {
                let metodeMatch = selectedMetode === 'Semua Metode' || trans.metode === selectedMetode;
                let statusMatch = selectedStatus === 'Semua Status' || trans.status === selectedStatus;
                let searchMatch = trans.id.toLowerCase().includes(query) || trans.ref.toLowerCase().includes(query);
                return metodeMatch && statusMatch && searchMatch;
            });
            currentPage = 1;
            renderTable();
        });
    }

    // ===== MODAL PEMBAYARAN =====
    const modal          = document.getElementById('modalPayment');
    const modalTitle     = document.getElementById('modalTitle');
    const modalSubtitle  = document.getElementById('modalSubtitle');
    const modalInvoice   = document.getElementById('modalInvoice');
    const panelBpjs      = document.getElementById('panelBpjs');
    const panelMandiri   = document.getElementById('panelMandiri');
    const modalProcessing= document.getElementById('modalProcessing');
    const modalSuccess   = document.getElementById('modalSuccess');
    const btnKonfirmasi  = document.getElementById('btnKonfirmasi');
    const barcodeRef     = document.getElementById('barcodeRef');

    // State pembayaran aktif
    let activeInvoice = 'INV-2026-0077';
    let activeTotal   = 87500;

    // Generate referensi barcode Mandiri
    function genMandiriRef() {
        const ts = Date.now().toString().slice(-8);
        const rand = Math.random().toString(36).substring(2,8).toUpperCase();
        return `MDR-${ts}-${rand}`;
    }

    function resetModal() {
        modalInvoice.style.display  = '';
        panelBpjs.classList.remove('show');
        panelMandiri.classList.remove('show');
        modalProcessing.classList.remove('show');
        modalSuccess.classList.remove('show');
        btnKonfirmasi.style.display = '';
        btnKonfirmasi.textContent   = 'Konfirmasi Bayar';
        btnKonfirmasi.disabled      = false;
    }

    function openModal(invoiceId, total) {
        activeInvoice = invoiceId;
        activeTotal   = total;
        resetModal();
        const metode = selectedPaymentMethod;

        if (metode === 'BPJS') {
            modalTitle.textContent    = 'Pembayaran BPJS';
            modalSubtitle.textContent = 'Ditanggung Pemerintah';
            panelBpjs.classList.add('show');
            btnKonfirmasi.textContent = 'Konfirmasi & Selesai';
        } else {
            modalTitle.textContent    = 'Pembayaran Bank Mandiri';
            modalSubtitle.textContent = 'Tidak ditanggung pemerintah';
            barcodeRef.textContent    = genMandiriRef();
            panelMandiri.classList.add('show');
            btnKonfirmasi.textContent = 'Konfirmasi Pembayaran';
        }

        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Tombol "Bayar Sekarang" → navigasi ke halaman bayar (tidak dibuka modal lagi)

    // Tombol tutup modal
    document.getElementById('modalCloseBtn').addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    // Tombol Konfirmasi → kirim ke route pasien.pembayaran.proses
    btnKonfirmasi.addEventListener('click', async function() {
        btnKonfirmasi.disabled = true;
        modalInvoice.style.display  = 'none';
        panelBpjs.classList.remove('show');
        panelMandiri.classList.remove('show');
        btnKonfirmasi.style.display = 'none';
        modalProcessing.classList.add('show');

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                           || document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]
                           || '';

            const res = await fetch('{{ route("pasien.pembayaran.proses") }}', {
                method : 'POST',
                headers: {
                    'Content-Type'    : 'application/json',
                    'Accept'          : 'application/json',
                    'X-CSRF-TOKEN'    : csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    invoice_id : activeInvoice,
                    metode     : selectedPaymentMethod,
                    total_bayar: activeTotal,
                }),
            });

            const data = await res.json();

            modalProcessing.classList.remove('show');

            if (data.success) {
                // Update kode referensi di success state jika ada
                const successEl = document.getElementById('modalSuccess');
                successEl.querySelector('.sub').textContent =
                    `Ref: ${data.kode_ref} • ${data.waktu}`;
                successEl.classList.add('show');
                setTimeout(() => { closeModal(); }, 3000);
            } else {
                // Gagal — tampilkan kembali form
                alert('Pembayaran gagal diproses. Silakan coba lagi.');
                resetModal();
                if (selectedPaymentMethod === 'BPJS') {
                    panelBpjs.classList.add('show');
                } else {
                    panelMandiri.classList.add('show');
                }
            }
        } catch (err) {
            console.error('Bayar error:', err);
            modalProcessing.classList.remove('show');
            alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
            resetModal();
            if (selectedPaymentMethod === 'BPJS') {
                panelBpjs.classList.add('show');
            } else {
                panelMandiri.classList.add('show');
            }
        }
    });

    // Escape key untuk tutup modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    // ===== INITIAL RENDER =====
    renderTable();
});
</script>

@endsection
=======
{{-- CSRF untuk AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('scripts')
<script src="{{ asset('js/pembayaran.js') }}"></script>
@endpush
>>>>>>> main
