<?php
// layout/navbar-pasien.php
// Navbar VERTICAL untuk PASIEN - Rata Kiri
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .navbar {
        background: #004369;
        width: 260px;
        min-height: 100vh;
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        padding: 30px 20px;
        box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
    }

    .logo {
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        margin-bottom: 40px;
    }

    .logo-icon {
        font-size: 42px;
        background: #3FBBA0;
        width: 65px;
        height: 65px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .logo-text {
        text-align: center;
        font-size: 1.2rem;
        font-weight: bold;
        color: white;
        line-height: 1.3;
    }

    .logo-text span {
        font-weight: normal;
        color: #b1ddff;
    }

    .nav-menu {
        display: flex;
        flex-direction: column;
        gap: 12px;
        list-style: none;
        width: 100%;
    }

    .nav-menu li {
        width: 100%;
    }

    .nav-menu li a {
        text-decoration: none;
        display: block;
        text-align: left;
        padding: 10px 16px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #3FBBA0;
        color: #004369;
    }

    .nav-menu li a:hover {
        background: #359a84;
        color: white;
        transform: translateX(5px);
    }

    .role-info {
        margin-top: auto;
        padding-top: 30px;
        text-align: left;
        font-size: 0.75rem;
        color: #b1ddff;
        border-top: 1px solid #b1ddff33;
        width: 100%;
        padding-top: 20px;
    }
</style>

<nav class="navbar">
    <a href="dashboard-pasien.php" class="logo">
        <div class="logo-icon">🏥</div>
        <img src="{{ asset('image/logo.png') }}" alt="Logo Saya" width="100">
        <div class="logo-text">Sick<br><span>Safe</span> ON</div>
    </a>

    <ul class="nav-menu">
        <li><a href="pasien/resep-saya.php">📋 Resep Saya</a></li>
        <li><a href="pasien/pembayaran.php">💰 Pembayaran</a></li>
        <li><a href="pasien/pesanan-obat.php">📦 Pesanan Obat</a></li>
        <li><a href="pasien/profil.php">👤 Profil</a></li>
    </ul>

    <div class="role-info">
        Login sebagai: <strong>Pasien</strong>
    </div>
</nav>