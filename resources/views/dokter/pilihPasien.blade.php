<<<<<<< HEAD
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pasien | SickSafe ON</title>
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
            --shadow-sm:   0 2px 8px rgba(13,43,85,.08);
            --shadow-md:   0 6px 24px rgba(13,43,85,.13);
            --shadow-lg:   0 16px 48px rgba(13,43,85,.18);
            --radius-sm:   8px;
            --radius-md:   14px;
            --radius-lg:   22px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--off-white); color: var(--navy); min-height: 100vh; }

        /* Sidebar */
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
        .doctor-info .name { font-size: 13px; font-weight: 600; color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .doctor-info .role { font-size: 11px; color: var(--tosca-light); }

        /* Main */
        .main { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { position: sticky; top: 0; z-index: 50; background: rgba(245,250,253,.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--gray-100); padding: 14px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-500); }
        .topbar-breadcrumb .current { color: var(--navy); font-weight: 600; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .topbar-btn { width: 38px; height: 38px; border-radius: 10px; border: 1px solid var(--gray-100); background: var(--white); display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--gray-700); font-size: 17px; transition: all .2s; position: relative; }
        .topbar-btn:hover { border-color: var(--tosca); color: var(--tosca); }
        .badge-dot { position: absolute; top: 7px; right: 7px; width: 8px; height: 8px; border-radius: 50%; background: var(--tosca); border: 2px solid var(--off-white); }

        /* Page Content */
        .page-content { padding: 32px; flex: 1; }
        .page-header { margin-bottom: 28px; }
        .page-header-inner { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; }
        .page-header h2 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; color: var(--navy); line-height: 1.25; }
        .page-header p { font-size: 14px; color: var(--gray-500); margin-top: 4px; }

        /* Stats */
        .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--white); border: 1px solid var(--gray-100); border-radius: var(--radius-md); padding: 18px 20px; display: flex; align-items: center; gap: 14px; box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .stat-icon.tosca { background: var(--tosca-pale); color: var(--tosca); }
        .stat-icon.navy  { background: rgba(13,43,85,.08); color: var(--navy-mid); }
        .stat-icon.blue  { background: var(--blue-pale); color: var(--blue); }
        .stat-icon.pink  { background: #FFF0F6; color: #C0398B; }
        .stat-label { font-size: 12px; color: var(--gray-500); margin-bottom: 2px; }
        .stat-value { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--navy); }
        .stat-sub { font-size: 11px; color: var(--tosca); margin-top: 1px; }

        /* Toolbar */
        .toolbar { background: var(--white); border: 1px solid var(--gray-100); border-radius: var(--radius-md); padding: 16px 20px; display: flex; align-items: center; gap: 14px; margin-bottom: 20px; box-shadow: var(--shadow-sm); flex-wrap: wrap; }
        .search-wrap { flex: 1; min-width: 220px; display: flex; align-items: center; gap: 10px; background: var(--off-white); border: 1.5px solid var(--gray-100); border-radius: var(--radius-sm); padding: 9px 14px; transition: border-color .2s; }
        .search-wrap:focus-within { border-color: var(--tosca); }
        .search-wrap i { color: var(--gray-500); font-size: 16px; }
        .search-wrap input { border: none; background: transparent; font-size: 14px; color: var(--navy); outline: none; width: 100%; font-family: 'DM Sans', sans-serif; }
        .search-wrap input::placeholder { color: var(--gray-500); }
        .filter-group { display: flex; gap: 10px; flex-wrap: wrap; }
        .filter-select { padding: 9px 14px; border-radius: var(--radius-sm); border: 1.5px solid var(--gray-100); background: var(--off-white); color: var(--navy); font-size: 13px; font-family: 'DM Sans', sans-serif; cursor: pointer; outline: none; transition: border-color .2s; }
        .filter-select:focus { border-color: var(--tosca); }
        .btn-filter { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: var(--radius-sm); background: linear-gradient(135deg, var(--tosca), var(--blue)); color: var(--white); font-weight: 600; font-size: 13px; border: none; cursor: pointer; transition: opacity .2s; }
        .btn-filter:hover { opacity: .9; }
        .btn-reset { display: inline-flex; align-items: center; gap: 6px; padding: 9px 14px; border-radius: var(--radius-sm); background: var(--off-white); color: var(--gray-700); font-size: 13px; font-weight: 500; border: 1.5px solid var(--gray-100); cursor: pointer; text-decoration: none; transition: all .2s; }
        .btn-reset:hover { border-color: var(--gray-300); color: var(--navy); }

        /* Table */
        .table-card { background: var(--white); border: 1px solid var(--gray-100); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow: hidden; }
        .table-header { padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--gray-100); }
        .table-header h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; color: var(--navy); }
        .table-header span { font-size: 13px; color: var(--gray-500); }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        thead tr { background: var(--gray-100); }
        thead th { padding: 12px 20px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: var(--gray-500); white-space: nowrap; }
        thead th:first-child { padding-left: 24px; }
        thead th:last-child { padding-right: 24px; text-align: center; }
        tbody tr { border-bottom: 1px solid var(--gray-100); transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--tosca-pale); }
        td { padding: 14px 20px; vertical-align: middle; color: var(--gray-700); }
        td:first-child { padding-left: 24px; }
        td:last-child { padding-right: 24px; text-align: center; }
        .patient-name-cell { display: flex; align-items: center; gap: 12px; }
        .patient-avatar { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0; }
        .av-1 { background: linear-gradient(135deg, var(--tosca), var(--blue)); }
        .av-2 { background: linear-gradient(135deg, var(--navy-mid), var(--blue-light)); }
        .av-3 { background: linear-gradient(135deg, var(--blue), var(--tosca-light)); }
        .patient-fullname { font-weight: 600; color: var(--navy); font-size: 14px; }
        .patient-id { font-size: 11px; color: var(--gray-500); margin-top: 1px; }
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-laki   { background: var(--blue-pale); color: var(--blue); }
        .badge-perempuan { background: #FFF0F6; color: #C0398B; }
        .badge-aktif  { background: #E6FAF4; color: #1B8A60; }
        .badge-nonaktif { background: var(--gray-100); color: var(--gray-500); }
        .btn-pilih { display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: var(--radius-sm); background: linear-gradient(135deg, var(--tosca), var(--tosca-light)); color: var(--white); font-size: 12px; font-weight: 600; border: none; cursor: pointer; transition: opacity .2s, transform .15s; box-shadow: 0 3px 10px rgba(43,188,176,.3); white-space: nowrap; text-decoration: none; }
        .btn-pilih:hover { opacity: .9; transform: translateY(-1px); }
        .btn-detail { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); background: transparent; color: var(--blue); font-size: 12px; font-weight: 600; border: 1.5px solid var(--blue); cursor: pointer; transition: all .2s; text-decoration: none; margin-right: 6px; }
        .btn-detail:hover { background: var(--blue-pale); }

        /* Empty State */
        .empty-state { text-align: center; padding: 56px 24px; }
        .empty-icon { width: 72px; height: 72px; border-radius: 50%; background: var(--tosca-pale); display: flex; align-items: center; justify-content: center; font-size: 30px; color: var(--tosca); margin: 0 auto 16px; }
        .empty-state h4 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
        .empty-state p { font-size: 13px; color: var(--gray-500); }

        /* Pagination */
        .pagination-wrap { padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--gray-100); flex-wrap: wrap; gap: 12px; }
        .pagination-info { font-size: 13px; color: var(--gray-500); }
        .pagination-links a, .pagination-links span { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1.5px solid var(--gray-100); background: var(--white); font-size: 13px; font-weight: 600; color: var(--gray-700); text-decoration: none; margin: 0 2px; transition: all .2s; }
        .pagination-links a:hover { border-color: var(--tosca); color: var(--tosca); }
        .pagination-links span.active-page { background: var(--tosca); border-color: var(--tosca); color: #fff; }
        .pagination-links span.disabled { opacity: .4; cursor: not-allowed; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .page-content { padding: 20px 16px; }
            .stats-strip { grid-template-columns: repeat(2, 1fr); }
            .page-header-inner { flex-direction: column; }
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-mark"><i class="bi bi-heart-pulse-fill"></i></div>
        <h1>SickSafe<span> ON</span></h1>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Menu Utama</div>
        <a href="#" class="nav-item"><i class="bi bi-grid-fill"></i> Dashboard</a>
        <a href="{{ route('dokter.pilih-pasien') }}" class="nav-item active"><i class="bi bi-people-fill"></i> Pilih Pasien</a>
        <a href="#" class="nav-item"><i class="bi bi-file-medical-fill"></i> Buat Resep</a>
        <a href="#" class="nav-item"><i class="bi bi-pencil-square"></i> Edit Resep</a>
        <a href="#" class="nav-item"><i class="bi bi-trash3-fill"></i> Hapus Resep</a>
        <div class="sidebar-section-label">Monitoring</div>
        <a href="#" class="nav-item"><i class="bi bi-activity"></i> Konsumsi Obat Pasien</a>
        <a href="#" class="nav-item"><i class="bi bi-bar-chart-fill"></i> Riwayat Kunjungan</a>
        <div class="sidebar-section-label">Akun</div>
        <a href="#" class="nav-item"><i class="bi bi-person-fill"></i> Profil Saya</a>
        <a href="{{ route('logout') }}" class="nav-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
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

{{-- MAIN --}}
<div class="main">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="topbar-breadcrumb">
            <i class="bi bi-house"></i>
            <i class="bi bi-chevron-right" style="font-size:10px"></i>
            <span>Dokter</span>
            <i class="bi bi-chevron-right" style="font-size:10px"></i>
            <span class="current">Pilih Pasien</span>
        </div>
        <div class="topbar-actions">
            <div class="topbar-btn">
                <i class="bi bi-bell"></i>
                <span class="badge-dot"></span>
=======
@extends('layouts.app')

@section('title', 'Pilih Pasien - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/pilihPasien.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="pilih-pasien-wrap">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <h2>Pilih Pasien</h2>
                <p>Pilih pasien untuk membuat atau melanjutkan resep &mdash;
                   {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
>>>>>>> main
            </div>
        </div>
    </div>

<<<<<<< HEAD
    {{-- Page Content --}}
    <div class="page-content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header-inner">
                <div>
                    <h2>Pilih Pasien</h2>
                    <p>Pilih pasien untuk membuat atau melanjutkan resep — {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Stats Strip --}}
        <div class="stats-strip">
            <div class="stat-card">
                <div class="stat-icon tosca"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-label">Total Pasien</div>
                    <div class="stat-value">{{ $totalPasien }}</div>
                    <div class="stat-sub">Terdaftar</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-check2-circle"></i></div>
                <div>
                    <div class="stat-label">Status Aktif</div>
                    <div class="stat-value">{{ $totalAktif }}</div>
                    <div class="stat-sub" style="color:var(--blue)">Pasien aktif</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon navy"><i class="bi bi-gender-male"></i></div>
                <div>
                    <div class="stat-label">Laki-laki</div>
                    <div class="stat-value">{{ $totalLakiLaki }}</div>
                    <div class="stat-sub" style="color:var(--gray-500)">Pasien</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pink"><i class="bi bi-gender-female"></i></div>
                <div>
                    <div class="stat-label">Perempuan</div>
                    <div class="stat-value">{{ $totalPerempuan }}</div>
                    <div class="stat-sub" style="color:var(--gray-500)">Pasien</div>
                </div>
            </div>
        </div>

        {{-- Toolbar: Search & Filter --}}
        <form method="GET" action="{{ route('dokter.pilih-pasien') }}">
            <div class="toolbar">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="Cari nama, No. BPJS, atau riwayat penyakit..."
                           value="{{ request('search') }}">
                </div>
                <div class="filter-group">
                    <select name="jenis_kelamin" class="filter-select">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="Laki-laki"  {{ request('jenis_kelamin') == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan"  {{ request('jenis_kelamin') == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <select name="status" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                @if(request()->hasAny(['search','jenis_kelamin','status']))
                    <a href="{{ route('dokter.pilih-pasien') }}" class="btn-reset">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- Table Card --}}
        <div class="table-card">
            <div class="table-header">
                <h3>Daftar Pasien</h3>
                <span>Menampilkan {{ $pasiens->firstItem() ?? 0 }}–{{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }} pasien</span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Pasien</th>
                            <th>No. BPJS</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Riwayat Penyakit</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasiens as $index => $pasien)
=======
    {{-- STATS STRIP --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon tosca"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-label">Total Pasien</div>
                <div class="stat-value">{{ $totalPasien ?? '—' }}</div>
                <div class="stat-sub">Terdaftar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-check2-circle"></i></div>
            <div>
                <div class="stat-label">Status Aktif</div>
                <div class="stat-value">{{ $totalAktif ?? '—' }}</div>
                <div class="stat-sub" style="color:var(--blue)">Pasien aktif</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon navy"><i class="bi bi-gender-male"></i></div>
            <div>
                <div class="stat-label">Laki-laki</div>
                <div class="stat-value">{{ $totalLakiLaki ?? '—' }}</div>
                <div class="stat-sub">Pasien</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pink"><i class="bi bi-gender-female"></i></div>
            <div>
                <div class="stat-label">Perempuan</div>
                <div class="stat-value">{{ $totalPerempuan ?? '—' }}</div>
                <div class="stat-sub">Pasien</div>
            </div>
        </div>
    </div>

    {{-- TOOLBAR: SEARCH & FILTER --}}
    <form method="GET" action="{{ route('dokter.pilih-pasien') }}">
        <div class="toolbar">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search"
                       placeholder="Cari nama, No. BPJS, atau riwayat penyakit..."
                       value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <select name="jenis_kelamin" class="filter-select">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="Laki-laki"  {{ request('jenis_kelamin') == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan"  {{ request('jenis_kelamin') == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                </select>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
            @if(request()->hasAny(['search','jenis_kelamin','status']))
                <a href="{{ route('dokter.pilih-pasien') }}" class="btn-reset">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            @endif
        </div>
    </form>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-header">
            <h3>Daftar Pasien</h3>
            <span>
                Menampilkan
                {{ isset($pasiens) ? ($pasiens->firstItem() ?? 0) : 0 }}–{{ isset($pasiens) ? ($pasiens->lastItem() ?? 0) : 0 }}
                dari {{ isset($pasiens) ? $pasiens->total() : 0 }} pasien
            </span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>No. BPJS</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Riwayat Penyakit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($pasiens)
                        @forelse($pasiens as $index => $pasien)
>>>>>>> main
                        @php
                            $avClass = ['av-1','av-2','av-3'][$index % 3];
                            $inisial = strtoupper(substr($pasien->user?->nama ?? '?', 0, 2));
                        @endphp
                        <tr>
                            <td>
                                <div class="patient-name-cell">
                                    <div class="patient-avatar {{ $avClass }}">{{ $inisial }}</div>
                                    <div>
                                        <div class="patient-fullname">{{ $pasien->user?->nama ?? '-' }}</div>
                                        <div class="patient-id">#PAT-{{ str_pad($pasien->ID_Pasien, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $pasien->No_BPJS ?? '-' }}</td>
                            <td>
                                @if($pasien->Jenis_kelamin == 'Laki-laki')
                                    <span class="badge badge-laki"><i class="bi bi-gender-male"></i> Laki-laki</span>
                                @else
                                    <span class="badge badge-perempuan"><i class="bi bi-gender-female"></i> Perempuan</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pasien->Tanggal_Lahir)->format('d M Y') }}</td>
                            <td>{{ $pasien->Riwayat_Penyakit ?? '-' }}</td>
                            <td>
                                @if(($pasien->user?->status ?? '') == 'aktif')
                                    <span class="badge badge-aktif"><i class="bi bi-circle-fill"></i> Aktif</span>
                                @else
                                    <span class="badge badge-nonaktif"><i class="bi bi-circle"></i> Non-aktif</span>
                                @endif
                            </td>
                            <td>
<<<<<<< HEAD
                                {{-- Ganti route ini sesuai route buat resep kamu nanti --}}
                                <a href="#" class="btn-detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="#" class="btn-pilih">
=======
                                <a href="#" class="btn-detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('dokter.resep.create', $pasien->ID_Pasien) }}" class="btn-pilih">
>>>>>>> main
                                    <i class="bi bi-cursor-fill"></i> Pilih
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-people"></i></div>
                                    <h4>Tidak Ada Pasien Ditemukan</h4>
<<<<<<< HEAD
                                    <p>Coba ubah filter atau kata kunci pencarian kamu.</p>
=======
                                    <p>Coba ubah filter atau kata kunci pencarian.</p>
>>>>>>> main
                                </div>
                            </td>
                        </tr>
                        @endforelse
<<<<<<< HEAD
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
=======
                    @else
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-people"></i></div>
                                    <h4>Data Pasien Belum Tersedia</h4>
                                    <p>Hubungkan halaman ini dengan controller untuk menampilkan data.</p>
                                </div>
                            </td>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @isset($pasiens)
>>>>>>> main
            @if($pasiens->hasPages())
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Halaman {{ $pasiens->currentPage() }} dari {{ $pasiens->lastPage() }}
                </div>
                <div class="pagination-links">
<<<<<<< HEAD
                    {{-- Prev --}}
=======
>>>>>>> main
                    @if($pasiens->onFirstPage())
                        <span class="disabled"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $pasiens->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                    @endif

<<<<<<< HEAD
                    {{-- Page numbers --}}
=======
>>>>>>> main
                    @for($i = 1; $i <= $pasiens->lastPage(); $i++)
                        @if($i == $pasiens->currentPage())
                            <span class="active-page">{{ $i }}</span>
                        @else
                            <a href="{{ $pasiens->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

<<<<<<< HEAD
                    {{-- Next --}}
=======
>>>>>>> main
                    @if($pasiens->hasMorePages())
                        <a href="{{ $pasiens->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                    @else
                        <span class="disabled"><i class="bi bi-chevron-right"></i></span>
                    @endif
                </div>
            </div>
            @endif
<<<<<<< HEAD

        </div>
        {{-- /table-card --}}

    </div>
    {{-- /page-content --}}
</div>
{{-- /main --}}

</body>
</html>
=======
        @endisset

    </div>
    {{-- /table-card --}}

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pilihPasien.js') }}"></script>
@endpush
>>>>>>> main
