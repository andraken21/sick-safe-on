<?php
// layout/navigation.php
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --teal:        #3FBBA0;
        --teal-light:  #5DD4BB;
        --teal-dark:   #2a9480;
        --teal-glow:   rgba(63, 187, 160, 0.25);
        --navy:        #004369;
        --navy-deep:   #003558;
        --navy-mid:    #00548a;
        --blue-soft:   #b1ddff;
        --blue-pale:   #d4eeff;
        --white-ice:   #E1F1FE;

        /* SIDEBAR BG = Biru Muda */
        --sidebar-bg:  #b1ddff;

        --sidebar-w:   270px;
        --sidebar-c:   72px;
        --radius-lg:   16px;
        --radius-md:   12px;
        --radius-sm:   8px;
        --trans:       0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    /* ─── TOGGLE BUTTON ───────────────────────────────── */
    .sidebar-toggle {
        position: fixed;
        top: 18px;
        left: 18px;
        z-index: 1100;
        width: 44px;
        height: 44px;
        border: none;
        border-radius: var(--radius-md);
        background: var(--navy);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--trans);
        box-shadow: 0 4px 18px rgba(0, 67, 105, 0.45);
    }

    .sidebar-toggle:hover {
        background: var(--teal);
        transform: scale(1.08);
        box-shadow: 0 6px 22px var(--teal-glow);
    }

    .sidebar-toggle svg {
        width: 22px;
        height: 22px;
        color: #fff;
        transition: transform 0.3s ease;
    }

    /* ─── SIDEBAR SHELL ───────────────────────────────── */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-w);
        background: var(--sidebar-bg);   /* ← Biru Muda */
        display: flex;
        flex-direction: column;
        padding: 0;
        z-index: 1000;
        transition: var(--trans);
        overflow: hidden;
        box-shadow: 4px 0 24px rgba(0, 67, 105, 0.15);
    }

    /* accent strip kiri — navy */
    .navbar::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(180deg, var(--navy) 0%, var(--teal) 60%, transparent 100%);
        opacity: 0.7;
        z-index: 2;
    }

    /* collapsed */
    .navbar.collapsed {
        width: var(--sidebar-c);
    }

    .navbar.collapsed .logo-text,
    .navbar.collapsed .nav-label,
    .navbar.collapsed .nav-section-title,
    .navbar.collapsed .close-sidebar {
        opacity: 0;
        pointer-events: none;
        white-space: nowrap;
    }

    .navbar.collapsed .logo-icon { width: 42px; height: 42px; }

    .navbar.collapsed .nav-link {
        justify-content: center;
        padding: 13px 0;
    }

    .navbar.collapsed .nav-link .nav-icon { margin: 0; }

    .navbar.hide-sidebar {
        left: calc(-1 * var(--sidebar-w));
    }

    /* ─── INNER SCROLL AREA ───────────────────────────── */
    .sidebar-inner {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 28px 16px 24px;
        gap: 0;
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 67, 105, 0.2) transparent;
    }

    .sidebar-inner::-webkit-scrollbar { width: 4px; }
    .sidebar-inner::-webkit-scrollbar-thumb {
        background: rgba(0, 67, 105, 0.2);
        border-radius: 4px;
    }

    /* ─── LOGO ────────────────────────────────────────── */
    .logo {
        display: flex;
        align-items: center;
        gap: 13px;
        text-decoration: none;
        padding: 6px 8px 6px 6px;
        border-radius: var(--radius-lg);
        margin-bottom: 32px;
        transition: var(--trans);
        flex-shrink: 0;
    }

    .logo:hover { background: rgba(0, 67, 105, 0.08); }

    .logo-icon {
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow:
            0 0 0 1px rgba(0, 67, 105, 0.3),
            0 6px 20px rgba(0, 67, 105, 0.25),
            inset 0 1px 0 rgba(255,255,255,0.15);
        transition: var(--trans);
        overflow: hidden;
    }

    .logo:hover .logo-icon {
        box-shadow: 0 0 0 2px var(--teal), 0 8px 28px rgba(63,187,160,0.25);
    }

    .logo-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1.1;
        transition: opacity 0.25s ease;
    }

    .logo-text .brand-line {
        font-size: 1.15rem;
        font-weight: 800;
        letter-spacing: 0.3px;
    }

    .logo-text .sick  { color: #ffffff; }
    .logo-text .safe  { color: #ffffff; font-weight: 700; } 
    .logo-text .tagline {
        font-size: 0.68rem;
        font-weight: 500;
        color: #3fbba0(25, 196, 159, 0.5);
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-top: 2px;
    }

    /* ─── SECTION TITLE ───────────────────────────────── */
    .nav-section-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.63rem;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: rgba(0, 67, 105, 0.5);
        padding: 0 10px;
        margin: 20px 0 8px;
        transition: opacity 0.25s ease;
    }

    /* ─── NAV MENU ────────────────────────────────────── */
    .nav-menu {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 3px;
        width: 100%;
    }

    .nav-menu li { position: relative; }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 11px 12px;
        border-radius: var(--radius-md);
        text-decoration: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--navy);           /* ← teks navy di atas biru muda */
        transition: var(--trans);
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    .nav-link:hover {
        background: rgba(0, 67, 105, 0.1);
        color: var(--navy-deep);
        transform: translateX(4px);
    }

    /* ─── ACTIVE STATE ────────────────────────────────── */
    .nav-link.active {
        background: var(--navy);
        color: var(--white-ice);
        box-shadow: 0 4px 14px rgba(0, 67, 105, 0.3);
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background: var(--teal);
        border-radius: 50%;
        box-shadow: 0 0 8px var(--teal);
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; box-shadow: 0 0 6px var(--teal); }
        50%       { opacity: 0.55; box-shadow: 0 0 14px var(--teal); }
    }

    /* ─── NAV ICON ────────────────────────────────────── */
    .nav-icon {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 67, 105, 0.1);
        transition: var(--trans);
    }

    .nav-icon svg {
        width: 17px;
        height: 17px;
        stroke: var(--navy);
        transition: var(--trans);
    }

    .nav-link:hover .nav-icon {
        background: rgba(0, 67, 105, 0.18);
    }

    .nav-link.active .nav-icon {
        background: rgba(63, 187, 160, 0.25);
        box-shadow: 0 0 10px rgba(63, 187, 160, 0.2);
    }

    .nav-link.active .nav-icon svg {
        stroke: var(--teal-light);
    }

    /* ─── DIVIDER ─────────────────────────────────────── */
    .nav-divider {
        height: 1px;
        margin: 12px 8px;
        background: linear-gradient(90deg, transparent, rgba(0,67,105,0.2) 30%, rgba(0,67,105,0.2) 70%, transparent);
        flex-shrink: 0;
    }

    /* ─── BOTTOM PROFILE CARD ─────────────────────────── */
    .sidebar-footer {
        margin-top: auto;
        padding-top: 16px;
        flex-shrink: 0;
    }

    .profile-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-md);
        background: rgba(0, 67, 105, 0.12);
        border: 1px solid rgba(0, 67, 105, 0.18);
        cursor: pointer;
        transition: var(--trans);
    }

    .profile-card:hover {
        background: rgba(0, 67, 105, 0.2);
        border-color: var(--teal);
    }

    .profile-avatar {
        flex-shrink: 0;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 0.8rem;
        color: var(--white-ice);
    }

    .profile-info {
        flex: 1;
        overflow: hidden;
        transition: opacity 0.25s ease;
    }

    .profile-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--navy-deep);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-role {
        font-size: 0.68rem;
        color: rgba(0, 67, 105, 0.55);
        white-space: nowrap;
    }

    .profile-dots {
        flex-shrink: 0;
        color: rgba(0, 67, 105, 0.4);
        transition: var(--trans);
    }

    .profile-card:hover .profile-dots { color: var(--teal); }

    /* collapsed: hide profile info */
    .navbar.collapsed .profile-info,
    .navbar.collapsed .profile-dots,
    .navbar.collapsed .nav-section-title {
        opacity: 0;
        pointer-events: none;
    }

    /* ─── TOOLTIP (collapsed) ─────────────────────────── */
    .navbar.collapsed .nav-link::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(var(--sidebar-c) + 8px);
        top: 50%;
        transform: translateY(-50%);
        background: var(--navy);
        border: 1px solid rgba(63,187,160,0.3);
        color: var(--white-ice);
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        font-size: 0.8rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        pointer-events: none;
        z-index: 200;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        animation: none;
    }

    .navbar.collapsed .nav-link:hover::after {
        opacity: 1;
        visibility: visible;
    }

    /* ─── CLOSE BUTTON ────────────────────────────────── */
    .close-sidebar {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(0, 67, 105, 0.12);
        border: 1px solid rgba(0, 67, 105, 0.18);
        border-radius: var(--radius-sm);
        cursor: pointer;
        color: var(--navy);
        padding: 7px;
        display: none;
        transition: var(--trans);
        z-index: 10;
        line-height: 0;
    }

    .close-sidebar:hover {
        background: rgba(63, 187, 160, 0.2);
        color: var(--teal);
        border-color: var(--teal);
        transform: rotate(90deg);
    }

    .close-sidebar svg { width: 18px; height: 18px; }

    /* ─── OVERLAY ─────────────────────────────────────── */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 27, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.active { display: block; opacity: 1; }

    /* ─── MAIN CONTENT SHIFTS ─────────────────────────── */
    .main-content {
        margin-left: var(--sidebar-w);
        transition: margin-left var(--trans);
        padding: 20px;
    }

    .main-content.sidebar-collapsed { margin-left: var(--sidebar-c); }
    .main-content.sidebar-hidden    { margin-left: 0; }

    /* ─── MOBILE ──────────────────────────────────────── */
    @media (max-width: 768px) {
        .close-sidebar { display: flex !important; }
        .navbar { width: 270px; box-shadow: 8px 0 40px rgba(0,27,42,0.3); }
        .navbar.hide-sidebar { left: -270px; }
        .main-content { margin-left: 0; }
    }

    @media (max-width: 480px) {
        .navbar { width: 82%; max-width: 290px; }
        .navbar.hide-sidebar { left: -100%; }
        .sidebar-toggle { top: 12px; left: 12px; width: 40px; height: 40px; }
    }

    /* ─── ENTRY ANIMATION ─────────────────────────────── */
    @keyframes slide-in {
        from { opacity: 0; transform: translateX(-16px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .nav-menu li { animation: slide-in 0.35s ease both; }
    .nav-menu li:nth-child(1) { animation-delay: 0.05s; }
    .nav-menu li:nth-child(2) { animation-delay: 0.10s; }
    .nav-menu li:nth-child(3) { animation-delay: 0.15s; }
    .nav-menu li:nth-child(4) { animation-delay: 0.20s; }
    .nav-menu li:nth-child(5) { animation-delay: 0.25s; }
    .nav-menu li:nth-child(6) { animation-delay: 0.30s; }
</style>

<!-- Toggle Button -->
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 6H20M4 12H14M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
</button>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<nav class="navbar" id="sidebar" aria-label="Navigasi utama">

    <button class="close-sidebar" id="closeSidebar" aria-label="Tutup sidebar">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>

    <div class="sidebar-inner">

        <!-- Logo -->
        <a href="index.php" class="logo" aria-label="Sick Safe ON - Beranda">
            <div class="logo-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="logo-text">
                <div class="brand-line">
                    <!-- Sick = navy/putih gelap, Safe = navy, ON = tosca -->
                    <span class="sick">Sick</span>&nbsp;<span class="safe">Safe</span>&nbsp;<span class="on">ON</span>
                </div>
                <div class="tagline">Health Monitoring</div>
            </div>
        </a>

        <!-- Menu Utama -->
        <div class="nav-section-title">Menu Utama</div>
        <ul class="nav-menu">
            <li>
                <a href="index.php"
                   class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"
                   data-tooltip="Beranda">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M3 12L5 10M5 10L12 3L19 10M5 10V20C5 20.5523 5.44772 21 6 21H9M19 10L21 12M19 10V20C19 20.5523 18.5523 21 18 21H15M9 21C9 21 9 15 12 15C15 15 15 21 15 21M9 21H15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="nav-label">Beranda</span>
                </a>
            </li>
            <li>
                <a href="pasien.php"
                   class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pasien.php' ? 'active' : ''; ?>"
                   data-tooltip="Data Pasien">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45768C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="nav-label">Data Pasien</span>
                </a>
            </li>
            <li>
                <a href="monitoring.php"
                   class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'monitoring.php' ? 'active' : ''; ?>"
                   data-tooltip="Monitoring">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M22 12H18L15 21L9 3L6 12H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="nav-label">Monitoring</span>
                </a>
            </li>
        </ul>

        <div class="nav-divider"></div>

        <!-- Laporan -->
        <div class="nav-section-title">Laporan</div>
        <ul class="nav-menu">
            <li>
                <a href="riwayat.php"
                   class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'active' : ''; ?>"
                   data-tooltip="Riwayat">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 8V12L14 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </span>
                    <span class="nav-label">Riwayat</span>
                </a>
            </li>
            <li>
                <a href="laporan.php"
                   class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : ''; ?>"
                   data-tooltip="Laporan">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 2V8H20M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="nav-label">Laporan</span>
                </a>
            </li>
        </ul>

        <div class="nav-divider"></div>

        <!-- Sistem -->
        <div class="nav-section-title">Sistem</div>
        <ul class="nav-menu">
            <li>
                <a href="pengaturan.php"
                   class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pengaturan.php' ? 'active' : ''; ?>"
                   data-tooltip="Pengaturan">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M19.4 15C19.1277 15.6171 19.2583 16.3378 19.73 16.82L19.79 16.88C20.1656 17.2551 20.3766 17.7642 20.3766 18.295C20.3766 18.8258 20.1656 19.3349 19.79 19.71C19.4149 20.0856 18.9058 20.2966 18.375 20.2966C17.8442 20.2966 17.3351 20.0856 16.96 19.71L16.9 19.65C16.4178 19.1783 15.6971 19.0477 15.08 19.32C14.4755 19.5791 14.0826 20.1724 14.08 20.83V21C14.08 22.1046 13.1846 23 12.08 23C10.9754 23 10.08 22.1046 10.08 21V20.91C10.0642 20.2327 9.63587 19.6339 9 19.4C8.38291 19.1277 7.66219 19.2583 7.18 19.73L7.12 19.79C6.74486 20.1656 6.23577 20.3766 5.705 20.3766C5.17423 20.3766 4.66514 20.1656 4.29 19.79C3.91445 19.4149 3.70343 18.9058 3.70343 18.375C3.70343 17.8442 3.91445 17.3351 4.29 16.96L4.35 16.9C4.82167 16.4178 4.95231 15.6971 4.68 15.08C4.42093 14.4755 3.82764 14.0826 3.17 14.08H3C1.89543 14.08 1 13.1846 1 12.08C1 10.9754 1.89543 10.08 3 10.08H3.09C3.76728 10.0642 4.36611 9.63587 4.6 9C4.87231 8.38291 4.74167 7.66219 4.27 7.18L4.21 7.12C3.83445 6.74486 3.62343 6.23577 3.62343 5.705C3.62343 5.17423 3.83445 4.66514 4.21 4.29C4.58514 3.91445 5.09423 3.70343 5.625 3.70343C6.15577 3.70343 6.66486 3.91445 7.04 4.29L7.1 4.35C7.58219 4.82167 8.30291 4.95231 8.92 4.68H9C9.60447 4.42093 9.99738 3.82764 10 3.17V3C10 1.89543 10.8954 1 12 1C13.1046 1 14 1.89543 14 3V3.09C14.0026 3.74764 14.3955 4.34093 15 4.6C15.6171 4.87231 16.3378 4.74167 16.82 4.27L16.88 4.21C17.2551 3.83445 17.7642 3.62343 18.295 3.62343C18.8258 3.62343 19.3349 3.83445 19.71 4.21C20.0856 4.58514 20.2966 5.09423 20.2966 5.625C20.2966 6.15577 20.0856 6.66486 19.71 7.04L19.65 7.1C19.1783 7.58219 19.0477 8.30291 19.32 8.92V9C19.5791 9.60447 20.1724 9.99738 20.83 10H21C22.1046 10 23 10.8954 23 12C23 13.1046 22.1046 14 21 14H20.91C20.2524 14.0026 19.6591 14.3955 19.4 15Z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </span>
                    <span class="nav-label">Pengaturan</span>
                </a>
            </li>
        </ul>

        <!-- Footer Profile -->
        <div class="sidebar-footer">
            <div class="nav-divider" style="margin-bottom:14px;"></div>
            <div class="profile-card">
                <div class="profile-avatar">AD</div>
                <div class="profile-info">
                    <div class="profile-name">Administrator</div>
                    <div class="profile-role">Super Admin</div>
                </div>
                <div class="profile-dots">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="5"  r="1.5" fill="currentColor"/>
                        <circle cx="12" cy="12" r="1.5" fill="currentColor"/>
                        <circle cx="12" cy="19" r="1.5" fill="currentColor"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>
</nav>

<script>
(function () {
    const sidebar     = document.getElementById('sidebar');
    const toggleBtn   = document.getElementById('sidebarToggle');
    const closeBtn    = document.getElementById('closeSidebar');
    const overlay     = document.getElementById('sidebarOverlay');
    const mainContent = document.querySelector('.main-content');

    let hoverTimer;

    function isMobile() { return window.innerWidth <= 768; }

    function applyCollapsed(v) {
        sidebar.classList.toggle('collapsed', v);
        mainContent && mainContent.classList.toggle('sidebar-collapsed', v);
        localStorage.setItem('sidebarCollapsed', v);
    }

    function applyHidden(v) {
        sidebar.classList.toggle('hide-sidebar', v);
        mainContent && mainContent.classList.toggle('sidebar-hidden', v);
        localStorage.setItem('sidebarHidden', v);
    }

    function toggleSidebar() {
        if (isMobile()) {
            const isHidden = sidebar.classList.contains('hide-sidebar');
            sidebar.classList.toggle('hide-sidebar', !isHidden);
            overlay.classList.toggle('active', isHidden);
            document.body.style.overflow = isHidden ? 'hidden' : '';
        } else {
            if (sidebar.classList.contains('hide-sidebar')) {
                applyHidden(false);
                if (localStorage.getItem('sidebarCollapsed') === 'true') applyCollapsed(true);
            } else {
                applyHidden(true);
            }
        }
    }

    function initHover() {
        if (isMobile()) return;
        sidebar.addEventListener('mouseenter', () => {
            clearTimeout(hoverTimer);
            if (sidebar.classList.contains('collapsed') && !sidebar.classList.contains('hide-sidebar')) {
                sidebar.classList.remove('collapsed');
                mainContent && mainContent.classList.remove('sidebar-collapsed');
            }
        });
        sidebar.addEventListener('mouseleave', () => {
            clearTimeout(hoverTimer);
            hoverTimer = setTimeout(() => {
                if (!isMobile() && localStorage.getItem('sidebarCollapsed') === 'true') {
                    applyCollapsed(true);
                }
            }, 300);
        });
    }

    toggleBtn && toggleBtn.addEventListener('click', toggleSidebar);
    closeBtn  && closeBtn.addEventListener('click', () => {
        if (isMobile()) {
            sidebar.classList.add('hide-sidebar');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        } else { applyHidden(true); }
    });
    overlay && overlay.addEventListener('click', () => {
        sidebar.classList.add('hide-sidebar');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    function restoreState() {
        if (isMobile()) {
            sidebar.classList.add('hide-sidebar');
            applyCollapsed(false);
            return;
        }
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        const hidden    = localStorage.getItem('sidebarHidden')    === 'true';
        const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        applyHidden(hidden);
        if (!hidden) applyCollapsed(collapsed);
    }

    restoreState();
    initHover();

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(restoreState, 200);
    });
})();
</script>