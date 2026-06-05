document.addEventListener('DOMContentLoaded', function () {

    const modal    = document.getElementById('modal-konfirmasi');
    const title    = document.getElementById('modal-title');
    const question = document.getElementById('modal-question');
    const desc     = document.getElementById('modal-desc');
    let   currentAction = null;

    function openModal(action, text) {
        currentAction        = action;
        title.textContent    = text.title;
        question.textContent = text.question;
        desc.textContent     = text.desc;
        modal.style.display  = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    document.getElementById('modal-close')  ?.addEventListener('click', closeModal);
    document.getElementById('modal-cancel') ?.addEventListener('click', closeModal);
    modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });

    // Validasi
    document.getElementById('btn-open-validasi')
        ?.addEventListener('click', () => openModal('validasi', {
            title: 'Validasi Resep', question: 'Validasi resep ini?', desc: 'Pastikan resep sudah diperiksa.'
        }));
    document.getElementById('btn-open-tolak')
        ?.addEventListener('click', () => openModal('tolak', {
            title: 'Tolak Resep', question: 'Tolak resep ini?', desc: 'Resep akan dikembalikan ke dokter.'
        }));

    // Validasi & Proses
    document.getElementById('btn-open-validasi-proses')
        ?.addEventListener('click', () => openModal('validasi-proses', {
        title: 'Validasi & Proses',
        question: 'Validasi dan langsung proses resep ini?',
        desc: 'Resep akan divalidasi dan masuk ke antrian proses.'
    }));

    // Pembayaran
    document.getElementById('btn-open-bayar')
        ?.addEventListener('click', () => openModal('bayar', {
            title: 'Konfirmasi Pembayaran', question: 'Pembayaran sudah diterima?', desc: 'Pastikan pembayaran telah diverifikasi.'
        }));

    // Diproses
    document.getElementById('btn-open-selesai')
        ?.addEventListener('click', () => openModal('selesai', {
            title: 'Tandai Selesai', question: 'Pesanan sudah selesai?', desc: 'Pesanan akan dipindahkan ke riwayat.'
        }));
    document.getElementById('btn-open-riwayat')
        ?.addEventListener('click', () => showToast('Menampilkan riwayat resep', 'info'));

    // Pilih baris tabel
    document.querySelectorAll('#resepTable tbody tr').forEach(row => {
        row.addEventListener('click', function () {
            document.querySelectorAll('#resepTable tbody tr').forEach(r => r.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // Konfirmasi modal
    document.getElementById('modal-confirm')?.addEventListener('click', function () {
    const messages = {
        validasi:         ['Resep berhasil divalidasi',        'success'],
        tolak:            ['Resep berhasil ditolak',           'error'],
        bayar:            ['Pembayaran berhasil dikonfirmasi', 'success'],
        selesai:          ['Pesanan selesai diproses',         'success'],
        'validasi-proses':['Resep divalidasi dan diproses',   'success'], // ← tambahkan ini
    };
        const [msg, type] = messages[currentAction] ?? ['Tindakan berhasil', 'info'];
        showToast(msg, type);
        closeModal();
    });

});

function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    const toast     = document.createElement('div');
    toast.className   = `toast toast-${type}`;
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity   = '0';
        toast.style.transform = 'translateX(20px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}