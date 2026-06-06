@extends('layouts.app')

@section('title', 'Dashboard Admin - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">  

    {{-- MAIN AREA --}}
    <div class="dash-main">

        {{-- CONTENT --}}
        <div class="dash-content">

            {{-- STAT CARDS --}}
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-icon pasien">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Pasien</div>
                        <div class="stat-value">{{ number_format($stats['pasien'] ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-sub">Terdaftar di sistem</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon dokter">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Dokter</div>
                        <div class="stat-value">{{ number_format($stats['dokter'] ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-sub">Aktif bertugas</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon apoteker">
                        <i class="fa-solid fa-mortar-pestle"></i>
                    </div>
                    <div>
                        <div class="stat-label">Apoteker</div>
                        <div class="stat-value">{{ number_format($stats['apoteker'] ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-sub">Aktif di sistem</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon resep">
                        <i class="fa-solid fa-file-prescription"></i>
                    </div>
                    <div>
                        <div class="stat-label">Resep Bulan Ini</div>
                        <div class="stat-value">{{ number_format($stats['resep_bulan_ini'] ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-sub">Bulan ini</div>
                    </div>
                </div>
            </div>
            {{-- /STAT CARDS --}}

            {{-- MID GRID: CHART + STOK --}}
            <div class="mid-grid">

                {{-- GRAFIK RESEP --}}
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div>
                            <div class="dash-card-title">Grafik Resep (30 Hari Terakhir)</div>
                            <div class="dash-card-sub">Jumlah resep harian</div>
                        </div>
                        <button class="btn-link">Lihat Detail →</button>
                    </div>
                    <div class="chart-area">
                        <svg class="chart-svg" viewBox="0 0 560 160" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%"   stop-color="#3FBBA0" stop-opacity="0.25"/>
                                    <stop offset="100%" stop-color="#3FBBA0" stop-opacity="0.02"/>
                                </linearGradient>
                            </defs>
                            {{-- Grid lines --}}
                            <line x1="0" y1="32"  x2="560" y2="32"  stroke="#E1F1FE" stroke-width="1"/>
                            <line x1="0" y1="64"  x2="560" y2="64"  stroke="#E1F1FE" stroke-width="1"/>
                            <line x1="0" y1="96"  x2="560" y2="96"  stroke="#E1F1FE" stroke-width="1"/>
                            <line x1="0" y1="128" x2="560" y2="128" stroke="#E1F1FE" stroke-width="1"/>
                            {{-- Y labels --}}
                            <text x="0" y="30"  font-size="9" fill="#6a9ab5">60</text>
                            <text x="0" y="62"  font-size="9" fill="#6a9ab5">40</text>
                            <text x="0" y="94"  font-size="9" fill="#6a9ab5">20</text>
                            <text x="0" y="126" font-size="9" fill="#6a9ab5">0</text>
                            {{-- Area fill --}}
                            <path d="M20,100 C50,90 80,115 110,95 C140,75 160,60 190,50 C220,40 240,70 270,55 C300,40 330,45 360,30 C390,18 420,35 450,28 C480,20 510,15 540,10 L540,140 L20,140 Z"
                                  fill="url(#areaGrad)"/>
                            {{-- Line --}}
                            <polyline
                                points="20,100 50,90 80,115 110,95 140,75 160,60 190,50 220,40 240,70 270,55 300,40 330,45 360,30 390,18 420,35 450,28 480,20 510,15 540,10"
                                fill="none" stroke="#3FBBA0" stroke-width="2.5"
                                stroke-linejoin="round" stroke-linecap="round"/>
                            {{-- Highlight dots --}}
                            <circle cx="360" cy="30" r="4" fill="#004369" stroke="white" stroke-width="1.5"/>
                            <circle cx="540" cy="10" r="4" fill="#3FBBA0" stroke="white" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <div class="chart-labels">
                        <span>20 Apr</span>
                        <span>27 Apr</span>
                        <span>4 Mei</span>
                        <span>11 Mei</span>
                        <span>18 Mei</span>
                    </div>
                </div>
                {{-- /GRAFIK RESEP --}}

                {{-- STOK MENIPIS --}}
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div>
                            <div class="dash-card-title">Stok Obat Menipis</div>
                            <div class="dash-card-sub">Perlu segera diisi ulang</div>
                        </div>
                    </div>
                    <div class="stok-list">

                        <div class="stok-item">
                            <div class="stok-dot" style="background:#3FBBA0;"></div>
                            <div class="stok-info">
                                <div class="stok-name">Paracetamol 500mg</div>
                                <div class="stok-detail">Stok: 45 &nbsp;·&nbsp; Min: 100</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:45%;background:#3FBBA0;"></div>
                            </div>
                            <span class="stok-badge badge-warning">Rendah</span>
                        </div>

                        <div class="stok-item">
                            <div class="stok-dot" style="background:#004369;"></div>
                            <div class="stok-info">
                                <div class="stok-name">Amoxicillin 500mg</div>
                                <div class="stok-detail">Stok: 32 &nbsp;·&nbsp; Min: 100</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:32%;background:#004369;"></div>
                            </div>
                            <span class="stok-badge badge-danger">Menipis</span>
                        </div>

                        <div class="stok-item">
                            <div class="stok-dot" style="background:#b1ddff;"></div>
                            <div class="stok-info">
                                <div class="stok-name">CTM 4mg</div>
                                <div class="stok-detail">Stok: 20 &nbsp;·&nbsp; Min: 50</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:40%;background:#b1ddff;"></div>
                            </div>
                            <span class="stok-badge badge-danger">Menipis</span>
                        </div>

                        <div class="stok-item">
                            <div class="stok-dot" style="background:#3FBBA0;"></div>
                            <div class="stok-info">
                                <div class="stok-name">Vitamin C 500mg</div>
                                <div class="stok-detail">Stok: 80 &nbsp;·&nbsp; Min: 100</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:80%;background:#3FBBA0;"></div>
                            </div>
                            <span class="stok-badge badge-ok">Aman</span>
                        </div>

                    </div>
                    <button class="btn-all full">
                        <i class="fa-solid fa-box-open"></i> Lihat Semua Obat
                    </button>
                </div>
                {{-- /STOK MENIPIS --}}

            </div>
            {{-- /MID GRID --}}

            {{-- TRANSAKSI TERBARU --}}
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Transaksi Terbaru</div>
                        <div class="dash-card-sub">Data transaksi hari ini</div>
                    </div>
                    <button class="btn-link">Lihat Semua →</button>
                </div>
                <div class="table-wrap">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Nama Pasien</th>
                                <th>Jenis</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="trx-id">TRX-2024-0081</span></td>
                                <td><span class="trx-name">Kenzi nomik</span></td>
                                <td><span class="trx-type type-bpjs">BPJS</span></td>
                                <td class="trx-amount">Rp 125.000</td>
                                <td class="trx-date">01 Mei 2026</td>
                                <td>
                                    <span class="status-badge status-selesai">
                                        <i class="fa-solid fa-circle-check" style="font-size:10px;"></i> Selesai
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="trx-id">TRX-2024-0080</span></td>
                                <td><span class="trx-name">Jawak hiacek</span></td>
                                <td><span class="trx-type type-mandiri">Mandiri</span></td>
                                <td class="trx-amount">Rp 85.000</td>
                                <td class="trx-date">10 Mei 2026</td>
                                <td>
                                    <span class="status-badge status-selesai">
                                        <i class="fa-solid fa-circle-check" style="font-size:10px;"></i> Selesai
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="trx-id">TRX-2024-0079</span></td>
                                <td><span class="trx-name">Yeeree</span></td>
                                <td><span class="trx-type type-bpjs">BPJS</span></td>
                                <td class="trx-amount">Rp 210.000</td>
                                <td class="trx-date">07 Mei 2026</td>
                                <td>
                                    <span class="status-badge status-pending">
                                        <i class="fa-solid fa-clock" style="font-size:10px;"></i> Pending
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="trx-id">TRX-2024-0078</span></td>
                                <td><span class="trx-name">Regenn</span></td>
                                <td><span class="trx-type type-mandiri">Mandiri</span></td>
                                <td class="trx-amount">Rp 55.000</td>
                                <td class="trx-date">10 Mei 2026</td>
                                <td>
                                    <span class="status-badge status-selesai">
                                        <i class="fa-solid fa-circle-check" style="font-size:10px;"></i> Selesai
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn-all-wrap">
                    <button class="btn-all">
                        <i class="fa-solid fa-list"></i> Lihat Semua Transaksi
                    </button>
                </div>
            </div>
            {{-- /TRANSAKSI TERBARU --}}

        </div>
        {{-- /CONTENT --}}

    </div>
    {{-- /MAIN AREA --}}

<script src="{{ asset('js/dashboardAdmin.js') }}"></script>
</div>
@endsection
