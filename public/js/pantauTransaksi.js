/* ============================
   pantauTransaksi.js
   Aksi: Lihat Detail + Dropdown (Konfirmasi, Cetak, Batalkan)
   Pagination: per 3 halaman (window)
============================ */

/* ============================
   DATA DUMMY
============================ */
let trxData = [
    { id: 1,  trxId:'TRX-2026-0847', patientName:'Andi Setiawan',    patientType:'Pasien Umum',  rm:'RM-02456', type:'bpjs',    total:125000, date:'2026-05-16', time:'14:32', status:'selesai' },
    { id: 2,  trxId:'TRX-2026-0846', patientName:'Dewi Kusuma',      patientType:'Pasien BPJS',  rm:'RM-01298', type:'mandiri', total:85000,  date:'2026-05-16', time:'13:15', status:'selesai' },
    { id: 3,  trxId:'TRX-2026-0845', patientName:'Bambang Sutrisno', patientType:'Pasien Umum',  rm:'RM-03121', type:'bpjs',    total:210000, date:'2026-05-16', time:'12:45', status:'pending' },
    { id: 4,  trxId:'TRX-2026-0844', patientName:'Lina Maulida',     patientType:'Pasien BPJS',  rm:'RM-02897', type:'mandiri', total:55000,  date:'2026-05-16', time:'11:20', status:'selesai' },
    { id: 5,  trxId:'TRX-2026-0843', patientName:'Hendra Gunawan',   patientType:'Pasien Umum',  rm:'RM-01567', type:'bpjs',    total:320000, date:'2026-05-15', time:'16:05', status:'pending' },
    { id: 6,  trxId:'TRX-2026-0842', patientName:'Maya Safitri',     patientType:'Pasien BPJS',  rm:'RM-02345', type:'mandiri', total:175000, date:'2026-05-15', time:'15:30', status:'selesai' },
    { id: 7,  trxId:'TRX-2026-0841', patientName:'Rudi Hartono',     patientType:'Pasien Umum',  rm:'RM-04001', type:'bpjs',    total:90000,  date:'2026-05-15', time:'10:00', status:'selesai' },
    { id: 8,  trxId:'TRX-2026-0840', patientName:'Sari Wulandari',   patientType:'Pasien BPJS',  rm:'RM-03890', type:'mandiri', total:450000, date:'2026-05-14', time:'09:30', status:'pending' },
    { id: 9,  trxId:'TRX-2026-0839', patientName:'Budi Santoso',     patientType:'Pasien Umum',  rm:'RM-02110', type:'bpjs',    total:65000,  date:'2026-05-14', time:'08:45', status:'selesai' },
    { id:10,  trxId:'TRX-2026-0838', patientName:'Fitri Amalia',     patientType:'Pasien BPJS',  rm:'RM-01750', type:'mandiri', total:230000, date:'2026-05-13', time:'14:00', status:'selesai' },
    { id:11,  trxId:'TRX-2026-0837', patientName:'Agus Priyanto',    patientType:'Pasien Umum',  rm:'RM-03342', type:'bpjs',    total:185000, date:'2026-05-13', time:'11:30', status:'pending' },
    { id:12,  trxId:'TRX-2026-0836', patientName:'Nita Rahayu',      patientType:'Pasien BPJS',  rm:'RM-02678', type:'mandiri', total:310000, date:'2026-05-12', time:'16:45', status:'selesai' },
];

/* ============================
   STATE
============================ */
const ROWS_PER_PAGE  = 6;
const PAGE_WINDOW    = 3;   // tampilkan maks 3 nomor halaman sekaligus
let state = { search:'', cardFilter:'all', type:'', status:'', page:1, activeDropdownId:null };

/* ============================
   HELPERS
============================ */
function fmtPrice(n) {
    if (n >= 1000000) return 'Rp ' + (n/1000000).toFixed(1) + ' Juta';
    return 'Rp ' + n.toLocaleString('id-ID');
}
function fmtPriceFull(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

function fmtDate(iso) {
    const d = new Date(iso);
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    return `${String(d.getDate()).padStart(2,'0')} ${months[d.getMonth()]} ${d.getFullYear()}`;
}

function statusLabel(s) {
    if (s === 'selesai') return 'Selesai';
    if (s === 'pending') return 'Pending';
    if (s === 'batal')   return 'Batal';
    return s;
}
function typeLabel(t)   { return t === 'bpjs' ? 'BPJS' : 'Mandiri'; }

/* ============================
   FILTER LOGIC
============================ */
function getFiltered() {
    const q = state.search.toLowerCase();
    return trxData.filter(t => {
        const matchSearch = !q ||
            t.trxId.toLowerCase().includes(q) ||
            t.patientName.toLowerCase().includes(q);
        const matchCard   = state.cardFilter === 'all' || t.status === state.cardFilter;
        const matchType   = !state.type   || t.type   === state.type;
        const matchStatus = !state.status || t.status === state.status;
        return matchSearch && matchCard && matchType && matchStatus;
    });
}

/* ============================
   RENDER TABLE
============================ */
function renderTable() {
    const filtered   = getFiltered();
    const total      = filtered.length;
    const totalPages = Math.max(1, Math.ceil(total / ROWS_PER_PAGE));
    if (state.page > totalPages) state.page = totalPages;

    const start    = (state.page - 1) * ROWS_PER_PAGE;
    const end      = Math.min(start + ROWS_PER_PAGE, total);
    const pageData = filtered.slice(start, end);

    const tbody      = document.getElementById('trx-tbody');
    const emptyState = document.getElementById('empty-state');

    if (pageData.length === 0) {
        tbody.innerHTML = '';
        emptyState.style.display = 'block';
    } else {
        emptyState.style.display = 'none';
        tbody.innerHTML = pageData.map(t => `
            <tr data-id="${t.id}" class="trx-row">
                <td><span class="trx-id">${t.trxId}</span></td>
                <td>
                    <div class="patient-info">
                        <div class="patient-name">${t.patientName}</div>
                        <div class="patient-sub">${t.patientType}</div>
                    </div>
                </td>
                <td><span class="type-badge type-${t.type}">${typeLabel(t.type)}</span></td>
                <td class="amount-cell">${fmtPriceFull(t.total)}</td>
                <td class="time-cell">
                    <div>${fmtDate(t.date)}</div>
                    <div class="time-sub">${t.time} WIB</div>
                </td>
                <td><span class="status-badge status-${t.status}">
                    ${t.status === 'selesai'
                        ? '<i class="fa-solid fa-circle-check" style="font-size:9px"></i>'
                        : (t.status === 'pending'
                            ? '<i class="fa-solid fa-hourglass-half" style="font-size:9px"></i>'
                            : '<i class="fa-solid fa-circle-xmark" style="font-size:9px"></i>')}
                    ${statusLabel(t.status)}
                </span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-action btn-view" data-id="${t.id}" title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-action btn-more" data-id="${t.id}" title="Lebih Lanjut">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </div>
                </td>
            </tr>`).join('');
    }

    document.getElementById('pag-from').textContent  = total === 0 ? 0 : start + 1;
    document.getElementById('pag-to').textContent    = end;
    document.getElementById('pag-total').textContent = total;

    renderPagination(totalPages);
    updateSummaryCards();
}

/* ============================
   PAGINATION — window 3
============================ */
function renderPagination(totalPages) {
    const ctrl = document.getElementById('pagination-controls');
    const p    = state.page;

    // Hitung window 3 halaman
    let winStart = Math.max(1, p - Math.floor(PAGE_WINDOW / 2));
    let winEnd   = winStart + PAGE_WINDOW - 1;
    if (winEnd > totalPages) { winEnd = totalPages; winStart = Math.max(1, winEnd - PAGE_WINDOW + 1); }

    let html = `<button class="page-btn" id="page-prev" ${p<=1?'disabled':''}><i class="fa-solid fa-chevron-left"></i></button>`;

    // Halaman pertama + ellipsis kalau perlu
    if (winStart > 1) {
        html += `<button class="page-btn" data-page="1">1</button>`;
        if (winStart > 2) html += `<button class="page-btn page-ellipsis" disabled>…</button>`;
    }

    // Window inti
    for (let i = winStart; i <= winEnd; i++) {
        html += `<button class="page-btn ${i===p?'active':''}" data-page="${i}">${i}</button>`;
    }

    // Ellipsis + halaman terakhir
    if (winEnd < totalPages) {
        if (winEnd < totalPages - 1) html += `<button class="page-btn page-ellipsis" disabled>…</button>`;
        html += `<button class="page-btn" data-page="${totalPages}">${totalPages}</button>`;
    }

    html += `<button class="page-btn" id="page-next" ${p>=totalPages?'disabled':''}><i class="fa-solid fa-chevron-right"></i></button>`;
    ctrl.innerHTML = html;

    ctrl.querySelectorAll('.page-btn[data-page]').forEach(btn => {
        btn.addEventListener('click', () => { state.page = parseInt(btn.dataset.page); renderTable(); });
    });
    document.getElementById('page-prev')?.addEventListener('click', () => { state.page--; renderTable(); });
    document.getElementById('page-next')?.addEventListener('click', () => { state.page++; renderTable(); });
}

/* ============================
    SUMMARY CARDS
============================ */

function updateSummaryCards() {
    const all      = trxData;
    const selesai  = all.filter(t => t.status === 'selesai');
    const pending  = all.filter(t => t.status === 'pending');
    const batal    = all.filter(t => t.status === 'batal');
    document.getElementById('count-total').textContent   = all.length;
    document.getElementById('count-selesai').textContent = selesai.length;
    document.getElementById('count-pending').textContent = pending.length;
    // batal may not always exist in DOM for older pages — guard
    const elBatal = document.getElementById('count-batal');
    if (elBatal) elBatal.textContent = batal.length;
    const subS = document.getElementById('sub-selesai');
    const subP = document.getElementById('sub-pending');
    const subB = document.getElementById('sub-batal');
    if (subS) subS.textContent = fmtPrice(selesai.reduce((s,t) => s+t.total, 0));
    if (subP) subP.textContent = fmtPrice(pending.reduce((s,t) => s+t.total, 0));
    if (subB) subB.textContent = fmtPrice(batal.reduce((s,t) => s+t.total, 0));
}

/* ============================
   DROPDOWN (lebih lanjut) — fixed
============================ */
const dropdown = document.createElement('div');
dropdown.id = 'trxDropdown';
dropdown.className = 'dropdown-menu';
dropdown.innerHTML = `
    <button class="dropdown-item item-approve" data-dd="approve" style="display:none">
        <i class="fa-solid fa-circle-check"></i> Konfirmasi Selesai
    </button>
    <button class="dropdown-item item-print" data-dd="print">
        <i class="fa-solid fa-print"></i> Cetak Transaksi
    </button>
    <button class="dropdown-item item-cancel" data-dd="cancel">
        <i class="fa-solid fa-ban"></i> Batalkan Transaksi
    </button>
`;
document.body.appendChild(dropdown);

function openDropdown(btn, id) {
    if (state.activeDropdownId === id && dropdown.classList.contains('open')) {
        closeDropdown(); return;
    }
    state.activeDropdownId = id;
    const t = trxData.find(x => x.id === id);

    // Tampilkan "Konfirmasi Selesai" hanya untuk pending
    dropdown.querySelector('[data-dd="approve"]').style.display =
        t && t.status === 'pending' ? 'flex' : 'none';
    dropdown.querySelector('[data-dd="cancel"]').style.display =
        t && t.status !== 'batal' ? 'flex' : 'none';

    const rect  = btn.getBoundingClientRect();
    const menuW = 200;
    dropdown.style.top  = (rect.bottom + 6) + 'px';
    dropdown.style.left = (rect.right - menuW < 0 ? rect.left : rect.right - menuW) + 'px';
    dropdown.classList.add('open');
    btn.classList.add('open');
}

function closeDropdown() {
    dropdown.classList.remove('open');
    state.activeDropdownId = null;
    document.querySelectorAll('.btn-more.open').forEach(b => b.classList.remove('open'));
}

dropdown.addEventListener('click', e => {
    const item = e.target.closest('[data-dd]');
    if (!item || !state.activeDropdownId) return;
    const action = item.dataset.dd;
    const id     = state.activeDropdownId;
    closeDropdown();

    if (action === 'approve') doApprove(id);
    if (action === 'print')   doPrint(id);
    if (action === 'cancel')  doCancel(id);
});

document.addEventListener('click', e => {
    if (!dropdown.contains(e.target) && !e.target.closest('.btn-more')) closeDropdown();
});
window.addEventListener('scroll', () => closeDropdown(), true);

/* ============================
   AKSI
============================ */
function doApprove(id) {
    const idx = trxData.findIndex(x => x.id === id);
    if (idx === -1) return;
    trxData[idx].status = 'selesai';
    renderTable();
    showToast('Transaksi ' + trxData[idx].trxId + ' dikonfirmasi selesai.', 'success');
}

function doPrint(id) {
    const t = trxData.find(x => x.id === id);
    if (!t) return;
    const printWindow = window.open('', '_blank');
    if (!printWindow) {
        showToast('Popup cetak diblokir browser.', 'error');
        return;
    }

    printWindow.document.write(`
        <!doctype html>
        <html>
        <head>
            <title>Cetak ${t.trxId}</title>
            <style>
                body { font-family: Arial, sans-serif; color: #111827; padding: 32px; }
                h1 { font-size: 22px; margin: 0 0 6px; }
                .sub { color: #6b7280; margin-bottom: 24px; }
                table { width: 100%; border-collapse: collapse; }
                td { padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
                td:first-child { color: #6b7280; width: 190px; }
                .amount { font-size: 20px; font-weight: 700; }
            </style>
        </head>
        <body>
            <h1>Detail Transaksi</h1>
            <div class="sub">Sick Safe ON</div>
            <table>
                <tr><td>No. Transaksi</td><td>${t.trxId}</td></tr>
                <tr><td>Nama Pasien</td><td>${t.patientName} (${t.patientType})</td></tr>
                <tr><td>No. RM</td><td>${t.rm}</td></tr>
                <tr><td>Tipe Pembayaran</td><td>${typeLabel(t.type)}</td></tr>
                <tr><td>Status</td><td>${statusLabel(t.status)}</td></tr>
                <tr><td>Tanggal & Waktu</td><td>${fmtDate(t.date)} - ${t.time} WIB</td></tr>
                <tr><td>Total Pembayaran</td><td class="amount">${fmtPriceFull(t.total)}</td></tr>
            </table>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    showToast('Mencetak ' + t.trxId + '...', 'info');
}

function doCancel(id) {
    const t = trxData.find(x => x.id === id);
    if (!t) return;
    if (!confirm('Yakin ingin membatalkan transaksi ' + t.trxId + '?')) return;
    t.status = 'batal';
    renderTable();
    showToast('Transaksi ' + t.trxId + ' dibatalkan.', 'error');
}

/* ============================
   MODAL DETAIL
============================ */
function openDetail(id) {
    const t = trxData.find(x => x.id === id);
    if (!t) return;

    document.getElementById('modal-detail-body').innerHTML = `
        <div class="detail-grid">
            <div class="detail-item">
                <label>No. Transaksi</label>
                <span style="font-family:monospace">${t.trxId}</span>
            </div>
            <div class="detail-item full">
                <label>Nama Pasien</label>
                <span>${t.patientName} <span style="font-size:12px;font-weight:500;color:var(--text-muted)">(${t.patientType})</span></span>
            </div>
            <div class="detail-item">
                <label>Tipe Pembayaran</label>
                <span><span class="type-badge type-${t.type}">${typeLabel(t.type)}</span></span>
            </div>
            <div class="detail-item">
                <label>Status</label>
                <span><span class="status-badge status-${t.status}">
                    ${t.status === 'selesai'
                        ? '<i class="fa-solid fa-circle-check" style="font-size:9px"></i>'
                        : (t.status === 'pending'
                            ? '<i class="fa-solid fa-hourglass-half" style="font-size:9px"></i>'
                            : '<i class="fa-solid fa-circle-xmark" style="font-size:9px"></i>')}
                    ${statusLabel(t.status)}
                </span></span>
            </div>
            <div class="detail-item full">
                <label>Total Pembayaran</label>
                <span class="detail-amount">${fmtPriceFull(t.total)}</span>
            </div>
            <div class="detail-item full">
                <label>Tanggal &amp; Waktu</label>
                <span>${fmtDate(t.date)} — ${t.time} WIB</span>
            </div>
        </div>`;

    document.getElementById('modal-detail-print').onclick     = () => doPrint(t.id);
    document.getElementById('modal-detail-close').onclick     = () => closeModal();
    document.getElementById('modal-detail-close-btn').onclick = () => closeModal();
    showModal();
}

function showModal() {
    const m = document.getElementById('modal-detail');
    m.style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal-detail').style.display = 'none';
}

/* ============================
   TOAST
============================ */
function showToast(msg, type = 'info') {
    const container = document.getElementById('toast-container');
    const icons = { success:'fa-circle-check', error:'fa-circle-xmark', info:'fa-print' };
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<i class="fa-solid ${icons[type]||'fa-circle-info'}"></i> ${msg}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s, transform 0.3s';
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(20px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// selection checkboxes removed

/* ============================
   INIT
============================ */
document.addEventListener('DOMContentLoaded', () => {
    renderTable();

    // Search
    const searchInput = document.getElementById('search-input');
    const searchClear = document.getElementById('search-clear');

    searchInput.addEventListener('input', () => {
        state.search = searchInput.value;
        state.page   = 1;
        searchClear.style.display = state.search ? 'flex' : 'none';
        renderTable();
    });

    searchClear.addEventListener('click', () => {
        searchInput.value = '';
        state.search      = '';
        state.page        = 1;
        searchClear.style.display = 'none';
        renderTable();
        searchInput.focus();
    });

    // Card filters
    document.querySelectorAll('.filter-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.filter-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            state.cardFilter = card.dataset.filterStatus;
            state.page = 1;
            renderTable();
        });
    });

    // Dropdown filters
    document.getElementById('filter-type').addEventListener('change', function () {
        state.type = this.value; state.page = 1; renderTable();
    });
    document.getElementById('filter-status')?.addEventListener('change', function () {
        state.status = this.value; state.page = 1; renderTable();
    });

    // Table delegation
    document.getElementById('trx-tbody').addEventListener('click', e => {
        const btnView = e.target.closest('.btn-view');
        const btnMore = e.target.closest('.btn-more');
        if (btnView) openDetail(parseInt(btnView.dataset.id));
        if (btnMore) { e.stopPropagation(); openDropdown(btnMore, parseInt(btnMore.dataset.id)); }
    });

    // Modal backdrop
    document.getElementById('modal-detail').addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });
});
