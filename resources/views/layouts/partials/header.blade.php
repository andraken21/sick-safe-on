<?php
$nama_user = $_SESSION['nama_user'] ?? 'Tiara Agnesia';
$foto_profil = $_SESSION['foto_profil'] ?? 'default-avatar.png';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .dashboard-header {
        background: #302929;
        padding: 10px 20px;
        font-family: 'Poppins', sans-serif;
        position: fixed;
        top: 0;
        left: 250px;
        right: 0;
        height: 70px;
        z-index: 1000;
        transition: left 0.3s ease;
    }

    body.sidebar-collapsed .dashboard-header {
        left: 0;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
        width: 100%;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-shrink: 0;
    }

    .sidebar-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 1001;
    }

    .sidebar-toggle span {
        display: block;
        width: 25px;
        height: 3px;
        background: white;
        border-radius: 3px;
        transition: all 0.3s ease;
    }

    .header-left img {
        width: 45px;
        height: 45px;
        object-fit: contain;
    }

    .header-left .text {
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
        white-space: nowrap;
    }

    .header-left .text .on {
        color: #3FBBA0;
    }

    .header-center {
        text-align: center;
        flex: 1;
        max-width: 300px;
    }

    .tanggal {
        font-size: 15px;
        font-weight: 600;
        color: #b1ddff;
        line-height: 1.2;
    }

    .waktu {
        font-size: 13px;
        font-weight: 500;
        color: #b1ddff;
        opacity: 0.9;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .header-right .nama {
        font-size: 0.9rem;
        font-weight: 600;
        color: #3FBBA0;
        white-space: nowrap;
    }

    .profile-wrapper {
        position: relative;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #dbdbdb;
        overflow: hidden;
    }

    .profile-avatar svg {
        width: 28px;
        height: 28px;
        color: #8e8e8e;
    }

    .profile-img {
        width: 35px;
        height: 35px;
        object-fit: cover;
        border-radius: 50%;
        display: none;
    }

    .has-photo .profile-avatar {
        display: none;
    }

    .has-photo .profile-img {
        display: block;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        top: 50px;
        right: 0;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.18);
        min-width: 150px;
        z-index: 9999;
        overflow: hidden;
    }

    .profile-dropdown.show {
        display: block;
    }

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
        gap: 10px;
        transition: background 0.2s;
    }

    .profile-dropdown form button:hover {
        background: #fdecea;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            left: 0 !important;
            padding: 10px 15px;
        }

        .header-left .text {
            display: none;
        }

        .header-center {
            max-width: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .tanggal {
            font-size: 13px;
        }

        .waktu {
            font-size: 11px;
        }

        .header-right .nama {
            display: none;
        }

        .profile-avatar,
        .profile-img {
            width: 32px;
            height: 32px;
        }
    }
</style>

<div class="dashboard-header" id="header">
    <div class="header-row">
        
        <div class="header-left">
            <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <img src="{{ asset('image/logo.png') }}" alt="Logo Sick Safe ON">
            
            <div class="text">
                Sick Safe <span class="on">ON</span>
            </div>
        </div>

        <div class="header-center">
            <div class="tanggal" id="current-date">
                <?php 
                $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                echo $days[date('w')] . ', ' . date('d/m/Y');
                ?>
            </div>
            <div class="waktu" id="current-time">
                <?php echo date('H:i:s'); ?>
            </div>
        </div>

     
        <div class="header-right <?php echo ($foto_profil !== 'default-avatar.png') ? 'has-photo' : ''; ?>">
            <span class="nama"><?php echo htmlspecialchars($nama_user); ?></span>
            
            <div class="profile-wrapper" onclick="toggleDropdown(event)">
                <div class="profile-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                
                <?php if($foto_profil !== 'default-avatar.png'): ?>
                <img class="profile-img" 
                     src="{{ asset('image/' . $foto_profil) }}" 
                     alt="Profile"
                     onerror="this.parentElement.parentElement.classList.remove('has-photo')">
                <?php endif; ?>

                <div class="profile-dropdown" id="profileDropdown">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" 
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
    
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        
        if (sidebar) {
            sidebar.classList.toggle('collapsed');
            body.classList.toggle('sidebar-collapsed');
        }
    }

    function toggleDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('show');
    }


    document.addEventListener('click', function(event) {
        const wrapper = document.querySelector('.profile-wrapper');
        const dropdown = document.getElementById('profileDropdown');
        
        if (wrapper && !wrapper.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });

    function updateDateTime() {
        const now = new Date();
        
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const dayName = days[now.getDay()];
        
        const date = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();
        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('current-date').textContent = `${dayName}, ${date}/${month}/${year}`;
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>