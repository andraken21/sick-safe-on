<?php
// layout/header.php

$nama_user = $_SESSION['nama_user'] ?? 'Tiara Agnesia';
// Foto profil (jika tidak ada, pakai default)
$foto_profil = $_SESSION['foto_profil'] ?? 'default-avatar.png';
?>

<style>
    /* Import Font Poppins */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .dashboard-header {
        background: #292d30;
        padding: 10px 24px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-family: 'Poppins', sans-serif;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Kiri - Logo + Sick Safe ON */
    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 200px;
        text-align: left;
    }

    .header-left img {
        width: 32px;
        height: 32px;
        object-fit: contain;
        border-radius: 8px;
    }

    .header-left .text {
        font-weight: 700;
        font-size: 1rem;
        color: white;
    }

    .header-left .text span {
        font-weight: 500;
        color: #b1ddff;
    }

    /* Tengah - Tanggal & Waktu (2 baris) */
    .header-center {
        width: 180px;
        text-align: center;
    }

    .tanggal {
        font-size: 0.8rem;
        font-weight: 600;
        color: #b1ddff;
        line-height: 1.3;
        text-align: center;
    }

    .waktu {
        font-size: 0.7rem;
        font-weight: 500;
        color: #b1ddff;
        opacity: 0.9;
        line-height: 1.3;
        text-align: center;
    }

    /* Kanan - Nama User + Foto Profil */
    .header-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        width: 200px;
    }

    .header-right .nama {
        font-size: 0.85rem;
        font-weight: 600;
        color: #3FBBA0;
    }

    .header-right img {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 50%;
        background-color: #b1ddff;
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

        <!-- Kanan: Nama User (dulu) + Foto Profil (setelahnya) -->
        <div class="header-right">
            <div class="nama"><?php echo htmlspecialchars($nama_user); ?></div>
            <img src="../public/image/<?php echo $foto_profil; ?>" alt="Profil" onerror="this.src='../public/image/default-avatar.png'">
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
</script>