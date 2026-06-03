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