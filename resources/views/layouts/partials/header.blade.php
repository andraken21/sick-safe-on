<?php
// layout/header.php

$nama_user = $_SESSION['nama_user'] ?? 'Tiara Agnesia';
$foto_profil = $_SESSION['foto_profil'] ?? 'default-avatar.png';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { overflow-x: hidden; }

    .dashboard-header {
        background: #302929;
        padding: 10px 0;
        font-family: 'Poppins', sans-serif;
        width: 100%;
        position: relative;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    /* ── KIRI: Tombol Sidebar + Logo ── */
    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 200px;
        padding-left: 15px;
        flex-shrink: 0;
    }

    /* Tombol sidebar (hamburger) */
    .sidebar-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex-shrink: 0;
    }

    .sidebar-toggle span {
        display: block;
        width: 22px;
        height: 2px;
        background: white;
        border-radius: 2px;
    }

    .header-left img {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    /* Tulisan Sick Safe ON — hanya ON berwarna */
    .header-left .text {
        font-weight: 700;
        font-size: 1rem;
        color: white;
        white-space: nowrap;
    }

    .header-left .text .on {
        font-weight: 700;
        color: #b1ddff;  /* hanya ON yang berwarna */
    }

    /* ── TENGAH ── */
    .header-center {
        min-width: 180px;
        text-align: center;
        flex-shrink: 0;
    }

    .tanggal {
        font-size: 15px;
        font-weight: 600;
        color: #b1ddff;
        line-height: 1.3;
        white-space: nowrap;
    }

    .waktu {
        font-size: 14px;
        font-weight: 500;
        color: #b1ddff;
        opacity: 0.9;
        line-height: 1.3;
        white-space: nowrap;
    }

    /* ── KANAN: Nama + Profil (dengan dropdown) ── */
    .header-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        min-width: 200px;
        padding-right: 15px;
        flex-shrink: 0;
        position: relative;
    }

    .header-right .nama {
        font-size: 0.85rem;
        font-weight: 600;
        color: #3FBBA0;
        white-space: nowrap;
    }

    /* Wrapper profil + dropdown */
    .profile-wrapper {
        position: relative;
        cursor: pointer;
    }

    .profile-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #dbdbdb;
        overflow: hidden;
        flex-shrink: 0;
    }

    .profile-avatar svg {
        width: 28px;
        height: 28px;
        color: #8e8e8e;
        margin-top: 2px;
    }

    .header-right .profile-img {
        display: none;
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .header-right.has-photo .profile-avatar { display: none; }
    .header-right.has-photo .profile-img { display: block; }

    /* Dropdown menu */
    .profile-dropdown {
        display: none;
        position: absolute;
        top: 42px;
        right: 0;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.18);
        min-width: 140px;
        z-index: 999;
        overflow: hidden;
    }

    .profile-dropdown.show { display: block; }

    .profile-dropdown form button {
        width: 100%;
        padding: 12px 18px;
        background: none;
        border: none;
        text-align: left;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #e53935;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-dropdown form button:hover { background: #fdecea; }

    /* Responsive */
    @media (max-width: 768px) {
        .header-left, .header-center, .header-right { min-width: auto; }
        .header-left .text { font-size: 0.8rem; }
        .tanggal { font-size: 0.7rem; }
        .waktu { font-size: 0.6rem; }
        .header-right .nama { font-size: 0.7rem; }
        .profile-avatar, .header-right .profile-img { width: 28px; height: 28px; }
        .profile-avatar svg { width: 24px; height: 24px; }
    }
</style>

<div class="dashboard-header">
    <div class="header-row">

        <!-- KIRI: Tombol Sidebar → Logo → Tulisan -->
        <div class="header-left">
            <!-- Tombol sidebar dulu -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Logo -->
            <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50">

            <!-- Tulisan: Sick Safe berwarna putih, ON berwarna biru -->
            <div class="text">Sick Safe <span class="on">ON</span></div>
        </div>

        <!-- TENGAH: Tanggal & Waktu -->
        <div class="header-center">
            <div class="tanggal" id="current-date">
                <?php echo date('l, d/m/Y'); ?>
            </div>
            <div class="waktu" id="current-time">
                <?php echo date('H:i:s'); ?>
            </div>
        </div>

        <!-- KANAN: Nama + Profil (klik profil → muncul dropdown Keluar) -->
        <div class="header-right <?php echo ($foto_profil !== 'default-avatar.png' && file_exists('../public/image/' . $foto_profil)) ? 'has-photo' : ''; ?>">
            <div class="nama"><?php echo htmlspecialchars($nama_user); ?></div>

            <div class="profile-wrapper" onclick="toggleDropdown()">
                <!-- Avatar default -->
                <div class="profile-avatar">
                    <svg aria-label="Profil" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>

                <!-- Foto profil (jika ada) -->
                <img class="profile-img"
                     src="../public/image/<?php echo $foto_profil; ?>"
                     alt="Profil"
                     onerror="this.onerror=null; this.parentElement.parentElement.classList.remove('has-photo');">

                <!-- Dropdown Keluar -->
                <div class="profile-dropdown" id="profileDropdown">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit">
                            <!-- Ikon keluar -->
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Dropdown profil
    function toggleDropdown() {
        const dd = document.getElementById('profileDropdown');
        dd.classList.toggle('show');
    }

    // Klik di luar dropdown → tutup
    document.addEventListener('click', function(e) {
        const wrapper = document.querySelector('.profile-wrapper');
        const dd = document.getElementById('profileDropdown');
        if (wrapper && !wrapper.contains(e.target)) {
            dd.classList.remove('show');
        }
    });

    // Fungsi toggle sidebar (sesuaikan dengan fungsi sidebar proyekmu)
    function toggleSidebar() {
        // Sesuaikan dengan cara sidebar kamu bekerja
        // Contoh: document.getElementById('sidebar').classList.toggle('active');
    }

    // Update tanggal & waktu
    function updateDateTime() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const dayName = days[now.getDay()];
        const date = now.getDate();
        const month = now.getMonth() + 1;
        const year = now.getFullYear();
        const dateString = `${dayName}, ${date < 10 ? '0'+date : date}/${month < 10 ? '0'+month : month}/${year}`;

        let h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
        h = h < 10 ? '0'+h : h;
        m = m < 10 ? '0'+m : m;
        s = s < 10 ? '0'+s : s;

        document.getElementById('current-date').innerText = dateString;
        document.getElementById('current-time').innerText = `${h}:${m}:${s}`;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>