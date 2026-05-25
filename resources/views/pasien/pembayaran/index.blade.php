@extends('layouts.app')

@section('title', 'Pembayaran — Sick Safe ON')

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

/* Responsive */
@media (max-width: 1000px) {
    .main-grid { grid-template-columns: 1fr; }
    .stat-row  { grid-template-columns: repeat(2, 1fr); }
}
</style>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== DATA TRANSAKSI =====
    const allTransactions = [
        { id: 'INV-2026-0077', date: '08 Des 2026', ref: 'RSP-0051', metode: 'BPJS', total: 87500, status: 'menunggu', icon: 'fa-clock', iconClass: 'inv-icon--pend' },
        { id: 'INV-2026-0070', date: '20 Nov 2026', ref: 'RSP-0048', metode: 'BPJS', total: 85000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0065', date: '10 Nov 2026', ref: 'RSP-0045', metode: 'Mandiri', total: 210000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0058', date: '02 Nov 2026', ref: 'RSP-0040', metode: 'Tunai', total: 0, status: 'gagal', icon: 'fa-times', iconClass: 'inv-icon--fail' },
        { id: 'INV-2026-0050', date: '15 Okt 2026', ref: 'RSP-0038', metode: 'BPJS', total: 125000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0045', date: '05 Okt 2026', ref: 'RSP-0035', metode: 'Mandiri', total: 92500, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0040', date: '25 Sep 2026', ref: 'RSP-0032', metode: 'BPJS', total: 67000, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0035', date: '15 Sep 2026', ref: 'RSP-0028', metode: 'Tunai', total: 156000, status: 'proses', icon: 'fa-sync-alt', iconClass: 'inv-icon--proc' },
        { id: 'INV-2026-0030', date: '05 Sep 2026', ref: 'RSP-0025', metode: 'BPJS', total: 94500, status: 'lunas', icon: 'fa-check', iconClass: 'inv-icon--done' }
    ];

    const itemsPerPage = 5;
    let currentPage = 1;
    let filteredTransactions = [...allTransactions];
    let selectedPaymentMethod = 'BPJS';

    // ===== METODE PEMBAYARAN =====
    const metodeItems = document.querySelectorAll('.metode-item');
    metodeItems.forEach(item => {
        item.addEventListener('click', function() {
            metodeItems.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            selectedPaymentMethod = this.dataset.metode;
            console.log('Metode dipilih:', selectedPaymentMethod);
        });
    });

    // ===== FILTER SELECT =====
    const filterSelects = document.querySelectorAll('.filter-select');
    const statusSelect = filterSelects[0];
    const metodeSelect = filterSelects[1];

    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            currentPage = 1;
            applyFilters();
        });
    }

    if (metodeSelect) {
        metodeSelect.addEventListener('change', function() {
            currentPage = 1;
            applyFilters();
        });
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

            // Tombol Previous
            const prevBtn = document.createElement('button');
            prevBtn.className = 'pg-btn';
            prevBtn.innerHTML = '‹';
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', (e) => { 
                e.preventDefault(); 
                if (currentPage > 1) { 
                    currentPage--; 
                    renderTable(); 
                } 
            });
            paginationBtns.appendChild(prevBtn);

            // Tombol Nomor Halaman
            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `pg-btn ${i === currentPage ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.addEventListener('click', (e) => { 
                    e.preventDefault(); 
                    currentPage = i; 
                    renderTable(); 
                });
                paginationBtns.appendChild(pageBtn);
            }

            // Tombol Next
            const nextBtn = document.createElement('button');
            nextBtn.className = 'pg-btn';
            nextBtn.innerHTML = '›';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', (e) => { 
                e.preventDefault(); 
                if (currentPage < totalPages) { 
                    currentPage++; 
                    renderTable(); 
                } 
            });
            paginationBtns.appendChild(nextBtn);
        }
    }

    // ===== HELPER FUNCTION =====
    function getStatusLabel(status) {
        const labels = {
            'lunas': 'Lunas',
            'menunggu': 'Menunggu',
            'gagal': 'Gagal',
            'proses': 'Diproses'
        };
        return labels[status] || status;
    }

    // ===== SEARCH FUNCTIONALITY =====
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

    // ===== INITIAL RENDER =====
    renderTable();
});
</script>

@endsection