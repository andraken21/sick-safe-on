<aside class="sidebar" id="sidebar">

    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="#" class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="#" class="nav-item"><i class="fas fa-file-prescription"></i> Resep Digital</a>
        <a href="#" class="nav-item"><i class="fas fa-pills"></i> Stok Obat</a>
        <a href="#" class="nav-item"><i class="fas fa-user-md"></i> Validasi Apoteker</a>

        <div class="nav-label">Transaksi</div>
        <a href="#" class="nav-item"><i class="fas fa-shopping-cart"></i> Pembelian</a>
        <a href="#" class="nav-item"><i class="fas fa-credit-card"></i> Pembayaran</a>
        <a href="#" class="nav-item"><i class="fas fa-truck"></i> Distribusi Obat</a>

        <div class="nav-label">Pengaturan</div>
        <a href="#" class="nav-item"><i class="fas fa-cog"></i> Pengaturan</a>
        <a href="#" class="nav-item"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">AD</div>
        <div class="user-info">
            <p>Admin</p>
            <span>Apoteker</span>
        </div>
    </div>
</aside>

<style>
    /* DEFAULT: sidebar TERSEMBUNYI */
    .sidebar {
        width: 250px;
        min-width: 250px;
        background-color: #0A2E3F;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 300;
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255,255,255,0.06);
        transform: translateX(-250px);
        transition: transform 0.3s ease;
    }

   
    .sidebar.open {
        transform: translateX(0);
    }

    .sidebar-nav {
        flex: 1;
        padding: 14px 10px;
        overflow-y: auto;
    }

    .nav-label {
        font-size: 0.83rem;
        font-weight: 700;
        color: #004369;
        text-transform: uppercase;
        letter-spacing: 5px;
        padding: 20px 10px 5px;
        margin-top: 10px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 80px;
        color: #004369;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s;
        margin-bottom: 5px;
        white-space: nowrap;
    }

    .nav-item i { width: 17px; font-size: 14px; flex-shrink: 0; }

    .nav-item:hover { background: rgba(255,255,255,0.05); color: #E1F1FE; }
    .nav-item.active {
        background: rgba(46,204,113,0.12);
        color: #2ecc71;
        border: 1px solid rgba(46,204,113,0.2);
    }

    .sidebar-user {
        padding: 14px 16px;
        border-top: 1px solid #ffffff12;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 600;
        color: #004369;
        flex-shrink: 0;
    }

    .user-info p { font-size: 0.80rem; font-weight: 500; color: #E1F1FE; }
    .user-info span { font-size: 0.70rem; color: #5a7a8a; }

    @media (max-width: 768px) {
        .sidebar { transform: translateX(-250px); }
        body.sidebar-open .sidebar { transform: translateX(0); }
    }
</style>