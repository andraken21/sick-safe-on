@php $role = Auth::user()->role ?? ''; @endphp

<aside class="sidebar" id="sidebar">

    <div class="sidebar-logo">
        <div class="sidebar-logo-icon"><i class="fas fa-shield-alt"></i></div>
        <h2>Sick Safe <span>ON</span></h2>
    </div>

    <nav class="sidebar-nav">

        @if ($role === 'Admin')
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <div class="nav-label">Manajemen</div>
            <a href="{{ route('kelolaDataObat') }}"
                class="nav-item {{ request()->is('admin/kelolaDataObat') ? 'active' : '' }}">
                <i class="fas fa-pills"></i> Kelola Data Obat
            </a>
            <a href="{{ route('pantauTransaksi') }}"
                class="nav-item {{ request()->is('admin/pantauTransaksi') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i> Pantau Transaksi
            </a>
            <a href="{{ route('kelolaAkunPengguna') }}"
                class="nav-item {{ request()->is('admin/kelolaAkunPengguna') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Kelola Akun Pengguna
            </a>
            <a href="{{ route('laporanAnalisisData') }}"
                class="nav-item {{ request()->is('admin/laporanAnalisisData') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Laporan &amp; Analisis
            </a>
        @elseif($role === 'Dokter')
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('dokter.dashboard') }}"
                class="nav-item {{ request()->is('dokter/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <div class="nav-label">Pasien &amp; Resep</div>
            <a href="{{ route('dokter.pilih-pasien') }}"
                class="nav-item {{ request()->is('dokter/pilih-pasien') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Pilih Pasien
            </a>
            <a href="{{ route('dokter.resep') }}"
                class="nav-item {{ request()->is('dokter/resep') ? 'active' : '' }}">
                <i class="fas fa-file-prescription"></i> Buat Resep
            </a>
            <a href="{{ route('dokter.daftar-resep') }}"
                class="nav-item {{ request()->is('dokter/daftar-resep') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Daftar Resep
            </a>
            <a href="{{ route('dokter.antrian') }}"
                class="nav-item {{ request()->is('dokter/antrian') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Antrian
            </a>
        @elseif($role === 'Pasien')
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('pasien.dashboard') }}"
                class="nav-item {{ request()->is('pasien/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <div class="nav-label">Layanan</div>
            <a href="{{ route('pasien.resep') }}"
                class="nav-item {{ request()->is('pasien/resep*') ? 'active' : '' }}">
                <i class="fas fa-file-prescription"></i> Melihat Resep
            </a>
            <a href="{{ route('pasien.pembayaran') }}"
                class="nav-item {{ request()->is('pasien/pembayaran*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Pembayaran
            </a>
        @elseif($role === 'Apoteker')
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('apoteker.dashboard') }}"
                class="nav-item {{ request()->is('apoteker/dashboard*') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <div class="nav-label">Resep</div>
            <a href="{{ route('apoteker.validasi') }}"
                class="nav-item {{ request()->is('apoteker/validasi') ? 'active' : '' }}">
                <i class="fas fa-hourglass-half"></i> Menunggu Validasi
            </a>
            <a href="{{ route('apoteker.pembayaran') }}"
                class="nav-item {{ request()->is('apoteker/pembayaran') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Menunggu Pembayaran
            </a>
            <a href="{{ route('apoteker.diproses') }}"
                class="nav-item {{ request()->is('apoteker/diproses') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i> Diproses
            </a>
        @endif

        <div class="nav-label">Akun</div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
            @csrf
            <button type="submit" class="nav-item nav-item-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>

    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 2)) }}
        </div>
        <div class="user-info">
            <p>{{ Auth::user()->nama ?? 'Pengguna' }}</p>
            <span>{{ Auth::user()->role ?? '' }}</span>
        </div>
    </div>

</aside>

<style>
    .sidebar {
        width: 220px;
        min-width: 220px;
        background-color: #0A2E3F;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 200;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        border-right: 1px solid rgba(255, 255, 255, 0.06);
        gap: 0;
    }

    .sidebar.collapsed {
        transform: translateX(-220px);
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 14px 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }

    /* BENAR: Menghilangkan scrollbar di navigasi utama sidebar */
    .sidebar-nav::-webkit-scrollbar {
        display: none !important;
    }

    .sidebar-nav {
        flex: 1;
        padding: 10px 8px;
        overflow-y: auto;
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }

    .sidebar-logo-icon {
        width: 28px;
        height: 28px;
        background: rgba(46, 204, 113, 0.15);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(46, 204, 113, 0.25);
        flex-shrink: 0;
    }

    .sidebar-logo-icon i {
        color: #2ecc71;
        font-size: 13px;
    }

    .sidebar-logo h2 {
        font-size: 0.85rem;
        font-weight: 700;
        color: #fff;
        white-space: nowrap;
    }

    .sidebar-logo h2 span {
        color: #2ecc71;
    }

    .nav-label {
        font-size: 0.60rem;
        font-weight: 600;
        color: #4a6a7a;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 6px 8px 4px;
        margin-top: 2px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 10px;
        border-radius: 6px;
        color: #8DA6B5;
        text-decoration: none;
        font-size: 0.78rem;
        transition: all 0.2s;
        margin-bottom: 1px;
        width: 100%;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis !important;
    }

    .nav-item-btn {
        width: 100%;
        background: transparent;
        border: none;
        cursor: pointer;
        font-family: inherit;
        text-align: left;
    }

    .nav-item i {
        width: 15px;
        font-size: 12px;
        flex-shrink: 0;
    }

    .nav-item:hover,
    .nav-item-btn:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #E1F1FE;
    }

    .nav-item.active {
        background: rgba(46, 204, 113, 0.12);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.2);
    }

    .sidebar-user {
        padding: 10px 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.07);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(46, 204, 113, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        font-weight: 600;
        color: #2ecc71;
        flex-shrink: 0;
    }

    .user-info p {
        font-size: 0.75rem;
        font-weight: 500;
        color: #E1F1FE;
    }

    .user-info span {
        font-size: 0.65rem;
        color: #5a7a8a;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-220px);
        }

        body.sidebar-open .sidebar {
            transform: translateX(0);
        }
    }
</style>
