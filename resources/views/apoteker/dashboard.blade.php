@extends('layouts.app')

@section('title', 'Dashboard Apoteker - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">
@endpush

@section('content')

<div class="dashboard-wrapper">

    {{-- ==================== CARD 1 : RESEP MASUK ==================== --}}
    <div class="dashboard-card">
        <main class="main-content">

            <h2 class="section-title">Resep Masuk</h2>

            {{-- TABS --}}
            <div class="tabs">
                <a href="{{ route('apoteker.dashboard', 'validasi') }}"
                   class="tab {{ $status === 'validasi'   ? 'active' : '' }}">Menunggu Validasi</a>
                <a href="{{ route('apoteker.dashboard', 'pembayaran') }}"
                   class="tab {{ $status === 'pembayaran' ? 'active' : '' }}">Menunggu Pembayaran</a>
                <a href="{{ route('apoteker.dashboard', 'diproses') }}"
                   class="tab {{ $status === 'diproses'   ? 'active' : '' }}">Diproses</a>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="resepTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Resep</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($status === 'validasi')
                            <tr class="selected">
                                <td>1</td><td>RSP-2024-0051</td><td>Andi Setiawan</td>
                                <td>Dr. Budi Santoso</td><td>20 Mei 2024</td>
                                <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                            </tr>
                            <tr>
                                <td>2</td><td>RSP-2024-0052</td><td>Dinda Permata</td>
                                <td>Dr. Rina Sari</td><td>20 Mei 2024</td>
                                <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                            </tr>
                            <tr>
                                <td>3</td><td>RSP-2024-0053</td><td>Rudi Hartono</td>
                                <td>Dr. Budi Santoso</td><td>20 Mei 2024</td>
                                <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                            </tr>

                        @elseif($status === 'pembayaran')
                            <tr class="selected">
                                <td>1</td><td>RSP-2024-0048</td><td>Rini Wulandari</td>
                                <td>Dr. Ahmad Fauzi</td><td>19 Mei 2024</td>
                                <td><span class="status-badge status-info">Menunggu Pembayaran</span></td>
                            </tr>
                            <tr>
                                <td>2</td><td>RSP-2024-0049</td><td>Doni Prakasa</td>
                                <td>Dr. Citra Dewi</td><td>19 Mei 2024</td>
                                <td><span class="status-badge status-info">Menunggu Pembayaran</span></td>
                            </tr>

                        @elseif($status === 'diproses')
                            <tr class="selected">
                                <td>1</td><td>RSP-2024-0044</td><td>Budi Hartono</td>
                                <td>Dr. Budi Santoso</td><td>18 Mei 2024</td>
                                <td><span class="status-badge status-success">Diproses</span></td>
                            </tr>
                            <tr>
                                <td>2</td><td>RSP-2024-0045</td><td>Maya Sari</td>
                                <td>Dr. Citra Dewi</td><td>18 Mei 2024</td>
                                <td><span class="status-badge status-success">Diproses</span></td>
                            </tr>
                            <tr>
                                <td>3</td><td>RSP-2024-0046</td><td>Agus Salim</td>
                                <td>Dr. Ahmad Fauzi</td><td>19 Mei 2024</td>
                                <td><span class="status-badge status-success">Diproses</span></td>
                            </tr>
                            <tr>
                                <td>4</td><td>RSP-2024-0047</td><td>Lina Permata</td>
                                <td>Dr. Budi Santoso</td><td>19 Mei 2024</td>
                                <td><span class="status-badge status-success">Diproses</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </main>
    </div>
    {{-- ==================== END CARD 1 ==================== --}}


    {{-- ==================== CARD 2 : DETAIL ==================== --}}
    <div class="detail-card">

        <div class="detail-card-header">
            @if($status === 'validasi')
                <h3 class="detail-card-title">Detail Resep</h3>
                <span class="detail-card-id">RSP-2024-0051</span>
            @elseif($status === 'pembayaran')
                <h3 class="detail-card-title">Detail Pembayaran</h3>
                <span class="detail-card-id">RSP-2024-0048</span>
            @elseif($status === 'diproses')
                <h3 class="detail-card-title">Detail Diproses</h3>
                <span class="detail-card-id">RSP-2024-0044</span>
            @endif
        </div>

        <div class="detail-grid">

            {{-- Kolom kiri: info --}}
            <div class="detail-info-col">
                @if($status === 'validasi')
                    <div class="detail-item"><span class="detail-label">Pasien</span><span class="detail-value">Andi Setiawan</span></div>
                    <div class="detail-item"><span class="detail-label">Dokter</span><span class="detail-value">Dr. Budi Santoso</span></div>
                    <div class="detail-item"><span class="detail-label">Tanggal</span><span class="detail-value">20 Mei 2024</span></div>
                    <div class="detail-item"><span class="detail-label">Catatan</span><span class="detail-value">Sesudah makan</span></div>
                @elseif($status === 'pembayaran')
                    <div class="detail-item"><span class="detail-label">Pasien</span><span class="detail-value">Rini Wulandari</span></div>
                    <div class="detail-item"><span class="detail-label">Dokter</span><span class="detail-value">Dr. Ahmad Fauzi</span></div>
                    <div class="detail-item"><span class="detail-label">Tanggal</span><span class="detail-value">19 Mei 2024</span></div>
                    <div class="detail-item"><span class="detail-label">Total</span><span class="detail-value highlight">Rp 85.000</span></div>
                @elseif($status === 'diproses')
                    <div class="detail-item"><span class="detail-label">Pasien</span><span class="detail-value">Budi Hartono</span></div>
                    <div class="detail-item"><span class="detail-label">Dokter</span><span class="detail-value">Dr. Budi Santoso</span></div>
                    <div class="detail-item"><span class="detail-label">Estimasi Selesai</span><span class="detail-value">20 Mei 2024, 14:00</span></div>
                    <div class="detail-item"><span class="detail-label">Progress</span><span class="detail-value">65% Selesai</span></div>
                @endif
            </div>

            {{-- Kolom kanan: tabel obat --}}
            <div class="detail-obat-col">
                <h4 class="obat-title">Daftar Obat</h4>
                <div class="table-responsive">
                    <table class="obat-table">
                        <thead>
                            @if($status === 'validasi')
                                <tr><th>Nama Obat</th><th>Dosis</th><th>Jumlah</th></tr>
                            @elseif($status === 'pembayaran')
                                <tr><th>Nama Obat</th><th>Dosis</th><th>Jumlah</th><th>Harga</th></tr>
                            @elseif($status === 'diproses')
                                <tr><th>Nama Obat</th><th>Dosis</th><th>Jumlah</th><th>Status</th></tr>
                            @endif
                        </thead>
                        <tbody>
                            @if($status === 'validasi')
                                <tr><td>Paracetamol 500mg</td><td>3× sehari</td><td>10 Tablet</td></tr>
                                <tr><td>Amoxicillin 500mg</td><td>2× sehari</td><td>15 Kapsul</td></tr>
                                <tr><td>CTM 4mg</td><td>1× sehari</td><td>10 Tablet</td></tr>
                            @elseif($status === 'pembayaran')
                                <tr><td>Ibuprofen 400mg</td><td>3× sehari</td><td>10 Tablet</td><td>Rp 45.000</td></tr>
                                <tr><td>Antasida</td><td>3× sehari</td><td>15 Tablet</td><td>Rp 40.000</td></tr>
                            @elseif($status === 'diproses')
                                <tr>
                                    <td>Metformin 500mg</td><td>2× sehari</td><td>60 Tablet</td>
                                    <td><span class="status-badge status-success">Siap</span></td>
                                </tr>
                                <tr>
                                    <td>Glibenclamide</td><td>1× sehari</td><td>30 Tablet</td>
                                    <td><span class="status-badge status-warning">Disiapkan</span></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="actions">
            @if($status === 'validasi')
                <button class="btn-custom btn-outline" id="btn-open-tolak">Tolak</button>
                <button class="btn-custom btn-primary" id="btn-open-validasi">Validasi</button>
            @elseif($status === 'pembayaran')
                <button class="btn-custom btn-outline" id="btn-open-pembayaran">Lihat Pembayaran</button>
                <button class="btn-custom btn-dark"    id="btn-open-bayar">Konfirmasi Pembayaran</button>
            @elseif($status === 'diproses')
                <button class="btn-custom btn-outline" id="btn-open-riwayat">Lihat Riwayat</button>
                <button class="btn-custom btn-dark"    id="btn-open-selesai">Tandai Selesai</button>
            @endif
        </div>

    </div>
    {{-- ==================== END CARD 2 ==================== --}}

    {{-- MODAL --}}
    <div class="modal-overlay" id="modal-konfirmasi" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Konfirmasi</h3>
                <button class="modal-close" id="modal-close">×</button>
            </div>
            <div class="modal-body">
                <div class="modal-content-center">
                    <h2 id="modal-question">Apakah Anda yakin?</h2>
                    <p  id="modal-desc">Konfirmasi tindakan ini.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-secondary" id="modal-cancel">Batal</button>
                <button class="btn-modal-primary"   id="modal-confirm">Ya</button>
            </div>
        </div>
    </div>

</div>

<div id="toast-container" class="toast-container"></div>

@endsection

{{-- Script dipindah ke @push agar dimuat setelah DOM siap --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal    = document.getElementById('modal-konfirmasi');
    const title    = document.getElementById('modal-title');
    const question = document.getElementById('modal-question');
    const desc     = document.getElementById('modal-desc');
    let   currentAction = null;

    function openModal(action, text) {
        currentAction    = action;
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

    // Tombol validasi
    document.getElementById('btn-open-validasi')
        ?.addEventListener('click', () => openModal('validasi', {
            title: 'Validasi Resep', question: 'Validasi resep ini?', desc: 'Pastikan resep sudah diperiksa.'
        }));

    document.getElementById('btn-open-tolak')
        ?.addEventListener('click', () => openModal('tolak', {
            title: 'Tolak Resep', question: 'Tolak resep ini?', desc: 'Resep akan dikembalikan ke dokter.'
        }));

    // Tombol pembayaran
    document.getElementById('btn-open-bayar')
        ?.addEventListener('click', () => openModal('bayar', {
            title: 'Konfirmasi Pembayaran', question: 'Pembayaran sudah diterima?', desc: 'Pastikan pembayaran telah diverifikasi.'
        }));

    // Tombol diproses
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
            validasi: ['Resep berhasil divalidasi',          'success'],
            tolak:    ['Resep berhasil ditolak',             'error'],
            bayar:    ['Pembayaran berhasil dikonfirmasi',   'success'],
            selesai:  ['Pesanan selesai diproses',           'success'],
        };
        const [msg, type] = messages[currentAction] ?? ['Tindakan berhasil', 'info'];
        showToast(msg, type);
        closeModal();
    });

});

function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    const toast     = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity   = '0';
        toast.style.transform = 'translateX(20px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endpush