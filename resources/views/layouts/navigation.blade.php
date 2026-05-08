<?php
// layout/navigation.php
// Navbar VERTICAL untuk Sick Safe ON - Menu: Beranda saja
// Color Palette: #3FBBA0, #004369, #b1ddff, #E1F1FE
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* NAVBAR VERTICAL (SAMPING KIRI) */
    .navbar {
        background: #004369;  /* Biru Tua */
        width: 260px;
        min-height: 100vh;
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 20px;
        box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
    }

    /* Logo di atas */
    .logo {
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        margin-bottom: 60px;
    }

    .logo-icon {
        font-size: 48px;
        background: #3FBBA0;
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .logo-text {
        text-align: center;
        font-size: 1.3rem;
        font-weight: bold;
        color: white;
        line-height: 1.3;
    }

    .logo-text span {
        font-weight: normal;
        color: #b1ddff;
    }

    /* Menu Navigasi (VERTICAL ke bawah) */
    .nav-menu {
        display: flex;
        flex-direction: column;
        gap: 16px;
        list-style: none;
        width: 100%;
    }

    .nav-menu li {
        width: 100%;
    }

    .nav-menu li a {
        text-decoration: none;
        display: block;
        text-align: center;
        padding: 12px 20px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    /* Tombol Beranda */
    .btn-beranda {
        background: #3FBBA0;
        color: #004369;
    }

    .btn-beranda:hover {
        background: #359a84;
        color: white;
        transform: translateX(5px);
    }
</style>

<!-- NAVBAR VERTICAL DI SAMPING KIRI -->
<nav class="navbar">
    <!-- Logo di atas -->
    <a href="index.php" class="logo">
        <div class="logo-icon">🏥</div>
        <div class="logo-text">Sick<br><span>Safe</span> ON</div>
    </a>

    <!-- Menu Beranda -->
    <ul class="nav-menu">
        <li><a href="index.php" class="btn-beranda">🏠 Beranda</a></li>
    </ul>
</nav>