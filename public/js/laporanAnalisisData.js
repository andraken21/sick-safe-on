/* ============================
   reportsAnalytics.js
   Laporan Analisis Data — SickSafe ON
============================ */

/* ============================
   DATA
============================ */
const reportsData = [
    {
        id: 1,
        icon: 'fa-file-pdf',
        iconColor: '#3FBBA0',
        name: 'Laporan Transaksi Mei 2026',
        date: 'Dibuat: 15 Mei 2026',
        meta: '847 transaksi',
        format: 'PDF',
        type: 'transaksi',
        period: 'Mei 2026',
    },
    {
        id: 2,
        icon: 'fa-file-excel',
        iconColor: '#00a86b',
        name: 'Laporan Stok Obat Bulan Mei',
        date: 'Dibuat: 14 Mei 2026',
        meta: '156 item obat',
        format: 'Excel',
        type: 'obat',
        period: 'Mei 2026',
    },
    {
        id: 3,
        icon: 'fa-chart-column',
        iconColor: '#004369',
        name: 'Analisis Kinerja Staf Q1 2026',
        date: 'Dibuat: 10 Mei 2026',
        meta: '25 staf',
        format: 'PDF',
        type: 'kinerja',
        period: 'Q1 2026',
        dataLines: [
            '1. Dr. Anita – 97% kepuasan pasien – 42 pasien per minggu',
            '2. Dr. Budi – 92% kepuasan pasien – 38 pasien per minggu',
            '3. Dr. Citra – 89% kepuasan pasien – 34 pasien per minggu',
        ],
        summary: 'Laporan kinerja staf Q1 2026 dengan tingkat kepuasan pasien dan jumlah kunjungan per staf.',
    },
];

const reportSources = {
    transaksi: [
        { trxId:'TRX-2026-0847', patientName:'Andi Setiawan', patientType:'Pasien Umum', rm:'RM-02456', jenis:'BPJS', total:125000, date:'15 Mei 2026', status:'Selesai' },
        { trxId:'TRX-2026-0846', patientName:'Dewi Kusuma', patientType:'Pasien BPJS', rm:'RM-01298', jenis:'Mandiri', total:85000, date:'15 Mei 2026', status:'Selesai' },
        { trxId:'TRX-2026-0845', patientName:'Bambang Sutrisno', patientType:'Pasien Umum', rm:'RM-03121', jenis:'BPJS', total:210000, date:'15 Mei 2026', status:'Pending' },
        { trxId:'TRX-2026-0844', patientName:'Lina Maulida', patientType:'Pasien BPJS', rm:'RM-02897', jenis:'Mandiri', total:55000, date:'15 Mei 2026', status:'Selesai' },
        { trxId:'TRX-2026-0843', patientName:'Hendra Gunawan', patientType:'Pasien Umum', rm:'RM-01567', jenis:'BPJS', total:320000, date:'14 Mei 2026', status:'Pending' },
        { trxId:'TRX-2026-0842', patientName:'Maya Safitri', patientType:'Pasien BPJS', rm:'RM-02345', jenis:'Mandiri', total:175000, date:'14 Mei 2026', status:'Selesai' },
        { trxId:'TRX-2026-0841', patientName:'Rudi Hartono', patientType:'Pasien Umum', rm:'RM-04001', jenis:'BPJS', total:90000, date:'13 Mei 2026', status:'Selesai' },
        { trxId:'TRX-2026-0840', patientName:'Sari Wulandari', patientType:'Pasien BPJS', rm:'RM-03890', jenis:'Mandiri', total:450000, date:'13 Mei 2026', status:'Pending' },
        { trxId:'TRX-2026-0839', patientName:'Budi Santoso', patientType:'Pasien Umum', rm:'RM-02110', jenis:'BPJS', total:65000, date:'12 Mei 2026', status:'Selesai' },
        { trxId:'TRX-2026-0838', patientName:'Fitri Amalia', patientType:'Pasien BPJS', rm:'RM-01750', jenis:'Mandiri', total:230000, date:'12 Mei 2026', status:'Selesai' },
        { trxId:'TRX-2026-0837', patientName:'Agus Priyanto', patientType:'Pasien Umum', rm:'RM-03342', jenis:'BPJS', total:185000, date:'11 Mei 2026', status:'Pending' },
        { trxId:'TRX-2026-0836', patientName:'Nita Rahayu', patientType:'Pasien BPJS', rm:'RM-02678', jenis:'Mandiri', total:310000, date:'11 Mei 2026', status:'Selesai' },
    ],
    pasien: [
        { name:'Andi Setiawan', jenis:'Umum', umur:39, rm:'RM-02456' },
        { name:'Dewi Kusuma', jenis:'BPJS', umur:27, rm:'RM-01298' },
        { name:'Bambang Sutrisno', jenis:'Umum', umur:45, rm:'RM-03121' },
        { name:'Lina Maulida', jenis:'BPJS', umur:32, rm:'RM-02897' },
        { name:'Hendra Gunawan', jenis:'Umum', umur:51, rm:'RM-01567' },
        { name:'Maya Safitri', jenis:'BPJS', umur:29, rm:'RM-02345' },
    ],
    obat: [
        { name:'Paracetamol 500mg', stock: 42, sold: 245 },
        { name:'Amoxicillin 500mg', stock: 18, sold: 198 },
        { name:'Vitamin C 500mg', stock: 32, sold: 156 },
        { name:'CTM 4mg', stock: 7, sold: 121 },
        { name:'Ibuprofen 200mg', stock: 11, sold: 89 },
    ],
    kinerja: [
        { staff:'Dr. Anita', patientCount: 172, satisfaction: 97 },
        { staff:'Dr. Budi', patientCount: 160, satisfaction: 92 },
        { staff:'Dr. Citra', patientCount: 148, satisfaction: 89 },
        { staff:'Perawat Rani', patientCount: 132, satisfaction: 95 },
    ],
    finansial: [
        { label:'Pendapatan Total', value: 18500000 },
        { label:'Biaya Operasional', value: 7200000 },
        { label:'Laba Bersih', value: 11300000 },
        { label:'Pembayaran BPJS', value: 10450000 },
        { label:'Pembayaran Mandiri', value: 8050000 },
    ],
};

function fmtCurrency(value) {
    return new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', maximumFractionDigits: 0 }).format(value);
}

function buildReportData(type) {
    if (type === 'transaksi') {
        const entries = reportSources.transaksi;
        const total = entries.reduce((sum, item) => sum + item.total, 0);
        return {
            meta: `${entries.length} transaksi • Total ${fmtCurrency(total)}`,
            summary: `Ringkasan laporan transaksi: ${entries.length} transaksi dengan total ${fmtCurrency(total)}.`,
            dataLines: entries.map((item, index) =>
                `${index + 1}. ${item.trxId} | ${item.patientName} | ${item.jenis} | ${fmtCurrency(item.total)} | ${item.date} | ${item.status}`),
        };
    }

    if (type === 'pasien') {
        const entries = reportSources.pasien;
        return {
            meta: `${entries.length} pasien`,
            summary: `Ringkasan laporan pasien: ${entries.length} pasien tercatat.`,
            dataLines: entries.map((item, index) =>
                `${index + 1}. ${item.name} | ${item.jenis} | ${item.umur} tahun | ${item.rm}`),
        };
    }

    if (type === 'obat') {
        const entries = reportSources.obat;
        return {
            meta: `${entries.length} item obat`,
            summary: `Ringkasan laporan stok obat: ${entries.length} obat utama dan status stok saat ini.`,
            dataLines: entries.map((item, index) =>
                `${index + 1}. ${item.name} | Stok: ${item.stock} | Terjual: ${item.sold}`),
        };
    }

    if (type === 'kinerja') {
        const entries = reportSources.kinerja;
        return {
            meta: `${entries.length} staf`,
            summary: `Ringkasan laporan kinerja staf: ${entries.length} staf dengan tingkat kepuasan pasien.`,
            dataLines: entries.map((item, index) =>
                `${index + 1}. ${item.staff} | ${item.patientCount} pasien | Kepuasan ${item.satisfaction}%`),
        };
    }

    if (type === 'finansial') {
        const entries = reportSources.finansial;
        return {
            meta: `${entries.length} item finansial`,
            summary: `Ringkasan laporan finansial dengan nilai pendapatan, biaya operasional, dan laba bersih.`,
            dataLines: entries.map(item => `${item.label}: ${fmtCurrency(item.value)}`),
        };
    }

    return {
        meta: 'Tidak ada data',
        summary: 'Tidak ada data laporan yang tersedia.',
        dataLines: ['Tidak ada data laporan.'],
    };
}

/* ============================
   TOAST
============================ */
function showToast(msg, type = 'info') {
    const container = document.getElementById('toast-container');
    const icons = { success: 'fa-circle-check', error: 'fa-circle-xmark', info: 'fa-circle-info' };
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<i class="fa-solid ${icons[type] || icons.info}"></i> ${msg}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/* ============================
   MODAL
============================ */
function showModal(id) { document.getElementById(id).style.display = 'flex'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }

function openReportDetail(report) {
    document.getElementById('modal-report-title').textContent = report.name;
    document.getElementById('modal-report-body').innerHTML = `
        <div class="detail-grid">
            <div class="detail-item full">
                <label>Nama Laporan</label>
                <span>${report.name}</span>
            </div>
            <div class="detail-item">
                <label>Tipe</label>
                <span style="text-transform:capitalize;">${report.type}</span>
            </div>
            <div class="detail-item">
                <label>Format</label>
                <span>${report.format}</span>
            </div>
            <div class="detail-item">
                <label>Periode</label>
                <span>${report.period}</span>
            </div>
            <div class="detail-item">
                <label>Data</label>
                <span>${report.meta}</span>
            </div>
            <div class="detail-item full">
                <label>Ringkasan</label>
                <span>${report.summary || report.meta}</span>
            </div>
            <div class="detail-item full">
                <label>Tanggal Pembuatan</label>
                <span>${report.date}</span>
            </div>
        </div>`;

    showModal('modal-report');
}

function deleteReport(reportId) {
    const idx = reportsData.findIndex(r => r.id === reportId);
    if (idx === -1) return;
    const deleted = reportsData.splice(idx, 1)[0];
    renderReports();
    showToast('Laporan "' + deleted.name + '" berhasil dihapus.', 'success');
}

function downloadReport(report) {
    const isPdf = report.format === 'PDF';
    const isExcel = report.format === 'EXCEL';
    const filename = report.name.replace(/\s+/g, '_') + (isPdf ? '.pdf' : '.csv');
    const header = [
        `Nama Laporan: ${report.name}`,
        `Tipe: ${report.type}`,
        `Format: ${report.format}`,
        `Periode: ${report.period}`,
        `Ringkasan: ${report.summary || report.meta}`,
        `Tanggal Pembuatan: ${report.date}`,
        '',
    ];
    const lines = report.dataLines || [`${report.meta}`, 'Data laporan otomatis diambil berdasarkan tipe laporan.'];
    const contentLines = header.concat(lines);

    if (isPdf && window.jspdf && window.jspdf.jsPDF) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const margin = 15;
        const maxWidth = 180;
        let y = margin;
        doc.setFontSize(12);

        contentLines.forEach(line => {
            const splitLines = doc.splitTextToSize(line, maxWidth);
            splitLines.forEach(textLine => {
                if (y > doc.internal.pageSize.getHeight() - margin) {
                    doc.addPage();
                    y = margin;
                }
                doc.text(textLine, margin, y);
                y += 8;
            });
        });

        doc.save(filename);
    } else {
        const csvLines = contentLines.map(line => `"${line.replace(/"/g, '""')}"`);
        const blob = new Blob([csvLines.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);
    }

    showToast('Mengunduh ' + report.name + '...', 'success');
}

/* ============================
   RENDER REPORTS LIST
============================ */
function renderReports() {
    document.getElementById('reports-list').innerHTML = reportsData.map(r => `
        <div class="report-item" data-id="${r.id}">
            <div class="report-icon" style="color:${r.iconColor};">
                <i class="fa-solid ${r.icon}"></i>
            </div>
            <div class="report-info">
                <div class="report-name">${r.name}</div>
                <div class="report-date">${r.date} • ${r.meta}</div>
            </div>
            <div class="report-actions">
                <button type="button" class="btn-small btn-view btn-vw" data-id="${r.id}">
                    <i class="fa-solid fa-eye"></i> Lihat
                </button>
                <div class="more-actions">
                    <button type="button" class="btn-small btn-more" data-id="${r.id}">
                        <i class="fa-solid fa-ellipsis"></i> Lainnya
                    </button>
                    <div class="more-menu">
                        <button type="button" class="btn-small btn-download btn-dl" data-id="${r.id}">
                            <i class="fa-solid fa-download"></i> Download
                        </button>
                        <button type="button" class="btn-small btn-delete" data-id="${r.id}">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>`).join('');

    document.querySelectorAll('.btn-dl').forEach(btn => {
        btn.addEventListener('click', event => {
            event.stopPropagation();
            const r = reportsData.find(x => x.id === parseInt(btn.dataset.id));
            if (r) downloadReport(r);
            closeMoreMenus();
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', event => {
            event.stopPropagation();
            const r = reportsData.find(x => x.id === parseInt(btn.dataset.id));
            if (!r) return;
            deleteReport(r.id);
            closeMoreMenus();
        });
    });

    document.querySelectorAll('.btn-vw').forEach(btn => {
        btn.addEventListener('click', () => {
            const r = reportsData.find(x => x.id === parseInt(btn.dataset.id));
            if (r) openReportDetail(r);
            closeMoreMenus();
        });
    });

    document.querySelectorAll('.btn-more').forEach(btn => {
        btn.addEventListener('click', event => {
            event.stopPropagation();
            const wrapper = btn.closest('.more-actions');
            const menu = wrapper.querySelector('.more-menu');
            const isOpen = menu.style.display === 'block';
            closeMoreMenus();
            menu.style.display = isOpen ? 'none' : 'block';
        });
    });
}

/* ============================
   CHARTS — Chart.js
============================ */
const TOSCA       = '#3FBBA0';
const TOSCA_LIGHT = 'rgba(63,187,160,0.15)';
const NAVY        = '#004369';
const BLUE_LIGHT  = '#b1ddff';
const GRID_COLOR  = 'rgba(0,0,0,0.05)';

const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
};

function genTrxData() {
    const labels = [], data = [];
    const today = new Date();
    for (let i = 29; i >= 0; i--) {
        const d = new Date(today);
        d.setDate(d.getDate() - i);
        labels.push(d.getDate() + '/' + (d.getMonth() + 1));
        data.push(Math.floor(20 + Math.random() * 45));
    }
    return { labels, data };
}

function initCharts() {
    // ---- Line chart: Transaksi per hari ----
    const trx = genTrxData();
    new Chart(document.getElementById('chart-trx'), {
        type: 'line',
        data: {
            labels: trx.labels,
            datasets: [{
                data: trx.data,
                borderColor: TOSCA,
                borderWidth: 2.5,
                backgroundColor: TOSCA_LIGHT,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: TOSCA,
            }],
        },
        options: {
            ...chartDefaults,
            scales: {
                x: {
                    grid: { color: GRID_COLOR },
                    ticks: { color: '#6a9ab5', font: { size: 10 }, maxTicksLimit: 10 },
                },
                y: {
                    grid: { color: GRID_COLOR },
                    ticks: { color: '#6a9ab5', font: { size: 10 } },
                    beginAtZero: true,
                },
            },
        },
    });

    // ---- Doughnut chart: BPJS vs Mandiri ----
    const payData   = [65, 35];
    const payLabels = ['BPJS', 'Mandiri'];
    const payColors = [TOSCA, BLUE_LIGHT];

    new Chart(document.getElementById('chart-pay'), {
        type: 'doughnut',
        data: {
            labels: payLabels,
            datasets: [{
                data: payData,
                backgroundColor: payColors,
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }],
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + '%',
                    },
                },
            },
        },
    });

    document.getElementById('pie-legend').innerHTML = payLabels.map((l, i) => `
        <div class="legend-item">
            <span class="legend-color" style="background:${payColors[i]};"></span>
            <span>${l}: ${payData[i]}%</span>
        </div>`).join('');

    // ---- Horizontal bar chart: Obat terpopuler ----
    const obatLabels = ['Paracetamol 500mg', 'Amoxicillin 500mg', 'Vitamin C 500mg', 'CTM 4mg', 'Ibuprofen 200mg'];
    const obatData   = [245, 198, 156, 121, 89];
    const obatColors = [TOSCA, NAVY, BLUE_LIGHT, TOSCA, NAVY];

    new Chart(document.getElementById('chart-obat'), {
        type: 'bar',
        data: {
            labels: obatLabels,
            datasets: [{
                data: obatData,
                backgroundColor: obatColors,
                borderRadius: 4,
                borderSkipped: false,
            }],
        },
        options: {
            ...chartDefaults,
            indexAxis: 'y',
            scales: {
                x: {
                    grid: { color: GRID_COLOR },
                    ticks: { color: '#6a9ab5', font: { size: 10 } },
                    beginAtZero: true,
                },
                y: {
                    grid: { display: false },
                    ticks: { color: '#004369', font: { size: 11, weight: '600' } },
                },
            },
        },
    });

    // ---- Sparkline: Kunjungan pasien ----
    const visitData = [32,38,35,42,40,37,44,50,46,48,55,60,58,52,62,65,58,55,50,48,52,56,60,58,54,50,48,45,50,55];
    new Chart(document.getElementById('chart-visit'), {
        type: 'line',
        data: {
            labels: visitData.map((_, i) => i + 1),
            datasets: [{
                data: visitData,
                borderColor: TOSCA,
                borderWidth: 2,
                backgroundColor: TOSCA_LIGHT,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { enabled: false } },
            scales: {
                x: { display: false },
                y: { display: false, beginAtZero: false },
            },
        },
    });
}

/* ============================
   GENERATE LAPORAN
============================ */
function handleGenerate() {
    const type   = document.getElementById('filter-type').value;
    const period = document.getElementById('filter-period').options[document.getElementById('filter-period').selectedIndex].text;
    const format = document.getElementById('filter-format').value.toUpperCase();
    const btn    = document.getElementById('btn-generate');

    if (!type) { showToast('Pilih tipe laporan terlebih dahulu.', 'error'); return; }

    btn.classList.add('loading');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Membuat...';

    setTimeout(() => {
            const typeLabel = document.getElementById('filter-type').options[document.getElementById('filter-type').selectedIndex].text;
        const reportData = buildReportData(type);
        const newReport = {
            id: Date.now(),
            icon: format === 'PDF' ? 'fa-file-pdf' : format === 'EXCEL' ? 'fa-file-excel' : 'fa-file-csv',
            iconColor: format === 'PDF' ? '#3FBBA0' : format === 'EXCEL' ? '#00a86b' : '#e65100',
            name: typeLabel + ' — ' + period,
            date: 'Dibuat: ' + new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }),
            meta: reportData.meta,
            summary: reportData.summary,
            dataLines: reportData.dataLines,
            format,
            type,
            period,
        };

        reportsData.unshift(newReport);
        renderReports();
        showToast('Laporan "' + newReport.name + '" berhasil dibuat!', 'success');

        btn.classList.remove('loading');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Buat Laporan';
    }, 1800);
}

/* ============================
   DETAIL CHART BUTTONS
============================ */
function bindDetailButtons() {
    const sections = {
        'btn-detail-trx':   { title: 'Transaksi Per Hari', info: 'Data menampilkan jumlah transaksi harian selama 30 hari terakhir. Tren menunjukkan peningkatan konsisten di akhir bulan.' },
        'btn-detail-pay':   { title: 'BPJS vs Mandiri', info: '65% transaksi menggunakan BPJS dan 35% pembayaran mandiri. BPJS mendominasi di hari kerja, mandiri meningkat di akhir pekan.' },
        'btn-all-obat':     { title: 'Obat Terpopuler', info: 'Paracetamol 500mg menjadi obat paling banyak diresepkan (245 resep), diikuti Amoxicillin 500mg (198 resep) dan Vitamin C 500mg (156 resep).' },
        'btn-detail-visit': { title: 'Kunjungan Pasien', info: 'Total 1.245 kunjungan bulan ini dengan rata-rata 40 pasien/hari. Puncak kunjungan terjadi pada 12 Mei (65 pasien).' },
    };

    Object.entries(sections).forEach(([btnId, info]) => {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.addEventListener('click', () => {
            document.getElementById('modal-report-title').textContent = info.title;
            document.getElementById('modal-report-body').innerHTML = `
                <p style="font-size:14px;color:var(--text-dark);line-height:1.7;">${info.info}</p>`;
            document.getElementById('modal-report-close-btn').onclick = () => {
                closeModal('modal-report');
            };
            showModal('modal-report');
        });
    });
}

/* ============================
   INIT
============================ */
function closeMoreMenus() {
    document.querySelectorAll('.more-menu').forEach(menu => menu.style.display = 'none');
}

document.addEventListener('DOMContentLoaded', () => {
    initCharts();
    renderReports();
    bindDetailButtons();

    document.getElementById('btn-generate').addEventListener('click', handleGenerate);
    document.getElementById('modal-report-close').addEventListener('click', () => closeModal('modal-report'));
    document.getElementById('modal-report-close-btn').addEventListener('click', () => closeModal('modal-report'));
    document.getElementById('modal-report').addEventListener('click', function (e) {
        if (e.target === this) closeModal('modal-report');
    });
    document.addEventListener('click', () => closeMoreMenus());
});

 // Dropdowns
    document.getElementById('filter-category').addEventListener('change', function () {
        state.category = this.value; state.page = 1; renderTable();
    });
    document.getElementById('filter-status').addEventListener('change', function () {
        state.status = this.value; state.page = 1; renderTable();
    });