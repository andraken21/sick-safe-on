<?php
// layout/header.php

$nama_user = $_SESSION['nama_user'] ?? 'Tiara Agnesia';
// Foto profil (jika tidak ada, pakai default)
$foto_profil = $_SESSION['foto_profil'] ?? 'default-avatar.png';
?>

<style>
    /* Import Font Poppins */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        overflow-x: hidden;
        /* Mencegah scroll horizontal */
    }

    .dashboard-header {
        background: #292d30;
        padding: 10px 0;
        font-family: 'Poppins', sans-serif;
        width: 100%;
        position: relative;
        left: 0;
        right: 0;
        top: 0;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    /* Kiri - Logo + Sick Safe ON */
    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 200px;
        text-align: left;
        padding-left: 0;
        flex-shrink: 0;
    }

    .header-left img {
        width: 32px;
        height: 32px;
        object-fit: contain;
    }

    .header-left .text {
        font-weight: 700;
        font-size: 1rem;
        color: white;
        white-space: nowrap;
    }

    .header-left .text span {
        font-weight: 500;
        color: #b1ddff;
    }

    /* Tengah - Tanggal & Waktu (2 baris) */
    .header-center {
        min-width: 180px;
        text-align: center;
        flex-shrink: 0;
    }

    .tanggal {
        font-size: 0.8rem;
        font-weight: 600;
        color: #b1ddff;
        line-height: 1.3;
        text-align: center;
        white-space: nowrap;
    }

    .waktu {
        font-size: 0.7rem;
        font-weight: 500;
        color: #b1ddff;
        opacity: 0.9;
        line-height: 1.3;
        text-align: center;
        white-space: nowrap;
    }

    /* Kanan - Nama User + Foto Profil (style ala Instagram) */
    .header-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        min-width: 200px;
        padding-right: 0;
        flex-shrink: 0;
    }

    .header-right .nama {
        font-size: 0.85rem;
        font-weight: 600;
        color: #3FBBA0;
        white-space: nowrap;
    }

    /* Profil Avatar ala Instagram (default avatar) - SIZE DIPERBESAR */
    .profile-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #dbdbdb;
        cursor: pointer;
        overflow: hidden;
        flex-shrink: 0;
    }

    /* SVG Siluet Orang - DIPERBESAR dan FULL di dalam lingkaran */
    .profile-avatar svg {
        width: 28px;
        height: 28px;
        color: #8e8e8e;
        margin-top: 2px;
        /* Sedikit adjust agar terlihat pas di tengah */
    }

    /* Foto profil */
    .header-right .profile-img {
        display: none;
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Jika ada foto profil, tampilkan gambar dan sembunyikan avatar default */
    .header-right.has-photo .profile-avatar {
        display: none;
    }

    .header-right.has-photo .profile-img {
        display: block;
    }

    /* Responsive untuk layar kecil */
    @media (max-width: 768px) {

        .header-left,
        .header-center,
        .header-right {
            min-width: auto;
        }

        .header-left .text {
            font-size: 0.8rem;
        }

        .tanggal {
            font-size: 0.7rem;
        }

        .waktu {
            font-size: 0.6rem;
        }

        .header-right .nama {
            font-size: 0.7rem;
        }

        .profile-avatar,
        .header-right .profile-img {
            width: 28px;
            height: 28px;
        }

        .profile-avatar svg {
            width: 24px;
            height: 24px;
        }
    }
</style>

<div class="dashboard-header">
    <div class="header-row">
        <!-- Kiri: Logo + Sick Safe ON -->
        <div class="header-left">
            <img src="{{ asset('image/logo.png') }}" alt="Logo Saya" width="100">
            <div class="text">Sick <span>Safe</span> ON</div>
        </div>

        <!-- Tengah: Tanggal & Waktu -->
        <div class="header-center">
            <div class="tanggal" id="current-date">
                <?php echo date('l, d/m/Y'); ?>
            </div>
            <div class="waktu" id="current-time">
                <?php echo date('H:i:s'); ?>
            </div>
        </div>

        <!-- Kanan: Nama User + Foto Profil (ala Instagram) -->
        <div class="header-right <?php echo ($foto_profil !== 'default-avatar.png' && file_exists('../public/image/' . $foto_profil)) ? 'has-photo' : ''; ?>">
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Keluar</button>
            </form>
            <div class="nama"><?php echo htmlspecialchars($nama_user); ?></div>

            <!-- Avatar default ala Instagram (siluet orang) - FULL DI LINGKARAN -->
            <div class="profile-avatar">
                <svg aria-label="Profil" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>

            <!-- Gambar profil (jika ada) -->
            <img class="profile-img" src="../public/image/<?php echo $foto_profil; ?>" alt="Profil" onerror="this.onerror=null; this.parentElement.classList.remove('has-photo');">
        </div>
    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();

        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        const dayName = days[now.getDay()];
        const date = now.getDate();
        const month = now.getMonth() + 1;
        const year = now.getFullYear();

        const dateString = `${dayName}, ${date < 10 ? '0' + date : date}/${month < 10 ? '0' + month : month}/${year}`;

        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();

        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        const timeString = `${hours}:${minutes}:${seconds}`;

        document.getElementById('current-date').innerText = dateString;
        document.getElementById('current-time').innerText = timeString;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Handle error untuk gambar profil
    document.querySelectorAll('.profile-img').forEach(img => {
        img.addEventListener('error', function() {
            this.parentElement.classList.remove('has-photo');
        });
    });
</script>