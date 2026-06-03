/**
 * manageMedicine.js
 * Kelola Data Obat — SickSafe ON
 *
 * Perubahan:
 * - Aksi tabel: hanya 2 tombol (Detail, Lebih Lanjut)
 * - Lebih Lanjut: context menu berisi Edit, Restock, Hapus
 * - Context menu posisi FIXED — tidak ikut scroll
 * - Modal Detail: hanya tombol Tutup (tidak ada tombol Edit)
 * - Nuansa warna oranye pastel
 */

/* ============================
   DATA DUMMY
============================ */
let medicineData = [
    { id: 1,  code: 'PAR-001', name: 'Paracetamol 500mg',    category: 'analgesik',   stock: 45,  min: 100, price: 2500,  supplier: 'PT Dexa Medica',  exp: '2026-12-15', status: 'rendah'  },
    { id: 2,  code: 'AMX-001', name: 'Amoxicillin 500mg',    category: 'antibiotik',  stock: 32,  min: 100, price: 8500,  supplier: 'PT Kimia Farma',  exp: '2026-11-22', status: 'menipis' },
    { id: 3,  code: 'CTM-001', name: 'CTM 4mg',              category: 'antihistamin',stock: 20,  min: 50,  price: 1200,  supplier: 'PT Fahrenheit',   exp: '2026-10-10', status: 'menipis' },
    { id: 4,  code: 'VIT-001', name: 'Vitamin C 500mg',      category: 'vitamin',     stock: 250, min: 100, price: 3500,  supplier: 'PT Bayer',        exp: '2027-01-05', status: 'aman'    },
    { id: 5,  code: 'IBU-001', name: 'Ibuprofen 200mg',      category: 'analgesik',   stock: 0,   min: 75,  price: 4500,  supplier: 'PT Mepro',        exp: '2026-09-20', status: 'habis'   },
    { id: 6,  code: 'KLR-001', name: 'Kalium Klorida 250mg', category: 'vitamin',     stock: 120, min: 100, price: 5000,  supplier: 'PT Sanbe Farma',  exp: '2026-08-08', status: 'aman'    },
    { id: 7,  code: 'DXM-001', name: 'Dexamethasone 0.5mg',  category: 'analgesik',   stock: 0,   min: 50,  price: 3200,  supplier: 'PT Dexa Medica',  exp: '2026-07-30', status: 'habis'   },
    { id: 8,  code: 'ANT-001', name: 'Antasida DOEN',        category: 'antihistamin',stock: 180, min: 80,  price: 1800,  supplier: 'PT Kimia Farma',  exp: '2027-03-15', status: 'aman'    },
    { id: 9,  code: 'CIP-001', name: 'Ciprofloxacin 500mg',  category: 'antibiotik',  stock: 15,  min: 60,  price: 12000, supplier: 'PT Sanbe Farma',  exp: '2026-12-01', status: 'menipis' },
    { id: 10, code: 'VTD-001', name: 'Vitamin D3 1000IU',    category: 'vitamin',     stock: 300, min: 100, price: 6000,  supplier: 'PT Bayer',        exp: '2027-06-20', status: 'aman'    },
    { id: 11, code: 'MET-001', name: 'Metformin 500mg',      category: 'analgesik',   stock: 55,  min: 80,  price: 4000,  supplier: 'PT Mepro',        exp: '2026-11-10', status: 'rendah'  },
    { id: 12, code: 'LOR-001', name: 'Loratadine 10mg',      category: 'antihistamin',stock: 0,   min: 60,  price: 5500,  supplier: 'PT Fahrenheit',   exp: '2027-02-28', status: 'habis'   },
];

/* ============================
   STATE
============================ */
const ROWS_PER_PAGE = 6;
let state = { search: '', cardFilter: 'all', category: '', status: '', page: 1, contextTargetId: null };

/* ============================
   HELPERS
============================ */
function fmtPrice(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

function fmtDate(iso) {
    const d = new Date(iso);
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    return `${String(d.getDate()).padStart(2,'0')} ${months[d.getMonth()]} ${d.getFullYear()}`;
}

function isNearExpiry(iso) {
    const diff = (new Date(iso) - new Date()) / (1000 * 60 * 60 * 24);
    return diff <= 90 && diff > 0;
}

function isExpired(iso) { return new Date(iso) < new Date(); }

function statusLabel(s) {
    return { aman: '✓ Aman', rendah: '⚠ Rendah', menipis: '⚠ Menipis', habis: '✗ Habis' }[s] || s;
}

function categoryLabel(c) {
    return { analgesik: 'Analgesik', antibiotik: 'Antibiotik', antihistamin: 'Antihistamin', vitamin: 'Vitamin' }[c] || c;
}

function computeStatus(m) {
    if (m.stock === 0) return 'habis';
    const ratio = m.stock / m.min;
    if (ratio < 0.3) return 'menipis';
    if (ratio < 0.7) return 'rendah';
    return 'aman';
}

/* ============================
   FILTER
============================ */
function getFiltered() {
    const q = state.search.toLowerCase();
    return medicineData.filter(m => {
        const matchSearch = !q || m.name.toLowerCase().includes(q) || m.code.toLowerCase().includes(q) || m.supplier.toLowerCase().includes(q);
        let matchCard = true;
        if (state.cardFilter === 'rendah')  matchCard = m.status === 'rendah' || m.status === 'menipis';
        if (state.cardFilter === 'habis')   matchCard = m.status === 'habis';
        if (state.cardFilter === 'expired') matchCard = isNearExpiry(m.exp) || isExpired(m.exp);
        const matchCat    = !state.category || m.category === state.category;
        const matchStatus = !state.status   || m.status   === state.status;
        return matchSearch && matchCard && matchCat && matchStatus;
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

    const tbody      = document.getElementById('medicine-tbody');
    const emptyState = document.getElementById('empty-state');

    if (pageData.length === 0) {
        tbody.innerHTML = '';
        emptyState.style.display = 'block';
    } else {
        emptyState.style.display = 'none';
        tbody.innerHTML = pageData.map(m => {
            const expLabel = isExpired(m.exp)
                ? `<span style="color:#c2185b;font-weight:700;">${fmtDate(m.exp)}</span>`
                : isNearExpiry(m.exp)
                ? `<span style="color:#C2540A;font-weight:700;">${fmtDate(m.exp)}</span>`
                : fmtDate(m.exp);

            return `
            <tr data-id="${m.id}">
                <td style="text-align:center;"><input type="checkbox" class="check-row"></td>
                <td>
                    <div class="med-cell">
                        <div class="med-code">${m.code}</div>
                        <div class="med-name">${m.name}</div>
                    </div>
                </td>
                <td style="text-align:center;">
                    <span class="category-badge cat-${m.category}">${categoryLabel(m.category)}</span>
                </td>
                <td class="stock-cell ${m.stock === 0 ? 'stock-zero' : ''}">${m.stock}</td>
                <td class="min-cell">${m.min}</td>
                <td class="price-cell">${fmtPrice(m.price)}</td>
                <td style="font-size:13px;">${m.supplier}</td>
                <td style="font-size:13px; text-align:center;">${expLabel}</td>
                <td style="text-align:center;">
                    <span class="status-badge status-${m.status}">${statusLabel(m.status)}</span>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-action btn-view" data-id="${m.id}" title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-action btn-more" data-id="${m.id}" title="Lebih Lanjut">
                            <i class="fa-solid fa-ellipsis-v"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    document.getElementById('pag-from').textContent  = total === 0 ? 0 : start + 1;
    document.getElementById('pag-to').textContent    = end;
    document.getElementById('pag-total').textContent = total;

    renderPagination(totalPages);
    updateSummaryCards();
}

/* ============================
   RENDER PAGINATION
============================ */
function renderPagination(totalPages) {
    const ctrl = document.getElementById('pagination-controls');
    let html = `<button class="page-btn" id="page-prev" ${state.page<=1?'disabled':''}><i class="fa-solid fa-chevron-left"></i></button>`;

    const pages = [];
    if (totalPages <= 7) { for (let i=1; i<=totalPages; i++) pages.push(i); }
    else {
        pages.push(1);
        if (state.page > 3) pages.push('...');
        for (let i=Math.max(2,state.page-1); i<=Math.min(totalPages-1,state.page+1); i++) pages.push(i);
        if (state.page < totalPages-2) pages.push('...');
        pages.push(totalPages);
    }

    pages.forEach(p => {
        if (p === '...') html += `<button class="page-btn page-ellipsis" disabled>...</button>`;
        else html += `<button class="page-btn ${p===state.page?'active':''}" data-page="${p}">${p}</button>`;
    });

    html += `<button class="page-btn" id="page-next" ${state.page>=totalPages?'disabled':''}><i class="fa-solid fa-chevron-right"></i></button>`;
    ctrl.innerHTML = html;

    ctrl.querySelectorAll('.page-btn[data-page]').forEach(btn => {
        btn.addEventListener('click', () => { state.page = parseInt(btn.dataset.page); renderTable(); });
    });

    const prev = document.getElementById('page-prev');
    const next = document.getElementById('page-next');
    if (prev) prev.addEventListener('click', () => { state.page--; renderTable(); });
    if (next) next.addEventListener('click', () => { state.page++; renderTable(); });
}

/* ============================
   UPDATE SUMMARY CARDS
============================ */
function updateSummaryCards() {
    document.getElementById('count-total').textContent   = medicineData.length;
    document.getElementById('count-rendah').textContent  = medicineData.filter(m => m.status === 'rendah' || m.status === 'menipis').length;
    document.getElementById('count-habis').textContent   = medicineData.filter(m => m.status === 'habis').length;
    document.getElementById('count-expired').textContent = medicineData.filter(m => isNearExpiry(m.exp) || isExpired(m.exp)).length;
}

/* ============================
   MODAL DETAIL — hanya tombol Tutup
============================ */
function openDetail(id) {
    const m = medicineData.find(x => x.id === id);
    if (!m) return;

    document.getElementById('modal-detail-body').innerHTML = `
        <div class="detail-grid">
            <div class="detail-item">
                <label>Kode Obat</label>
                <span>${m.code}</span>
            </div>
            <div class="detail-item">
                <label>Kategori</label>
                <span><span class="category-badge cat-${m.category}">${categoryLabel(m.category)}</span></span>
            </div>
            <div class="detail-item full">
                <label>Nama Obat</label>
                <span>${m.name}</span>
            </div>
            <div class="detail-item">
                <label>Stok Saat Ini</label>
                <span style="color:${m.stock===0?'#c2185b':'var(--navy)'};">${m.stock} unit</span>
            </div>
            <div class="detail-item">
                <label>Stok Minimum</label>
                <span>${m.min} unit</span>
            </div>
            <div class="detail-item">
                <label>Harga Satuan</label>
                <span style="color:var(--or-dark);">${fmtPrice(m.price)}</span>
            </div>
            <div class="detail-item">
                <label>Status</label>
                <span><span class="status-badge status-${m.status}">${statusLabel(m.status)}</span></span>
            </div>
            <div class="detail-item full">
                <label>Supplier</label>
                <span>${m.supplier}</span>
            </div>
            <div class="detail-item">
                <label>Tanggal Kadaluarsa</label>
                <span>${fmtDate(m.exp)}</span>
            </div>
        </div>`;

    document.getElementById('modal-detail-close').onclick    = () => closeModal('modal-detail');
    document.getElementById('modal-detail-close-btn').onclick = () => closeModal('modal-detail');
    showModal('modal-detail');
}

/* ============================
   MODAL EDIT
============================ */
function openEdit(id) {
    const m = medicineData.find(x => x.id === id);
    if (!m) return;

    document.getElementById('modal-edit-body').innerHTML = `
        <div class="form-row">
            <div class="form-group">
                <label>Kode Obat</label>
                <input class="form-control" value="${m.code}" readonly style="background:var(--white-ish);color:var(--text-muted);">
            </div>
            <div class="form-group">
                <label>Kategori <span class="req">*</span></label>
                <select class="form-control" id="edit-category">
                    <option value="analgesik"    ${m.category==='analgesik'?'selected':''}>Analgesik</option>
                    <option value="antibiotik"   ${m.category==='antibiotik'?'selected':''}>Antibiotik</option>
                    <option value="antihistamin" ${m.category==='antihistamin'?'selected':''}>Antihistamin</option>
                    <option value="vitamin"      ${m.category==='vitamin'?'selected':''}>Vitamin</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Nama Obat <span class="req">*</span></label>
            <input class="form-control" id="edit-name" value="${m.name}">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Stok Saat Ini <span class="req">*</span></label>
                <input class="form-control" id="edit-stock" type="number" min="0" value="${m.stock}">
            </div>
            <div class="form-group">
                <label>Stok Minimum <span class="req">*</span></label>
                <input class="form-control" id="edit-min" type="number" min="0" value="${m.min}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Harga Satuan (Rp) <span class="req">*</span></label>
                <input class="form-control" id="edit-price" type="number" min="0" value="${m.price}">
            </div>
            <div class="form-group">
                <label>Tanggal Kadaluarsa <span class="req">*</span></label>
                <input class="form-control" id="edit-exp" type="date" value="${m.exp}">
            </div>
        </div>
        <div class="form-group">
            <label>Supplier <span class="req">*</span></label>
            <input class="form-control" id="edit-supplier" value="${m.supplier}">
        </div>`;

    document.getElementById('modal-edit-cancel').onclick = () => closeModal('modal-edit');
    document.getElementById('modal-edit-close').onclick  = () => closeModal('modal-edit');

    document.getElementById('modal-edit-save').onclick = () => {
        const name     = document.getElementById('edit-name').value.trim();
        const category = document.getElementById('edit-category').value;
        const stock    = parseInt(document.getElementById('edit-stock').value);
        const min      = parseInt(document.getElementById('edit-min').value);
        const price    = parseInt(document.getElementById('edit-price').value);
        const exp      = document.getElementById('edit-exp').value;
        const supplier = document.getElementById('edit-supplier').value.trim();

        if (!name || !supplier || isNaN(stock) || isNaN(min) || isNaN(price) || !exp) {
            showToast('Semua field wajib diisi!', 'error');
            return;
        }

        const idx = medicineData.findIndex(x => x.id === id);
        medicineData[idx] = { ...medicineData[idx], name, category, stock, min, price, exp, supplier };
        medicineData[idx].status = computeStatus(medicineData[idx]);

        closeModal('modal-edit');
        renderTable();
        showToast(`Data "${name}" berhasil diperbarui.`, 'success');
    };

    showModal('modal-edit');
}

/* ============================
   CONTEXT MENU — posisi fixed berdasarkan viewport
   Isi: Edit, Restock, Hapus
============================ */
function openContextMenu(id, btn) {
    state.contextTargetId = id;
    const menu = document.getElementById('context-menu');

    // Tampilkan dulu agar bisa ukur dimensinya
    menu.style.display = 'block';
    menu.style.top  = '-9999px';
    menu.style.left = '-9999px';

    const rect      = btn.getBoundingClientRect();  // posisi relatif viewport
    const menuH     = menu.offsetHeight;
    const menuW     = menu.offsetWidth;
    const vpH       = window.innerHeight;
    const vpW       = window.innerWidth;

    // Tentukan posisi: default di bawah tombol, geser ke atas kalau mepet bawah
    let top  = rect.bottom + 4;
    let left = rect.right - menuW;

    if (top + menuH > vpH - 8) top = rect.top - menuH - 4;
    if (left < 8) left = 8;
    if (left + menuW > vpW - 8) left = vpW - menuW - 8;

    menu.style.top  = top  + 'px';
    menu.style.left = left + 'px';
}

function closeContextMenu() {
    document.getElementById('context-menu').style.display = 'none';
    state.contextTargetId = null;
}

/* ============================
   RESTOCK
============================ */
function doRestock(id) {
    const m = medicineData.find(x => x.id === id);
    if (!m) return;
    const added = parseInt(prompt(`Tambah stok untuk "${m.name}"\nMasukkan jumlah yang ditambahkan:`, 50));
    if (isNaN(added) || added <= 0) { showToast('Jumlah tidak valid.', 'error'); return; }
    const idx = medicineData.findIndex(x => x.id === id);
    medicineData[idx].stock  += added;
    medicineData[idx].status  = computeStatus(medicineData[idx]);
    renderTable();
    showToast(`Stok "${m.name}" ditambah ${added} unit. Total: ${medicineData[idx].stock}`, 'success');
}

/* ============================
   DELETE
============================ */
function doDelete(id) {
    const m = medicineData.find(x => x.id === id);
    if (!m) return;
    if (!confirm(`Yakin ingin menghapus obat "${m.name}"?\nTindakan ini tidak dapat dibatalkan.`)) return;
    medicineData = medicineData.filter(x => x.id !== id);
    if (state.page > Math.ceil(medicineData.length / ROWS_PER_PAGE))
        state.page = Math.max(1, Math.ceil(medicineData.length / ROWS_PER_PAGE));
    renderTable();
    showToast(`Obat "${m.name}" berhasil dihapus.`, 'success');
}

/* ============================
   MODAL & TOAST HELPERS
============================ */
function showModal(id) { document.getElementById(id).style.display = 'flex'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }

function showToast(msg, type = 'info') {
    const container = document.getElementById('toast-container');
    const icons = { success: 'fa-circle-check', error: 'fa-circle-xmark', info: 'fa-circle-info' };
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<i class="fa-solid ${icons[type]||icons.info}"></i> ${msg}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/* ============================
   CHECK-ALL
============================ */
function bindCheckAll() {
    const ca = document.getElementById('check-all');
    if (!ca) return;
    ca.addEventListener('change', function () {
        document.querySelectorAll('.check-row').forEach(cb => cb.checked = this.checked);
    });
}

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
        state.search = '';
        state.page   = 1;
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

    // Dropdowns
    document.getElementById('filter-category').addEventListener('change', function () {
        state.category = this.value; state.page = 1; renderTable();
    });
    document.getElementById('filter-status').addEventListener('change', function () {
        state.status = this.value; state.page = 1; renderTable();
    });

    // Table delegation — hanya btn-view dan btn-more
    document.getElementById('medicine-tbody').addEventListener('click', e => {
        const btnView = e.target.closest('.btn-view');
        const btnMore = e.target.closest('.btn-more');

        if (btnView) openDetail(parseInt(btnView.dataset.id));
        if (btnMore) { e.stopPropagation(); openContextMenu(parseInt(btnMore.dataset.id), btnMore); }
    });

    // Context menu: Edit, Restock, Hapus
    document.getElementById('ctx-edit').addEventListener('click', () => {
        const id = state.contextTargetId;
        closeContextMenu();
        if (id) openEdit(id);
    });

    document.getElementById('ctx-restock').addEventListener('click', () => {
        const id = state.contextTargetId;
        closeContextMenu();
        if (id) doRestock(id);
    });

    document.getElementById('ctx-delete').addEventListener('click', () => {
        const id = state.contextTargetId;
        closeContextMenu();
        if (id) doDelete(id);
    });

    // Tutup context menu saat klik di luar
    document.addEventListener('click', () => closeContextMenu());

    // Tutup modals saat klik overlay
    ['modal-detail', 'modal-edit'].forEach(id => {
        document.getElementById(id).addEventListener('click', function (e) {
            if (e.target === this) closeModal(id);
        });
    });

    // Check-all
    bindCheckAll();
    new MutationObserver(bindCheckAll).observe(document.getElementById('medicine-tbody'), { childList: true });
});