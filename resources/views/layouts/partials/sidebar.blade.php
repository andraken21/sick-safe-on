@php
    $role = Auth::user()->role ?? '';
@endphp

<aside class="sidebar" id="sidebar">

    {{-- LOGO --}}
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h2>Sick Safe <span>ON</span></h2>
    </div>

    {{-- NAVIGASI BERDASARKAN ROLE --}}
    <nav class="sidebar-nav">

        @if($role === 'Admin')
            {{-- ─── ADMIN ─── --}}
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="nav-label">Manajemen</div>
            <a href="{{ route('kelolaAkunPengguna') }}" class="nav-item">
                <i class="fas fa-pills"></i> Kelola Data Obat
            </a>
            <a href="{{ route('pantauTransaksi') }}" class="nav-item">
                <i class="fas fa-exchange-alt"></i> Pantau Transaksi
            </a>
            <a href="{{ route('kelolaAkunPengguna') }}" class="nav-item">
                <i class="fas fa-users-cog"></i> Kelola Akun Pengguna
            </a>
            <a href="{{ route('laporanAnalisisData') }}" class="nav-item">
                <i class="fas fa-chart-bar"></i> Laporan & Analisis
            </a>

        @elseif($role === 'Dokter')
            {{-- ─── DOKTER ─── --}}
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('dokter.dashboard') }}"
               class="nav-item {{ request()->is('dokter/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="nav-label">Pasien</div>
            <a href="#" class="nav-item">
                <i class="fas fa-list-ol"></i> Antrian Pasien
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-user-check"></i> Memilih Pasien
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-file-prescription"></i> Membuat Resep
            </a>

        @elseif($role === 'Pasien')
            {{-- ─── PASIEN ─── --}}
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('pasien.dashboard') }}"
               class="nav-item {{ request()->is('pasien/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="nav-label">Layanan</div>
            <a href="{{ route('pasien.resep.index') }}"
               class="nav-item {{ request()->is('pasien/resep*') ? 'active' : '' }}">
                <i class="fas fa-file-prescription"></i> Melihat Resep
            </a>
            <a href="{{ route('pasien.pembayaran.index') }}"
               class="nav-item {{ request()->is('pasien/pembayaran*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Pembayaran
            </a>

        @elseif($role === 'Apoteker')
            {{-- ─── APOTEKER ─── --}}
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('apoteker.dashboard') }}"
               class="nav-item {{ request()->is('apoteker/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="nav-label">Resep</div>
            <a href="#" class="nav-item">
                <i class="fas fa-hourglass-half"></i> Menunggu Validasi
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-money-bill-wave"></i> Menunggu Pembayaran
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-cogs"></i> Diproses
            </a>

        @endif

        {{-- KELUAR — tampil untuk semua role --}}
        <div class="nav-label">Akun</div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
            @csrf
            <button type="submit" class="nav-item nav-item-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>

    </nav>

    {{-- INFO USER --}}
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
        width: 250px;
        min-width: 250px;
        background-color: #0A2E3F;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 200;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        border-right: 1px solid rgba(255,255,255,0.06);
    }

    .sidebar.collapsed { transform: translateX(-250px); }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 22px 18px 18px;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    .sidebar-logo-icon {
        width: 34px;
        height: 34px;
        background: rgba(46,204,113,0.15);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(46,204,113,0.25);
        flex-shrink: 0;
    }

    .sidebar-logo-icon i { color: #2ecc71; font-size: 16px; }

    .sidebar-logo h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        white-space: nowrap;
    }

    .sidebar-logo h2 span { color: #2ecc71; }

    .sidebar-nav {
        flex: 1;
        padding: 14px 10px;
        overflow-y: auto;
    }

    .nav-label {
        font-size: 0.63rem;
        font-weight: 600;
        color: #4a6a7a;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 8px 10px 5px;
        margin-top: 6px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 8px;
        color: #8DA6B5;
        text-decoration: none;
        font-size: 0.83rem;
        transition: all 0.2s;
        margin-bottom: 2px;
        white-space: nowrap;
    }

    /* Tombol keluar di sidebar — samakan tampilan dengan nav-item */
    .nav-item-btn {
        width: 100%;
        background: transparent;
        border: none;
        cursor: pointer;
        font-family: inherit;
        text-align: left;
    }

    .nav-item i { width: 17px; font-size: 14px; flex-shrink: 0; }

    .nav-item:hover,
    .nav-item-btn:hover { background: rgba(255,255,255,0.05); color: #E1F1FE; }

    .nav-item.active {
        background: rgba(46,204,113,0.12);
        color: #2ecc71;
        border: 1px solid rgba(46,204,113,0.2);
    }

    .sidebar-user {
        padding: 14px 16px;
        border-top: 1px solid rgba(255,255,255,0.07);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(46,204,113,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 600;
        color: #2ecc71;
        flex-shrink: 0;
    }

    .user-info p    { font-size: 0.80rem; font-weight: 500; color: #E1F1FE; }
    .user-info span { font-size: 0.70rem; color: #5a7a8a; }

    @media (max-width: 768px) {
        .sidebar { transform: translateX(-250px); }
        body.sidebar-open .sidebar { transform: translateX(0); }
    }
</style>