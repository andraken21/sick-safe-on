// Filter tab
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        const filter = this.dataset.filter;
        const rows   = document.querySelectorAll('#resepTable tbody tr');
        let   count  = 0;

        rows.forEach(row => {
            const status = row.dataset.status;
            const show   = (filter === 'semua') || (status === filter);
            row.style.display = show ? '' : 'none';
            if (show) count++;
        });

        document.getElementById('jumlahTampil').textContent = `Menampilkan ${count} resep`;
    });
});

// Search
document.getElementById('searchInput')?.addEventListener('input', function () {
    const q    = this.value.toLowerCase();
    const rows = document.querySelectorAll('#resepTable tbody tr');
    let   count = 0;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const show = text.includes(q);
        row.style.display = show ? '' : 'none';
        if (show) count++;
    });

    document.getElementById('jumlahTampil').textContent = `Menampilkan ${count} resep`;
});