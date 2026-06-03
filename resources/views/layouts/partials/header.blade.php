@php
    // Mengambil foto dari objek user yang login, jika tidak ada pakai default
    $foto_profil = Auth::user()->foto_profil ?? 'default-avatar.png';
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght=400;500;600;700&display=swap');

    .dashboard-header {
        /* Memperbaiki background agar warna teks gelap di bawah bisa terbaca */
        background: #302929;    
        padding: 10px 20px;
        font-family: 'Poppins', sans-serif;
        height: 70px;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        margin-left: 0;
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    body.sidebar-open .dashboard-header {
        margin-left: 250px;
        width: calc(100% - 250px);
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
        background: #004369;        
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
        color: #3FBBA0;
        white-space: nowrap;
    }

    .header-left .text .on {
        color: #004369;
    }

    .header-center {
        text-align: center;
        flex: 1;
        max-width: 300px;
    }

    .tanggal {
        font-size: 15px;
        font-weight: 600;
        color: #004369;
        line-height: 1.2;
    }

    .waktu {
        font-size: 13px;
        font-weight: 500;
        color: #004369;
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
        color: #004369;
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

    /* Mengaktifkan tampilan foto jika user punya foto asli selain default */
    .has-photo .profile-avatar {
        display: none;
    }

    .has-photo .profile-img {
        display: block;
    }

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
                {{-- Di-render awal oleh server, nanti di-update oleh JS --}}
                @textIndoHari(date('w')), {{ date('d/m/Y') }}
            </div>
            <div class="waktu" id="current-time">
                {{ date('H:i:s') }}
            </div>
        </div>

        <div class="header-right {{ $foto_profil !== 'default-avatar.png' ? 'has-photo' : '' }}">
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;">Keluar</button>
            </form>
            
            <div class="nama"><strong>{{ Auth::user()->nama ?? 'Guest' }}</strong></div>
    
            {{-- Default Avatar (SVG) --}}
            <div class="profile-avatar">
                <svg aria-label="Profil" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>

            {{-- Foto Profil User Sebenarnya (Menggunakan Helper Asset Laravel agar path aman) --}}
            <img class="profile-img" 
                 src="{{ asset('image/' . $foto_profil) }}" 
                 alt="Profil" 
                 onerror="this.onerror=null; this.parentElement.classList.remove('has-photo');">
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
        
        // Memperbaiki string interpolation JavaScript dengan Backtick (`)
        document.getElementById('current-date').textContent = `${dayName}, ${date}/${month}/${year}`;
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Jalankan saat halaman di-load dan set interval per 1 detik
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>