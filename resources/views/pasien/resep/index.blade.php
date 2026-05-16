@extends('layouts.app')

@section('title', 'Resep Saya — Sick Safe ON')

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
    --ss-bg:            #f4f7fb;
    --ss-font:          'Plus Jakarta Sans', sans-serif;
    --ss-radius:        14px;
    --ss-radius-sm:     8px;
    --ss-shadow:        0 2px 12px rgba(0,0,0,.07);
}

.resep-page {
    font-family: var(--ss-font);
    color: var(--ss-text);
    padding: 0;
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

.page-title-wrap h1 {
    font-size: 1.4rem;
    font-weight: 800;
    margin: 0;
}

.page-title-wrap p {
    font-size: .83rem;
    color: var(--ss-muted);
    margin: 3px 0 0;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--ss-primary);
    color: #fff;
    border: none;
    border-radius: var(--ss-radius-sm);
    padding: 10px 18px;
    font-size: .85rem;
    font-weight: 600;
    font-family: var(--ss-font);
    cursor: pointer;
    text-decoration: none;
    transition: background .2s, transform .15s;
}

.btn-primary:hover {
    background: var(--ss-primary-dark);
    transform: translateY(-1px);
}

/* ── STAT CARDS ── */
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

.stat-card:nth-child(1) { animation-delay: .05s; }
.stat-card:nth-child(2) { animation-delay: .10s; }
.stat-card:nth-child(3) { animation-delay: .15s; }
.stat-card:nth-child(4) { animation-delay: .20s; }

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.1rem;
}

.stat-icon--teal    { background: var(--ss-primary-light); color: var(--ss-primary); }
.stat-icon--warning { background: #fff4ee; color: var(--ss-warning); }
.stat-icon--info    { background: #dbeafe; color: var(--ss-info); }
.stat-icon--success { background: #dcfce7; color: var(--ss-success); }

.stat-text .num {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1;
}

.stat-text .lbl {
    font-size: .75rem;
    color: var(--ss-muted);
    font-weight: 500;
    margin-top: 3px;
}

/* ── FILTER BAR ── */
.filter-bar {
    background: var(--ss-card);
    border: 1px solid var(--ss-border);
    border-radius: var(--ss-radius);
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    box-shadow: var(--ss-shadow);
}

.search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
}

.search-wrap input {
    width: 100%;
    padding: 9px 14px 9px 38px;
    border: 1.5px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    font-size: .85rem;
    font-family: var(--ss-font);
    color: var(--ss-text);
    outline: none;
    transition: border-color .2s;
}

.search-wrap input:focus { border-color: var(--ss-primary); }

.search-wrap svg {
    position: absolute;
    left: 11px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--ss-muted);
}

.filter-select {
    padding: 9px 14px;
    border: 1.5px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    font-size: .85rem;
    font-family: var(--ss-font);
    color: var(--ss-text);
    background: #fff;
    outline: none;
    cursor: pointer;
    transition: border-color .2s;
}

.filter-select:focus { border-color: var(--ss-primary); }

/* ── TABLE CARD ── */
.table-card {
    background: var(--ss-card);
    border-radius: var(--ss-radius);
    border: 1px solid var(--ss-border);
    box-shadow: var(--ss-shadow);
    overflow: hidden;
    animation: fadeUp .5s ease .25s both;
}

.table-head-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--ss-border);
}

.table-head-row h2 {
    font-size: .95rem;
    font-weight: 700;
    margin: 0;
}

.badge-count {
    background: var(--ss-primary-light);
    color: var(--ss-primary);
    font-size: .72rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
}

/* Table */
.resep-table {
    width: 100%;
    border-collapse: collapse;
}

.resep-table thead tr {
    background: #f8fafc;
}

.resep-table thead th {
    padding: 11px 16px;
    font-size: .72rem;
    font-weight: 700;
    color: var(--ss-muted);
    text-transform: uppercase;
    letter-spacing: .5px;
    text-align: left;
    border-bottom: 1px solid var(--ss-border);
}

.resep-table tbody tr {
    border-bottom: 1px solid var(--ss-border);
    transition: background .15s;
}

.resep-table tbody tr:last-child { border-bottom: none; }
.resep-table tbody tr:hover { background: var(--ss-primary-light); }

.resep-table tbody td {
    padding: 14px 16px;
    font-size: .83rem;
    vertical-align: middle;
}

.resep-no-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.resep-icon-sm {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: var(--ss-primary-light);
    color: var(--ss-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.resep-icon-sm--done { background: #f0fdf4; color: var(--ss-success); }
.resep-icon-sm--warn { background: #fff4ee; color: var(--ss-warning); }

.resep-no-text {
    font-weight: 700;
    font-size: .83rem;
    color: var(--ss-text);
}

.resep-date-text {
    font-size: .72rem;
    color: var(--ss-muted);
    margin-top: 2px;
}

.dokter-text {
    font-weight: 600;
    font-size: .83rem;
}

.obat-text {
    font-size: .8rem;
    color: var(--ss-muted);
}

.total-text {
    font-weight: 700;
    font-size: .85rem;
    color: var(--ss-text);
}

/* Status Badge */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 11px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge--proses   { background: #dbeafe; color: #1d4ed8; }
.badge--selesai  { background: #dcfce7; color: #15803d; }
.badge--tunggu   { background: #fef9c3; color: #a16207; }
.badge--batal    { background: #fee2e2; color: #b91c1c; }

/* Pagination */
.pagination-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid var(--ss-border);
    flex-wrap: wrap;
    gap: 10px;
}

.pagination-info {
    font-size: .78rem;
    color: var(--ss-muted);
}

.pagination-btns {
    display: flex;
    gap: 6px;
}

.pg-btn {
    width: 32px;
    height: 32px;
    border-radius: 7px;
    border: 1.5px solid var(--ss-border);
    background: #fff;
    font-size: .8rem;
    font-weight: 600;
    font-family: var(--ss-font);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s;
    color: var(--ss-text);
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

/* Responsive */
@media (max-width: 900px) {
    .stat-row { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="resep-page">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <h1>Resep Saya 💊</h1>
            <p>Kelola semua resep digital Anda di sini</p>
        </div>
        <a href="#" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Ajukan Resep Baru
        </a>
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
                <!-- Diisi oleh JavaScript -->
            </tbody>
        </table>

        <div class="pagination-wrap">
            <div class="pagination-info" id="pagination-info"></div>
            <div class="pagination-btns" id="pagination-btns"></div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== DATA RESEP =====
    const allResep = [
        { nomor: 'RSP-2026-0051', tanggal: '2026-05-08', dokter: 'Dr. Budi Santoso', obat: 3, total: 125000, status: 'proses', icon: 'fa-file-prescription', iconClass: 'resep-icon-sm resep-icon-sm--warn' },
        { nomor: 'RSP-2026-0050', tanggal: '2026-05-01', dokter: 'Dr. Sari Dewi', obat: 2, total: 87500, status: 'tunggu', icon: 'fa-file-prescription', iconClass: 'resep-icon-sm' },
        { nomor: 'RSP-2026-0048', tanggal: '2026-04-20', dokter: 'Dr. Budi Santoso', obat: 2, total: 85000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' },
        { nomor: 'RSP-2026-0045', tanggal: '2026-04-15', dokter: 'Dr. Ahmad Hidayat', obat: 4, total: 210000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' },
        { nomor: 'RSP-2026-0042', tanggal: '2026-04-10', dokter: 'Dr. Siti Nurhaliza', obat: 1, total: 45000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' },
        { nomor: 'RSP-2026-0040', tanggal: '2026-04-05', dokter: 'Dr. Budi Santoso', obat: 3, total: 105000, status: 'proses', icon: 'fa-file-prescription', iconClass: 'resep-icon-sm resep-icon-sm--warn' },
        { nomor: 'RSP-2026-0038', tanggal: '2026-03-28', dokter: 'Dr. Sari Dewi', obat: 2, total: 75000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' },
        { nomor: 'RSP-2026-0035', tanggal: '2026-03-20', dokter: 'Dr. Ahmad Hidayat', obat: 5, total: 265000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' },
        { nomor: 'RSP-2026-0032', tanggal: '2026-03-15', dokter: 'Dr. Rina Wijaya', obat: 3, total: 155000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' },
        { nomor: 'RSP-2026-0030', tanggal: '2026-03-10', dokter: 'Dr. Budi Santoso', obat: 2, total: 92000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' },
        { nomor: 'RSP-2026-0028', tanggal: '2026-03-05', dokter: 'Dr. Siti Nurhaliza', obat: 1, total: 38000, status: 'batal', icon: 'fa-times', iconClass: 'resep-icon-sm' },
        { nomor: 'RSP-2026-0025', tanggal: '2026-03-01', dokter: 'Dr. Sari Dewi', obat: 4, total: 198000, status: 'selesai', icon: 'fa-check', iconClass: 'resep-icon-sm resep-icon-sm--done' }
    ];

    const itemsPerPage = 5;
    let currentPage = 1;
    let filteredResep = [...allResep];

    // ===== FUNGSI FILTER =====
    function applyFilters() {
        const statusSelect = document.querySelector('.filter-status');
        const bulanSelect = document.querySelector('.filter-bulan');
        const searchInput = document.querySelector('.search-wrap input');

        const selectedStatus = statusSelect ? statusSelect.value : '';
        const selectedBulan = bulanSelect ? bulanSelect.value : '';
        const searchQuery = searchInput ? searchInput.value.toLowerCase() : '';

        filteredResep = allResep.filter(resep => {
            let statusMatch = !selectedStatus || resep.status === selectedStatus;
            let bulanMatch = !selectedBulan || resep.tanggal.startsWith(selectedBulan);
            let searchMatch = !searchQuery || 
                            resep.nomor.toLowerCase().includes(searchQuery) || 
                            resep.dokter.toLowerCase().includes(searchQuery);
            return statusMatch && bulanMatch && searchMatch;
        });

        currentPage = 1;
        renderTable();
    }

    // ===== RENDER TABEL =====
    function renderTable() {
        const tbody = document.getElementById('resep-tbody');
        if (!tbody) return;

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageItems = filteredResep.slice(start, end);

        tbody.innerHTML = pageItems.map(resep => {
            const tanggal = new Date(resep.tanggal + 'T00:00:00');
            const tanggalFormatted = tanggal.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            
            return `
            <tr>
                <td>
                    <div class="resep-no-cell">
                        <div class="${resep.iconClass}">
                            <i class="fas ${resep.icon}" style="font-size:13px;"></i>
                        </div>
                        <div>
                            <div class="resep-no-text">${resep.nomor}</div>
                            <div class="resep-date-text">${tanggalFormatted}</div>
                        </div>
                    </div>
                </td>
                <td><span class="dokter-text">${resep.dokter}</span></td>
                <td><span class="obat-text">${resep.obat} Obat</span></td>
                <td><span class="total-text">Rp ${resep.total.toLocaleString('id-ID')}</span></td>
                <td><span class="badge badge--${resep.status}">${getStatusLabel(resep.status)}</span></td>
            </tr>
            `;
        }).join('');

        updatePagination();
        updateResepCount();
    }

    // ===== PAGINATION =====
    function updatePagination() {
        const totalPages = Math.ceil(filteredResep.length / itemsPerPage);
        const paginationInfo = document.getElementById('pagination-info');
        const paginationBtns = document.getElementById('pagination-btns');

        if (paginationInfo) {
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, filteredResep.length);
            paginationInfo.textContent = `Menampilkan ${start}–${end} dari ${filteredResep.length} resep`;
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
                    window.scrollTo({ top: 0, behavior: 'smooth' });
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
                    window.scrollTo({ top: 0, behavior: 'smooth' });
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
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } 
            });
            paginationBtns.appendChild(nextBtn);
        }
    }

    // ===== UPDATE RESEP COUNT =====
    function updateResepCount() {
        const badge = document.getElementById('resep-count');
        if (badge) {
            badge.textContent = `${filteredResep.length} Resep`;
        }
    }

    // ===== HELPER FUNCTION =====
    function getStatusLabel(status) {
        const labels = {
            'proses': 'Sedang Diproses',
            'tunggu': 'Menunggu Pembayaran',
            'selesai': 'Selesai',
            'batal': 'Dibatalkan'
        };
        return labels[status] || status;
    }

    // ===== EVENT LISTENERS =====
    const statusSelect = document.querySelector('.filter-status');
    const bulanSelect = document.querySelector('.filter-bulan');
    const searchInput = document.querySelector('.search-wrap input');

    if (statusSelect) {
        statusSelect.addEventListener('change', applyFilters);
    }

    if (bulanSelect) {
        bulanSelect.addEventListener('change', applyFilters);
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', applyFilters);
    }

    // ===== INITIAL RENDER =====
    renderTable();
});
</script>

@endsection