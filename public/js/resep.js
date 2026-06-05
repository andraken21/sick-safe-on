document.addEventListener('DOMContentLoaded', function() {
    
    const resepDataEl = document.getElementById('resepData');
    const serverResep = resepDataEl
        ? JSON.parse(atob(resepDataEl.dataset.resep || 'W10='))
        : [];

    const staticResep = [
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

    const allResep = serverResep.length
        ? serverResep.map(resep => ({
            nomor: resep.nomor,
            tanggal: resep.tanggal,
            dokter: resep.dokter,
            obat: Number(resep.obat || resep.jumlah_obat || 0),
            total: Number(resep.total || 0),
            status: resep.status_key || resep.status || 'proses',
            icon: resep.icon || 'fa-file-prescription',
            iconClass: resep.iconClass || 'resep-icon-sm',
        }))
        : staticResep;

    const itemsPerPage = 5;
    let currentPage = 1;
    let filteredResep = [...allResep];

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
    function updateResepCount() {
        const badge = document.getElementById('resep-count');
        if (badge) {
            badge.textContent = `${filteredResep.length} Resep`;
        }
    }

    function getStatusLabel(status) {
        const labels = {
            'proses': 'Sedang Diproses',
            'tunggu': 'Menunggu Pembayaran',
            'selesai': 'Selesai',
            'batal': 'Dibatalkan'
        };
        return labels[status] || status;
    }

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
    renderTable();
});
