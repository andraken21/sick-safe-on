<aside class="sidebar" id="sidebar">

    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="#" class="nav-item active">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-file-prescription"></i> Resep Digital
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-pills"></i> Stok Obat
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-user-md"></i> Validasi Apoteker
        </a>

        <div class="nav-label">Transaksi</div>
        <a href="#" class="nav-item">
            <i class="fas fa-shopping-cart"></i> Pembelian
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-credit-card"></i> Pembayaran
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-truck"></i> Distribusi Obat
        </a>

        <div class="nav-label">Pengaturan</div>
        <a href="#" class="nav-item">
            <i class="fas fa-cog"></i> Pengaturan
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
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
  
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        background-color: #0A2E3F;
        display: flex;
        flex-direction: column;
        z-index: 9999;
        transform: translateX(-250px); /* default: tertutup */
        transition: transform 0.3s ease;
        border-right: 1px solid rgba(255,255,255,0.06);
        overflow: hidden;
    }

    .sidebar.open {
        transform: translateX(0);
    }

  
    .sidebar-nav {
        flex: 1;
        padding: 16px 10px;
        overflow-y: auto;
        margin-top: 0;
    }

    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

    .nav-label {
        font-size: 0.63rem;
        font-weight: 600;
        color: #4a6a7a;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 10px 10px 5px;
        margin-top: 8px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        color: #8DA6B5;
        text-decoration: none;
        font-size: 0.83rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
        margin-bottom: 2px;
        white-space: nowrap;
        border: 1px solid transparent;
    }

    .nav-item i {
        width: 18px;
        font-size: 14px;
        flex-shrink: 0;
        text-align: center;
    }

    .nav-item:hover {
        background: rgba(255,255,255,0.06);
        color: #E1F1FE;
    }

    .nav-item.active {
        background: rgba(46,204,113,0.12);
        color: #2ecc71;
        border-color: rgba(46,204,113,0.2);
    }

    .sidebar-user {
        padding: 14px 16px;
        border-top: 1px solid rgba(255,255,255,0.07);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(46,204,113,0.2);
        border: 1px solid rgba(46,204,113,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 700;
        color: #2ecc71;
        flex-shrink: 0;
    }

    .user-info p {
        font-size: 0.82rem;
        font-weight: 600;
        color: #E1F1FE;
        margin: 0;
    }

    .user-info span {
        font-size: 0.70rem;
        color: #5a7a8a;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 9998;
    }

    .sidebar-overlay.show {
        display: block;
    }

    @media (max-width: 768px) {
        .sidebar {
            z-index: 9999;
        }
    }
</style>