<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Resep | SickSafe ON</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --tosca:       #2BBCB0;
            --tosca-light: #3DD5C8;
            --tosca-pale:  #E6F9F8;
            --navy:        #0D2B55;
            --navy-mid:    #1A3D6E;
            --blue:        #2F80ED;
            --blue-light:  #56A3F5;
            --blue-pale:   #EBF4FF;
            --white:       #FFFFFF;
            --off-white:   #F5FAFD;
            --gray-100:    #EEF3F8;
            --gray-300:    #C5D3E2;
            --gray-500:    #7A94B0;
            --gray-700:    #3D5470;
            --green:       #1B8A60;
            --green-pale:  #E6FAF4;
            --orange:      #E07B2B;
            --orange-pale: #FFF4E6;
            --red:         #D93025;
            --red-pale:    #FFEBEA;
            --shadow-sm:   0 2px 8px rgba(13,43,85,.08);
            --shadow-md:   0 6px 24px rgba(13,43,85,.13);
            --shadow-lg:   0 16px 48px rgba(13,43,85,.18);
            --radius-sm:   8px;
            --radius-md:   14px;
            --radius-lg:   22px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--off-white); color: var(--navy); min-height: 100vh; }

        /* ===================== SIDEBAR ===================== */
        .sidebar { position: fixed; top: 0; left: 0; width: 260px; height: 100vh; background: var(--navy); display: flex; flex-direction: column; z-index: 100; box-shadow: var(--shadow-lg); }
        .sidebar-brand { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar-brand .logo-mark { width: 42px; height: 42px; background: linear-gradient(135deg, var(--tosca), var(--blue)); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff; margin-bottom: 12px; }
        .sidebar-brand h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; font-weight: 800; color: var(--white); line-height: 1.2; }
        .sidebar-brand span { color: var(--tosca-light); }
        .sidebar-section-label { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--gray-500); padding: 20px 24px 8px; }
        .sidebar-nav { flex: 1; overflow-y: auto; padding-bottom: 16px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 24px; font-size: 14px; font-weight: 500; color: var(--gray-300); cursor: pointer; text-decoration: none; transition: all .2s; border-left: 3px solid transparent; }
        .nav-item i { font-size: 17px; width: 20px; text-align: center; }
        .nav-item:hover { color: var(--white); background: rgba(255,255,255,.05); }
        .nav-item.active { color: var(--tosca-light); background: rgba(43,188,176,.1); border-left-color: var(--tosca-light); }
        .sidebar-footer { padding: 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .doctor-profile { display: flex; align-items: center; gap: 12px; }
        .doctor-avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--tosca), var(--blue)); display: flex; align-items: center; justify-content: center; font-size: 15px; color: #fff; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; flex-shrink: 0; }
        .doctor-info .name { font-size: 13px; font-weight: 600; color: var(--white); }
        .doctor-info .role { font-size: 11px; color: var(--tosca-light); }

        /* ===================== MAIN ===================== */
        .main { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { position: sticky; top: 0; z-index: 50; background: rgba(245,250,253,.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--gray-100); padding: 14px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-500); }
        .topbar-breadcrumb .current { color: var(--navy); font-weight: 600; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .topbar-btn { width: 38px; height: 38px; border-radius: 10px; border: 1px solid var(--gray-100); background: var(--white); display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--gray-700); font-size: 17px; transition: all .2s; position: relative; }
        .topbar-btn:hover { border-color: var(--tosca); color: var(--tosca); }
        .badge-dot { position: absolute; top: 7px; right: 7px; width: 8px; height: 8px; border-radius: 50%; background: var(--tosca); border: 2px solid var(--off-white); }
        .page-content { padding: 32px; flex: 1; }

        /* ===================== PAGE HEADER ===================== */
        .page-header { margin-bottom: 28px; }
        .page-header-inner { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
        .page-header h2 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; color: var(--navy); }
        .page-header p { font-size: 14px; color: var(--gray-500); margin-top: 4px; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: var(--radius-sm); border: 1.5px solid var(--gray-300); background: var(--white); color: var(--gray-700); font-size: 13px; font-weight: 600; text-decoration: none; transition: all .2s; }
        .btn-back:hover { border-color: var(--navy); color: var(--navy); }

        /* ===================== PATIENT INFO CARD ===================== */
        .patient-info-card { background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%); border-radius: var(--radius-md); padding: 24px 28px; margin-bottom: 24px; display: flex; align-items: center; gap: 20px; box-shadow: var(--shadow-md); position: relative; overflow: hidden; }
        .patient-info-card::before { content: ''; position: absolute; right: -30px; top: -30px; width: 150px; height: 150px; border-radius: 50%; background: rgba(43,188,176,.12); }
        .patient-info-card::after  { content: ''; position: absolute; right: 60px; bottom: -40px; width: 100px; height: 100px; border-radius: 50%; background: rgba(47,128,237,.1); }
        .patient-big-avatar { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, var(--tosca), var(--blue)); display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: #fff; flex-shrink: 0; border: 3px solid rgba(255,255,255,.2); }
        .patient-info-text { flex: 1; }
        .patient-info-text .pat-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: #fff; }
        .patient-info-text .pat-meta { display: flex; align-items: center; gap: 16px; margin-top: 6px; flex-wrap: wrap; }
        .pat-meta-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: rgba(255,255,255,.7); }
        .pat-meta-item i { color: var(--tosca-light); }
        .patient-info-badges { display: flex; gap: 8px; flex-wrap: wrap; }
        .info-badge { padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1.5px solid rgba(255,255,255,.15); color: rgba(255,255,255,.85); background: rgba(255,255,255,.08); }
        .info-badge.active { background: rgba(27,138,96,.25); border-color: rgba(27,138,96,.4); color: #4DEBA3; }
        .kode-resep-badge { display: flex; align-items: center; gap: 8px; background: rgba(43,188,176,.15); border: 1px solid rgba(43,188,176,.3); border-radius: var(--radius-sm); padding: 8px 16px; }
        .kode-resep-badge .label { font-size: 11px; color: rgba(255,255,255,.6); font-weight: 500; }
        .kode-resep-badge .kode { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; color: var(--tosca-light); letter-spacing: .04em; }

        /* ===================== FORM LAYOUT ===================== */
        .form-grid { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
        @media (max-width: 1000px) { .form-grid { grid-template-columns: 1fr; } }

        /* ===================== SECTION CARDS ===================== */
        .section-card { background: var(--white); border: 1px solid var(--gray-100); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); margin-bottom: 20px; overflow: hidden; }
        .section-card-header { padding: 16px 24px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; gap: 10px; }
        .section-card-header .icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 15px; }
        .icon-tosca { background: var(--tosca-pale); color: var(--tosca); }
        .icon-blue  { background: var(--blue-pale); color: var(--blue); }
        .icon-navy  { background: rgba(13,43,85,.07); color: var(--navy-mid); }
        .section-card-header h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--navy); }
        .section-card-body { padding: 20px 24px; }

        /* ===================== FORM ELEMENTS ===================== */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .form-row.single { grid-template-columns: 1fr; }
        .form-row.triple { grid-template-columns: 1fr 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group:last-child { margin-bottom: 0; }
        label { font-size: 12px; font-weight: 700; color: var(--gray-700); letter-spacing: .04em; text-transform: uppercase; }
        label .req { color: var(--red); }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea,
        select { width: 100%; padding: 10px 14px; border: 1.5px solid var(--gray-100); border-radius: var(--radius-sm); font-size: 14px; font-family: 'DM Sans', sans-serif; color: var(--navy); background: var(--off-white); outline: none; transition: border-color .2s, background .2s; }
        input:focus, textarea:focus, select:focus { border-color: var(--tosca); background: var(--white); }
        input::placeholder, textarea::placeholder { color: var(--gray-500); }
        textarea { resize: vertical; min-height: 80px; }
        select { cursor: pointer; }
        .field-hint { font-size: 11px; color: var(--gray-500); margin-top: 2px; }

        /* ===================== OBAT TABLE ===================== */
        .obat-section { margin-bottom: 0; }
        .obat-table-wrap { overflow-x: auto; }
        .obat-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .obat-table thead tr { background: var(--gray-100); }
        .obat-table th { padding: 10px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--gray-500); white-space: nowrap; }
        .obat-table td { padding: 10px 14px; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        .obat-table tbody tr:last-child td { border-bottom: none; }
        .obat-table tbody tr:hover { background: #FAFCFE; }
        .obat-table input, .obat-table select { padding: 7px 10px; font-size: 13px; }
        .obat-table .col-no   { width: 40px; text-align: center; color: var(--gray-500); font-weight: 600; }
        .obat-table .col-nama { min-width: 200px; }
        .obat-table .col-dosis{ width: 120px; }
        .obat-table .col-jml  { width: 80px; }
        .obat-table .col-sat  { width: 110px; }
        .obat-table .col-aturan{ min-width: 160px; }
        .obat-table .col-ket  { min-width: 140px; }
        .obat-table .col-del  { width: 44px; text-align: center; }
        .btn-del-row { width: 30px; height: 30px; border-radius: 7px; border: none; background: var(--red-pale); color: var(--red); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; transition: background .15s; margin: 0 auto; }
        .btn-del-row:hover { background: #FFCFCC; }
        .obat-footer { padding: 14px 20px; border-top: 1px solid var(--gray-100); display: flex; align-items: center; gap: 12px; }
        .btn-add-obat { display: inline-flex; align-items: center; gap: 8px; padding: 8px 18px; border-radius: var(--radius-sm); border: 1.5px dashed var(--tosca); color: var(--tosca); background: transparent; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn-add-obat:hover { background: var(--tosca-pale); }
        .obat-count-badge { font-size: 12px; color: var(--gray-500); }
        .obat-count-badge span { font-weight: 700; color: var(--navy); }

        /* ===================== SIDE PANEL ===================== */
        .side-panel { display: flex; flex-direction: column; gap: 20px; }

        /* Ringkasan */
        .ringkasan-card { background: var(--white); border: 1px solid var(--gray-100); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow: hidden; }
        .ringkasan-header { padding: 14px 20px; background: var(--navy); display: flex; align-items: center; gap: 8px; }
        .ringkasan-header h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: #fff; }
        .ringkasan-header i { color: var(--tosca-light); font-size: 16px; }
        .ringkasan-body { padding: 18px 20px; }
        .ringkasan-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; padding: 8px 0; border-bottom: 1px solid var(--gray-100); }
        .ringkasan-row:last-child { border-bottom: none; }
        .ringkasan-row .rk-label { font-size: 12px; color: var(--gray-500); font-weight: 500; }
        .ringkasan-row .rk-value { font-size: 13px; color: var(--navy); font-weight: 600; text-align: right; max-width: 60%; }
        .ringkasan-obat-count { display: flex; align-items: center; justify-content: space-between; background: var(--tosca-pale); border-radius: var(--radius-sm); padding: 10px 14px; margin-top: 12px; }
        .ringkasan-obat-count .label { font-size: 12px; color: var(--tosca); font-weight: 600; }
        .ringkasan-obat-count .count { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--tosca); }

        /* Riwayat Penyakit */
        .riwayat-box { background: var(--orange-pale); border: 1px solid rgba(224,123,43,.25); border-radius: var(--radius-sm); padding: 14px; margin-top: 4px; }
        .riwayat-box .rw-title { font-size: 11px; font-weight: 700; color: var(--orange); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
        .riwayat-box .rw-text { font-size: 13px; color: var(--gray-700); line-height: 1.6; }
        .riwayat-box .rw-empty { font-size: 13px; color: var(--gray-500); font-style: italic; }

        /* Alergi warning */
        .alergi-box { background: var(--red-pale); border: 1px solid rgba(217,48,37,.2); border-radius: var(--radius-sm); padding: 14px; }
        .alergi-box .al-title { font-size: 11px; font-weight: 700; color: var(--red); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
        .alergi-box .al-text { font-size: 13px; color: var(--gray-700); line-height: 1.6; }
        .alergi-box .al-empty { font-size: 13px; color: var(--gray-500); font-style: italic; }

        /* ===================== ACTION BUTTONS ===================== */
        .action-card { background: var(--white); border: 1px solid var(--gray-100); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 20px; display: flex; flex-direction: column; gap: 10px; }
        .btn-submit { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; border-radius: var(--radius-sm); background: linear-gradient(135deg, var(--tosca), var(--blue)); color: var(--white); font-size: 14px; font-weight: 700; border: none; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: opacity .2s, transform .15s; box-shadow: 0 4px 14px rgba(43,188,176,.35); }
        .btn-submit:hover { opacity: .92; transform: translateY(-1px); }
        .btn-draft { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 11px; border-radius: var(--radius-sm); background: var(--off-white); color: var(--gray-700); font-size: 13px; font-weight: 600; border: 1.5px solid var(--gray-300); cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all .2s; }
        .btn-draft:hover { border-color: var(--gray-500); color: var(--navy); }
        .btn-batal { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 10px; border-radius: var(--radius-sm); background: transparent; color: var(--red); font-size: 13px; font-weight: 600; border: 1.5px solid rgba(217,48,37,.25); cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all .2s; text-decoration: none; }
        .btn-batal:hover { background: var(--red-pale); }

        /* Toast */
        #toast { position: fixed; bottom: 28px; right: 28px; background: var(--navy); color: #fff; padding: 12px 20px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 10px; box-shadow: var(--shadow-md); opacity: 0; transform: translateY(12px); transition: all .3s; pointer-events: none; z-index: 9999; }
        #toast.show { opacity: 1; transform: translateY(0); }
        #toast i { color: var(--tosca-light); font-size: 16px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .page-content { padding: 20px 16px; }
            .form-row { grid-template-columns: 1fr; }
            .form-row.triple { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- ===================== SIDEBAR ===================== --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-mark"><i class="bi bi-heart-pulse-fill"></i></div>
        <h1>SickSafe<span> ON</span></h1>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Menu Utama</div>
        <a href="{{ route('dokter.dashboard') }}" class="nav-item"><i class="bi bi-grid-fill"></i> Dashboard</a>
        <a href="{{ route('dokter.pilih-pasien') }}" class="nav-item"><i class="bi bi-people-fill"></i> Pilih Pasien</a>
        <a href="#" class="nav-item active"><i class="bi bi-file-medical-fill"></i> Buat Resep</a>
        <a href="{{ route('dokter.resep.index') }}" class="nav-item"><i class="bi bi-pencil-square"></i> Daftar Resep</a>
        <div class="sidebar-section-label">Monitoring</div>
        <a href="#" class="nav-item"><i class="bi bi-activity"></i> Konsumsi Obat Pasien</a>
        <a href="#" class="nav-item"><i class="bi bi-bar-chart-fill"></i> Riwayat Kunjungan</a>
        <div class="sidebar-section-label">Akun</div>
        <a href="#" class="nav-item"><i class="bi bi-person-fill"></i> Profil Saya</a>
        <a href="{{ route('logout') }}" class="nav-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </nav>
    <div class="sidebar-footer">
        <div class="doctor-profile">
            <div class="doctor-avatar">{{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}</div>
            <div class="doctor-info">
                <div class="name">{{ Auth::user()->nama }}</div>
                <div class="role">Dokter</div>
            </div>
        </div>
    </div>
</aside>

{{-- ===================== MAIN ===================== --}}
<div class="main">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="topbar-breadcrumb">
            <i class="bi bi-house"></i>
            <i class="bi bi-chevron-right" style="font-size:10px"></i>
            <span>Dokter</span>
            <i class="bi bi-chevron-right" style="font-size:10px"></i>
            <a href="{{ route('dokter.pilih-pasien') }}" style="color:var(--gray-500);text-decoration:none;">Pilih Pasien</a>
            <i class="bi bi-chevron-right" style="font-size:10px"></i>
            <span class="current">Buat Resep</span>
        </div>
        <div class="topbar-actions">
            <div class="topbar-btn">
                <i class="bi bi-bell"></i>
                <span class="badge-dot"></span>
            </div>
        </div>
    </div>

    <div class="page-content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header-inner">
                <div>
                    <h2>Buat Resep</h2>
                    <p>Isi formulir resep untuk pasien yang dipilih — {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <a href="{{ route('dokter.pilih-pasien') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Ganti Pasien
                </a>
            </div>
        </div>

        {{-- Patient Info Banner --}}
        <div class="patient-info-card">
            <div class="patient-big-avatar">
                {{ strtoupper(substr($pasien->user?->nama ?? 'P', 0, 2)) }}
            </div>
            <div class="patient-info-text">
                <div class="pat-name">{{ $pasien->user?->nama ?? '-' }}</div>
                <div class="pat-meta">
                    <div class="pat-meta-item">
                        <i class="bi bi-credit-card-2-front"></i>
                        BPJS: {{ $pasien->No_BPJS ?? '-' }}
                    </div>
                    <div class="pat-meta-item">
                        <i class="bi bi-gender-{{ $pasien->Jenis_kelamin == 'Perempuan' ? 'female' : 'male' }}"></i>
                        {{ $pasien->Jenis_kelamin ?? '-' }}
                    </div>
                    <div class="pat-meta-item">
                        <i class="bi bi-calendar3"></i>
                        {{ \Carbon\Carbon::parse($pasien->Tanggal_Lahir)->format('d M Y') }}
                        ({{ \Carbon\Carbon::parse($pasien->Tanggal_Lahir)->age }} thn)
                    </div>
                    <div class="pat-meta-item">
                        <i class="bi bi-telephone"></i>
                        {{ $pasien->user?->no_telp ?? '-' }}
                    </div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;align-items:flex-end;flex-shrink:0;">
                <div class="patient-info-badges">
                    @if(($pasien->user?->status ?? '') == 'aktif')
                        <span class="info-badge active"><i class="bi bi-circle-fill" style="font-size:8px"></i> Aktif</span>
                    @else
                        <span class="info-badge">Non-aktif</span>
                    @endif
                    <span class="info-badge">#PAT-{{ str_pad($pasien->ID_Pasien, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="kode-resep-badge">
                    <div>
                        <div class="label">Kode Resep</div>
                        <div class="kode" id="kodeResepDisplay">{{ $kodeResep }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <form id="formResep" method="POST" action="{{ route('dokter.resep.store') }}">
            @csrf
            <input type="hidden" name="id_pasien" value="{{ $pasien->ID_Pasien }}">
            <input type="hidden" name="kode_resep" value="{{ $kodeResep }}">
            <input type="hidden" name="status" value="terkirim" id="inputStatus">

            <div class="form-grid">

                {{-- LEFT COLUMN --}}
                <div>

                    {{-- Keluhan & Diagnosa --}}
                    <div class="section-card">
                        <div class="section-card-header">
                            <div class="icon icon-tosca"><i class="bi bi-clipboard2-pulse-fill"></i></div>
                            <h3>Keluhan & Diagnosa</h3>
                        </div>
                        <div class="section-card-body">
                            <div class="form-row single" style="margin-bottom:16px">
                                <div class="form-group">
                                    <label>Keluhan Utama <span class="req">*</span></label>
                                    <textarea name="keluhan" placeholder="Tuliskan keluhan yang disampaikan pasien..." required>{{ old('keluhan') }}</textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Kode Diagnosa (ICD-10)</label>
                                    <input type="text" name="kode_diagnosa" placeholder="Cth: J00, A09, K21.0" value="{{ old('kode_diagnosa') }}">
                                    <span class="field-hint">Opsional — isi kode ICD-10 jika tersedia</span>
                                </div>
                                <div class="form-group">
                                    <label>Nama Diagnosa <span class="req">*</span></label>
                                    <input type="text" name="nama_diagnosa" placeholder="Cth: Infeksi Saluran Napas Atas" value="{{ old('nama_diagnosa') }}" required>
                                </div>
                            </div>
                            <div class="form-row single" style="margin-bottom:0">
                                <div class="form-group">
                                    <label>Catatan Tambahan</label>
                                    <textarea name="catatan" placeholder="Catatan untuk apoteker atau pasien..." style="min-height:64px">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Obat --}}
                    <div class="section-card obat-section">
                        <div class="section-card-header">
                            <div class="icon icon-blue"><i class="bi bi-capsule-pill"></i></div>
                            <h3>Daftar Obat</h3>
                        </div>
                        <div class="obat-table-wrap">
                            <table class="obat-table">
                                <thead>
                                    <tr>
                                        <th class="col-no">#</th>
                                        <th class="col-nama">Nama Obat</th>
                                        <th class="col-dosis">Dosis</th>
                                        <th class="col-jml">Jumlah</th>
                                        <th class="col-sat">Satuan</th>
                                        <th class="col-aturan">Aturan Pakai</th>
                                        <th class="col-ket">Keterangan</th>
                                        <th class="col-del"></th>
                                    </tr>
                                </thead>
                                <tbody id="obatTableBody">
                                    {{-- Rows generated by JS --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="obat-footer">
                            <button type="button" class="btn-add-obat" id="btnAddObat">
                                <i class="bi bi-plus-circle"></i> Tambah Obat
                            </button>
                            <span class="obat-count-badge">Total: <span id="obatCountDisplay">0</span> item</span>
                        </div>
                    </div>

                </div>
                {{-- /LEFT --}}

                {{-- RIGHT COLUMN (side panel) --}}
                <div class="side-panel">

                    {{-- Ringkasan Resep --}}
                    <div class="ringkasan-card">
                        <div class="ringkasan-header">
                            <i class="bi bi-receipt"></i>
                            <h3>Ringkasan Resep</h3>
                        </div>
                        <div class="ringkasan-body">
                            <div class="ringkasan-row">
                                <span class="rk-label">Pasien</span>
                                <span class="rk-value">{{ $pasien->user?->nama ?? '-' }}</span>
                            </div>
                            <div class="ringkasan-row">
                                <span class="rk-label">Dokter</span>
                                <span class="rk-value">{{ Auth::user()->nama }}</span>
                            </div>
                            <div class="ringkasan-row">
                                <span class="rk-label">Tanggal</span>
                                <span class="rk-value">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
                            </div>
                            <div class="ringkasan-row">
                                <span class="rk-label">Diagnosa</span>
                                <span class="rk-value" id="rkDiagnosa" style="color:var(--gray-500);font-weight:400;font-style:italic">Belum diisi</span>
                            </div>
                            <div class="ringkasan-obat-count">
                                <span class="label"><i class="bi bi-capsule-pill"></i> Jenis Obat</span>
                                <span class="count" id="rkObatCount">0</span>
                            </div>
                        </div>
                    </div>

                    {{-- Riwayat Penyakit --}}
                    <div class="section-card">
                        <div class="section-card-header">
                            <div class="icon icon-navy"><i class="bi bi-clock-history"></i></div>
                            <h3>Riwayat Penyakit</h3>
                        </div>
                        <div class="section-card-body" style="padding-top:14px;padding-bottom:14px;">
                            <div class="riwayat-box">
                                <div class="rw-title"><i class="bi bi-exclamation-triangle-fill"></i> Perhatian</div>
                                @if($pasien->Riwayat_Penyakit)
                                    <div class="rw-text">{{ $pasien->Riwayat_Penyakit }}</div>
                                @else
                                    <div class="rw-empty">Tidak ada riwayat penyakit tercatat.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Alergi --}}
                    <div class="section-card">
                        <div class="section-card-header">
                            <div class="icon" style="background:var(--red-pale);color:var(--red)"><i class="bi bi-shield-exclamation"></i></div>
                            <h3>Alergi Obat</h3>
                        </div>
                        <div class="section-card-body" style="padding-top:14px;padding-bottom:14px;">
                            <div class="alergi-box">
                                <div class="al-title"><i class="bi bi-exclamation-octagon-fill"></i> Perhatian</div>
                                @if($pasien->alergi ?? false)
                                    <div class="al-text">{{ $pasien->alergi }}</div>
                                @else
                                    <div class="al-empty">Tidak ada riwayat alergi tercatat.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="action-card">
                        <button type="submit" class="btn-submit" id="btnKirim">
                            <i class="bi bi-send-fill"></i> Kirim ke Apoteker
                        </button>
                        <button type="button" class="btn-draft" id="btnDraft">
                            <i class="bi bi-floppy-fill"></i> Simpan sebagai Draft
                        </button>
                        <a href="{{ route('dokter.pilih-pasien') }}" class="btn-batal">
                            <i class="bi bi-x-circle"></i> Batalkan
                        </a>
                    </div>

                </div>
                {{-- /RIGHT --}}

            </div>
        </form>

    </div>{{-- /page-content --}}
</div>{{-- /main --}}

{{-- Toast --}}
<div id="toast"><i class="bi bi-check-circle-fill"></i> <span id="toastMsg"></span></div>

<script>
/* ============================================================
   OBAT TABLE — Dynamic rows
   ============================================================ */
const tbody       = document.getElementById('obatTableBody');
const btnAdd      = document.getElementById('btnAddObat');
const countDisp   = document.getElementById('obatCountDisplay');
const rkCount     = document.getElementById('rkObatCount');

const satuan   = ['Tablet','Kapsul','Sirup (ml)','Injeksi (ml)','Tetes','Salep (gr)','Sachet','Suppositoria'];
const aturan   = ['1x1','2x1','3x1','4x1','Tiap 6 jam','Tiap 8 jam','Tiap 12 jam','1x sehari','Sesuai kebutuhan'];

let rowCount = 0;

function updateCount() {
    const n = tbody.querySelectorAll('tr').length;
    countDisp.textContent = n;
    rkCount.textContent   = n;
}

function addRow(data = {}) {
    rowCount++;
    const idx = rowCount;
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td class="col-no">${tbody.querySelectorAll('tr').length + 1}</td>
        <td class="col-nama">
            <input type="text" name="obat[${idx}][nama_obat]" placeholder="Nama obat..." required value="${data.nama_obat ?? ''}">
        </td>
        <td class="col-dosis">
            <input type="text" name="obat[${idx}][dosis]" placeholder="Cth: 500 mg" value="${data.dosis ?? ''}">
        </td>
        <td class="col-jml">
            <input type="number" name="obat[${idx}][jumlah]" placeholder="0" min="1" value="${data.jumlah ?? ''}">
        </td>
        <td class="col-sat">
            <select name="obat[${idx}][satuan]">
                ${satuan.map(s => `<option ${(data.satuan===s)?'selected':''}>${s}</option>`).join('')}
            </select>
        </td>
        <td class="col-aturan">
            <select name="obat[${idx}][aturan_pakai]">
                ${aturan.map(a => `<option ${(data.aturan_pakai===a)?'selected':''}>${a}</option>`).join('')}
            </select>
        </td>
        <td class="col-ket">
            <input type="text" name="obat[${idx}][keterangan]" placeholder="Ket. tambahan..." value="${data.keterangan ?? ''}">
        </td>
        <td class="col-del">
            <button type="button" class="btn-del-row" title="Hapus baris">
                <i class="bi bi-trash3"></i>
            </button>
        </td>
    `;
    tr.querySelector('.btn-del-row').addEventListener('click', () => {
        tr.remove();
        renumberRows();
        updateCount();
    });
    tbody.appendChild(tr);
    updateCount();
}

function renumberRows() {
    tbody.querySelectorAll('tr').forEach((tr, i) => {
        tr.querySelector('.col-no').textContent = i + 1;
    });
}

// Start with 1 row
addRow();
btnAdd.addEventListener('click', () => addRow());

/* ============================================================
   Live Ringkasan — diagnosa preview
   ============================================================ */
const diagInput = document.querySelector('input[name="nama_diagnosa"]');
const rkDiag    = document.getElementById('rkDiagnosa');
diagInput.addEventListener('input', () => {
    if (diagInput.value.trim()) {
        rkDiag.textContent = diagInput.value.trim();
        rkDiag.style.cssText = 'font-weight:600;color:var(--navy);font-style:normal';
    } else {
        rkDiag.textContent = 'Belum diisi';
        rkDiag.style.cssText = 'color:var(--gray-500);font-weight:400;font-style:italic';
    }
});

/* ============================================================
   Draft button — set status to draft then submit
   ============================================================ */
document.getElementById('btnDraft').addEventListener('click', () => {
    document.getElementById('inputStatus').value = 'draft';
    showToast('Menyimpan sebagai draft...');
    setTimeout(() => document.getElementById('formResep').submit(), 600);
});

/* ============================================================
   Form validation before kirim
   ============================================================ */
document.getElementById('formResep').addEventListener('submit', function(e) {
    const rows = tbody.querySelectorAll('tr');
    if (rows.length === 0) {
        e.preventDefault();
        showToast('Tambahkan minimal 1 obat terlebih dahulu!', true);
        return;
    }
    // Cek semua nama obat terisi
    let valid = true;
    rows.forEach(tr => {
        const namaInput = tr.querySelector('input[type="text"]');
        if (namaInput && !namaInput.value.trim()) valid = false;
    });
    if (!valid) {
        e.preventDefault();
        showToast('Nama obat tidak boleh kosong!', true);
    }
});

/* ============================================================
   Toast helper
   ============================================================ */
function showToast(msg, isError = false) {
    const toast = document.getElementById('toast');
    const icon  = toast.querySelector('i');
    document.getElementById('toastMsg').textContent = msg;
    icon.className = isError ? 'bi bi-exclamation-circle-fill' : 'bi bi-check-circle-fill';
    icon.style.color = isError ? '#FF6B6B' : 'var(--tosca-light)';
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

/* Restore old input jika ada validasi error dari server */
@if(old('obat'))
    @foreach(old('obat', []) as $key => $ob)
        addRow({
            nama_obat:    "{{ $ob['nama_obat'] ?? '' }}",
            dosis:        "{{ $ob['dosis'] ?? '' }}",
            jumlah:       "{{ $ob['jumlah'] ?? '' }}",
            satuan:       "{{ $ob['satuan'] ?? '' }}",
            aturan_pakai: "{{ $ob['aturan_pakai'] ?? '' }}",
            keterangan:   "{{ $ob['keterangan'] ?? '' }}",
        });
    @endforeach
    // Hapus row default pertama yang kosong
    if({{ count(old('obat', [])) }} > 0) {
        const firstRow = document.querySelector('#obatTableBody tr:first-child');
        // only remove if it's the auto-added empty row
        const firstInput = firstRow?.querySelector('input[type="text"]');
        if(firstInput && !firstInput.value) firstRow.remove();
        renumberRows(); updateCount();
    }
@endif
</script>

</body>
</html>