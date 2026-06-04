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