<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap');

    .dashboard-header {
        background: #1e1b1b;
        padding: 0 24px;
        font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
        height: 70px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
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
        gap: 20px;
        flex-shrink: 0;
    }

    .sidebar-toggle {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        cursor: pointer;
        padding: 10px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        transition: all 0.2s ease;
    }

    .sidebar-toggle:hover {
        background: rgba(255,255,255,0.12);
        transform: scale(1.03);
    }

    .sidebar-toggle span {
        display: block;
        width: 20px;
        height: 2px;
        background: #ffffff;
        border-radius: 3px;
    }

    .header-left img.logo {
        width: 40px;
        height: 40px;
        object-fit: contain;
        filter: drop-shadow(0 2px 8px rgba(63,187,160,0.2));
    }

    .header-left .text {
        font-weight: 700;
        font-size: 1.15rem;
        color: #ffffff;
        white-space: nowrap;
        letter-spacing: 0.5px;
    }

    .header-left .text .on { color: #3FBBA0; }

    .header-center {
        text-align: center;
        flex: 1;
        max-width: 320px;
        background: rgba(255,255,255,0.04);
        padding: 6px 16px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,0.05);
    }

    .tanggal {
        font-size: 13.5px;
        font-weight: 600;
        color: #e2f1ff;
    }

    .waktu {
        font-size: 12px;
        font-weight: 500;
        color: #3FBBA0;
        margin-top: 1px;
    }

    .header-right {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        position: relative;
    }

    .profile-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        padding: 6px 12px;
        border-radius: 12px;
        transition: background 0.2s ease;
        user-select: none;
    }

    .profile-wrapper:hover { background: rgba(255,255,255,0.05); }

    .profile-wrapper .nama {
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff;
        white-space: nowrap;
    }

    .profile-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3FBBA0, #2a8874);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(255,255,255,0.1);
        flex-shrink: 0;
    }

    .profile-avatar svg {
        width: 22px;
        height: 22px;
        color: #ffffff;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        top: 55px;
        right: 5px;
        background: #252121;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        min-width: 150px;
        z-index: 99999;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .profile-dropdown.show { display: block !important; }

    .profile-dropdown form button {
        width: 100%;
        padding: 12px 16px;
        background: transparent;
        border: none;
        text-align: left;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 600;
        color: #ff5252;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: background 0.2s;
    }

    .profile-dropdown form button:hover { background: rgba(229,57,53,0.15); }

    @media (max-width: 768px) {
        .dashboard-header { padding: 0 16px; }
        .header-left .text { display: none; }
        .header-center {
            max-width: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: transparent;
            border: none;
            padding: 0;
        }
        .tanggal, .waktu, .profile-wrapper .nama { display: none; }
        .profile-avatar { width: 34px; height: 34px; }
        .profile-dropdown { top: 50px; right: 0; }
    }
</style>

<div class="dashboard-header" id="header">
    <div class="header-row">

        {{-- KIRI: Toggle + Logo --}}
        <div class="header-left">
            <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                <span></span><span></span><span></span>
            </button>
            <img class="logo" src="{{ asset('image/logo.png') }}" alt="Logo Sick Safe ON">
            <div class="text">Sick Safe <span class="on">ON</span></div>
        </div>

        {{-- TENGAH: Tanggal & Jam --}}
        <div class="header-center">
            <div class="tanggal" id="current-date"></div>
            <div class="waktu"   id="current-time"></div>
        </div>

        {{-- KANAN: Profil + Dropdown --}}
        <div class="header-right">
            <div class="profile-wrapper" onclick="toggleDropdown(event)">
                <div class="nama">{{ Auth::user()->nama ?? 'Guest' }}</div>

                {{-- Avatar anonymous selalu tampil --}}
                <div class="profile-avatar">
                    <svg fill="currentColor" viewBox="0 0 24 24" aria-label="Profil">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <div class="profile-dropdown" id="profileDropdown">
                <form action="{{ route('logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function toggleDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) dropdown.classList.toggle('show');
    }

    function updateDateTime() {
        const now  = new Date();
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const d    = String(now.getDate()).padStart(2,'0');
        const m    = String(now.getMonth()+1).padStart(2,'0');
        const y    = now.getFullYear();
        const h    = String(now.getHours()).padStart(2,'0');
        const min  = String(now.getMinutes()).padStart(2,'0');
        const s    = String(now.getSeconds()).padStart(2,'0');

        document.getElementById('current-date').textContent = `${days[now.getDay()]}, ${d}/${m}/${y}`;
        document.getElementById('current-time').textContent = `${h}:${min}:${s}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>