/**
 * pembayaran.js
 * PENTING: File ini adalah JS murni — TIDAK ada Blade/PHP syntax di sini.
 * Semua nilai dari server dibaca dari atribut data-* pada elemen HTML.
 */
document.addEventListener('DOMContentLoaded', function () {

    // ── Data transaksi (statis, nanti bisa diganti fetch dari API) ───────────
    const allTransactions = [
        { id: 'INV-2026-0077', date: '08 Des 2026', ref: 'RSP-0051', metode: 'BPJS',    total: 87500,  status: 'menunggu', icon: 'fa-clock',    iconClass: 'inv-icon--pend' },
        { id: 'INV-2026-0070', date: '20 Nov 2026', ref: 'RSP-0048', metode: 'BPJS',    total: 85000,  status: 'lunas',    icon: 'fa-check',    iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0065', date: '10 Nov 2026', ref: 'RSP-0045', metode: 'Mandiri', total: 210000, status: 'lunas',    icon: 'fa-check',    iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0058', date: '02 Nov 2026', ref: 'RSP-0040', metode: 'Mandiri', total: 0,      status: 'gagal',    icon: 'fa-times',    iconClass: 'inv-icon--fail' },
        { id: 'INV-2026-0050', date: '15 Okt 2026', ref: 'RSP-0038', metode: 'BPJS',    total: 125000, status: 'lunas',    icon: 'fa-check',    iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0045', date: '05 Okt 2026', ref: 'RSP-0035', metode: 'Mandiri', total: 92500,  status: 'lunas',    icon: 'fa-check',    iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0040', date: '25 Sep 2026', ref: 'RSP-0032', metode: 'BPJS',    total: 67000,  status: 'lunas',    icon: 'fa-check',    iconClass: 'inv-icon--done' },
        { id: 'INV-2026-0035', date: '15 Sep 2026', ref: 'RSP-0028', metode: 'Mandiri', total: 156000, status: 'proses',   icon: 'fa-sync-alt', iconClass: 'inv-icon--proc' },
        { id: 'INV-2026-0030', date: '05 Sep 2026', ref: 'RSP-0025', metode: 'BPJS',    total: 94500,  status: 'lunas',    icon: 'fa-check',    iconClass: 'inv-icon--done' }
    ];

    // ── Baca konfigurasi dari DOM (ditetapkan oleh Blade via data-*) ─────────
    const tagihanEl   = document.getElementById('tagihanData');
    const btnBayar    = document.getElementById('btnBayarSekarang');
    const btnInfo     = document.getElementById('btnBayarInfo');

    // URL dari data-* (diisi Blade, bukan hardcode di JS)
    const bayarBaseUrl = tagihanEl ? tagihanEl.dataset.bayarUrl  : '#';
    const prosesUrl    = tagihanEl ? tagihanEl.dataset.prosesUrl : '/pasien/pembayaran/proses';

    // Data tagihan aktif
    const subtotalObat  = tagihanEl ? parseInt(tagihanEl.dataset.subtotal    || 0) : 0;
    const biayaLayanan  = tagihanEl ? parseInt(tagihanEl.dataset.layanan     || 0) : 0;
    const totalNormal   = tagihanEl ? parseInt(tagihanEl.dataset.totalNormal || 0) : 0;
    const invoiceId     = tagihanEl ? tagihanEl.dataset.invoice  : '';
    const statusTagihan = tagihanEl ? tagihanEl.dataset.status   : '';

    let selectedMetode = 'BPJS'; // default metode aktif

    // ── Helpers ──────────────────────────────────────────────────────────────
    const fmt = (n) => 'Rp ' + n.toLocaleString('id-ID');

    function getStatusLabel(status) {
        const map = { lunas: 'Lunas', menunggu: 'Menunggu', gagal: 'Gagal', proses: 'Diproses' };
        return map[status] || status;
    }

    // ── Update kalkulasi tagihan aktif ────────────────────────────────────────
    function updateTagihan(metode) {
        const isBpjs   = metode === 'BPJS';
        const diskon   = isBpjs ? (subtotalObat + biayaLayanan) : 0;
        const total    = (subtotalObat + biayaLayanan) - diskon;

        const elSubtotal  = document.getElementById('tagihanSubtotal');
        const elLayanan   = document.getElementById('tagihanLayanan');
        const elDiskon    = document.getElementById('tagihanDiskon');
        const elDiskonLbl = document.getElementById('tagihanDiskonLbl');
        const elDiskonRow = document.getElementById('tagihanDiskonRow');
        const elTotal     = document.getElementById('tagihanTotal');

        if (elSubtotal)  elSubtotal.textContent  = fmt(subtotalObat);
        if (elLayanan)   elLayanan.textContent   = fmt(biayaLayanan);

        if (elDiskonRow) {
            if (isBpjs) {
                elDiskonRow.style.display = '';
                if (elDiskonLbl) elDiskonLbl.textContent = 'Diskon BPJS';
                if (elDiskon)    elDiskon.textContent    = '– ' + fmt(diskon);
            } else {
                elDiskonRow.style.display = 'none';
            }
        }

        if (elTotal) {
            elTotal.textContent = fmt(total);
            elTotal.style.color = isBpjs ? 'var(--ss-success)' : '';
        }

        // Update href tombol Bayar Sekarang
        if (btnBayar) {
            if (statusTagihan === 'menunggu') {
                // FIX: URL dibangun dari data-bayar-url (bukan hardcode)
                btnBayar.href           = bayarBaseUrl + '?metode=' + encodeURIComponent(metode);
                btnBayar.style.opacity  = '1';
                btnBayar.style.pointerEvents = 'auto';
                if (btnInfo) btnInfo.style.display = 'none';
            } else {
                btnBayar.href           = '#';
                btnBayar.style.opacity  = '0.45';
                btnBayar.style.pointerEvents = 'none';
                if (btnInfo) {
                    btnInfo.style.display  = 'block';
                    btnInfo.textContent    = 'Menunggu konfirmasi apoteker sebelum dapat dibayar';
                }
            }
        }
    }

    // ── Pilih metode pembayaran ───────────────────────────────────────────────
    const metodeItems = document.querySelectorAll('.metode-item');
    metodeItems.forEach(item => {
        item.addEventListener('click', function () {
            metodeItems.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            selectedMetode = this.dataset.metode || 'BPJS';
            updateTagihan(selectedMetode);
        });
    });

    // Init
    updateTagihan(selectedMetode);

    // ── Tabel & Pagination ───────────────────────────────────────────────────
    const itemsPerPage = 5;
    let currentPage    = 1;
    let filtered       = [...allTransactions];

    const statusSelect = document.querySelectorAll('.filter-select')[0];
    const metodeSelect = document.querySelectorAll('.filter-select')[1];
    const searchInput  = document.querySelector('.search-wrap input');

    function applyFilters() {
        const selStatus = statusSelect ? statusSelect.value : 'Semua Status';
        const selMetode = metodeSelect ? metodeSelect.value : 'Semua Metode';
        const query     = searchInput  ? searchInput.value.toLowerCase() : '';

        filtered = allTransactions.filter(t => {
            const matchStatus = selStatus === 'Semua Status' || t.status  === selStatus;
            const matchMetode = selMetode === 'Semua Metode' || t.metode  === selMetode;
            const matchSearch = !query || t.id.toLowerCase().includes(query) || t.ref.toLowerCase().includes(query);
            return matchStatus && matchMetode && matchSearch;
        });
        currentPage = 1;
        renderTable();
    }

    function renderTable() {
        const tbody = document.querySelector('.bayar-table tbody');
        if (!tbody) return;

        const start     = (currentPage - 1) * itemsPerPage;
        const pageItems = filtered.slice(start, start + itemsPerPage);

        tbody.innerHTML = pageItems.map(t => `
            <tr>
                <td>
                    <div class="inv-cell">
                        <div class="inv-icon ${t.iconClass}"><i class="fas ${t.icon}"></i></div>
                        <div>
                            <div class="inv-no">${t.id}</div>
                            <div class="inv-date">${t.date} • ${t.ref}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="metode-cell">
                        <span class="metode-dot metode-dot--${t.metode.toLowerCase()}"></span> ${t.metode}
                    </div>
                </td>
                <td><span class="total-cell">${t.total > 0 ? 'Rp ' + t.total.toLocaleString('id-ID') : '-'}</span></td>
                <td><span class="badge badge--${t.status}">${getStatusLabel(t.status)}</span></td>
            </tr>
        `).join('');

        renderPagination();
    }

    function renderPagination() {
        const totalPages    = Math.ceil(filtered.length / itemsPerPage);
        const infoEl        = document.querySelector('.pagination-info');
        const btnsEl        = document.querySelector('.pagination-btns');

        if (infoEl) {
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end   = Math.min(currentPage * itemsPerPage, filtered.length);
            infoEl.textContent = filtered.length
                ? `Menampilkan ${start}–${end} dari ${filtered.length} transaksi`
                : 'Tidak ada transaksi ditemukan';
        }

        if (!btnsEl) return;
        btnsEl.innerHTML = '';

        const mkBtn = (label, page, disabled = false) => {
            const b = document.createElement('button');
            b.className  = 'pg-btn' + (page === currentPage ? ' active' : '');
            b.innerHTML  = label;
            b.disabled   = disabled;
            b.addEventListener('click', (e) => { e.preventDefault(); currentPage = page; renderTable(); });
            return b;
        };

        btnsEl.appendChild(mkBtn('‹', currentPage - 1, currentPage === 1));
        for (let i = 1; i <= totalPages; i++) btnsEl.appendChild(mkBtn(i, i));
        btnsEl.appendChild(mkBtn('›', currentPage + 1, currentPage === totalPages));
    }

    if (statusSelect) statusSelect.addEventListener('change', applyFilters);
    if (metodeSelect) metodeSelect.addEventListener('change', applyFilters);
    if (searchInput)  searchInput.addEventListener('keyup',   applyFilters);

    renderTable();

    // ── Modal ────────────────────────────────────────────────────────────────
    const modal          = document.getElementById('modalPayment');
    const modalProcessing= document.getElementById('modalProcessing');
    const modalSuccess   = document.getElementById('modalSuccess');
    const btnKonfirmasi  = document.getElementById('btnKonfirmasi');
    const panelBpjs      = document.getElementById('panelBpjs');
    const panelMandiri   = document.getElementById('panelMandiri');
    const barcodeRef     = document.getElementById('barcodeRef');

    function genRef() {
        return 'MDR-' + Date.now().toString().slice(-8) + '-' +
               Math.random().toString(36).substring(2, 8).toUpperCase();
    }

    function resetModal() {
        document.getElementById('modalInvoice').style.display = '';
        [panelBpjs, panelMandiri, modalProcessing, modalSuccess].forEach(el => {
            if (el) el.classList.remove('show');
        });
        if (btnKonfirmasi) {
            btnKonfirmasi.style.display = '';
            btnKonfirmasi.disabled      = false;
            btnKonfirmasi.textContent   = 'Konfirmasi Bayar';
        }
    }

    function closeModal() {
        if (modal) modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (document.getElementById('modalCloseBtn')) {
        document.getElementById('modalCloseBtn').addEventListener('click', closeModal);
    }
    if (modal) {
        modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    if (btnKonfirmasi) {
        btnKonfirmasi.addEventListener('click', async function () {
            btnKonfirmasi.disabled = true;
            document.getElementById('modalInvoice').style.display = 'none';
            if (panelBpjs)    panelBpjs.classList.remove('show');
            if (panelMandiri) panelMandiri.classList.remove('show');
            btnKonfirmasi.style.display = 'none';
            if (modalProcessing) modalProcessing.classList.add('show');

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const res  = await fetch(prosesUrl, {
                    method : 'POST',
                    headers: {
                        'Content-Type'    : 'application/json',
                        'Accept'          : 'application/json',
                        'X-CSRF-TOKEN'    : csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        invoice_id : invoiceId,
                        metode     : selectedMetode,
                        total_bayar: selectedMetode === 'BPJS' ? 0 : totalNormal,
                    }),
                });

                const data = await res.json();
                if (modalProcessing) modalProcessing.classList.remove('show');

                if (data.success) {
                    const subEl = modalSuccess?.querySelector('.sub');
                    if (subEl) subEl.textContent = `Ref: ${data.kode_ref || '-'} • ${data.waktu || ''}`;
                    if (modalSuccess) modalSuccess.classList.add('show');
                    setTimeout(closeModal, 3000);
                } else {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    resetModal();
                    if (selectedMetode === 'BPJS' && panelBpjs)    panelBpjs.classList.add('show');
                    else if (panelMandiri) panelMandiri.classList.add('show');
                }
            } catch (err) {
                console.error('Bayar error:', err);
                if (modalProcessing) modalProcessing.classList.remove('show');
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
                resetModal();
            }
        });
    }

});