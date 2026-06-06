@extends('layouts.app')

@section('title', 'Laporan Analisis Data - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/laporanAnalisisData.css') }}">

    {{-- MAIN AREA --}}
    <div class="dash-main">

        <!-- {{-- TOPBAR --}}
        <div class="dash-topbar">
            <div>
                <div class="topbar-title">Laporan Analisis Data</div>
                <div class="topbar-sub">Buat laporan dan analisis data sistem kesehatan</div>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Refresh">
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                </button>
                <button class="topbar-btn btn-export">
                    <i class="fa-solid fa-download"></i>
                </button>
            </div>
        </div> -->

        {{-- CONTENT --}}
        <div class="dash-content">

            {{-- REPORT FILTERS --}}
            <div class="report-filters">
                <div class="filter-group">
                    <label class="filter-label">Tipe Laporan</label>
                    <select class="filter-select">
                        <option value="">Pilih Tipe Laporan</option>
                        <option value="transaksi">Laporan Transaksi</option>
                        <option value="pasien">Laporan Pasien</option>
                        <option value="obat">Laporan Stok Obat</option>
                        <option value="kinerja">Laporan Kinerja Staf</option>
                        <option value="finansial">Laporan Finansial</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Periode</label>
                    <select class="filter-select">
                        <option value="today">Hari Ini</option>
                        <option value="week">Minggu Ini</option>
                        <option value="month">Bulan Ini</option>
                        <option value="year">Tahun Ini</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Format</label>
                    <select class="filter-select">
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                        <option value="csv">CSV</option>
                    </select>
                </div>

                <button class="btn-generate">
                    <i class="fa-solid fa-magic-wand-magic-wand"></i> Generate Laporan
                </button>
            </div>

            {{-- DASHBOARD ANALYTICS --}}
            <div class="analytics-section">
                <h3 class="section-title">Analitik Sistem</h3>

                {{-- Analytics Charts Row 1 --}}
                <div class="charts-grid">
                    {{-- Transaksi Per Hari Chart --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Transaksi Per Hari</div>
                                <div class="dash-card-sub">30 hari terakhir</div>
                            </div>
                            <button class="btn-link">Detail →</button>
                        </div>
                        <div class="chart-container">
                            <svg class="line-chart" viewBox="0 0 600 250" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="gradTrx" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#3FBBA0" stop-opacity="0.2"/>
                                        <stop offset="100%" stop-color="#3FBBA0" stop-opacity="0.01"/>
                                    </linearGradient>
                                </defs>
                                {{-- Grid --}}
                                <line x1="40" y1="50" x2="580" y2="50" stroke="#E1F1FE" stroke-width="1"/>
                                <line x1="40" y1="100" x2="580" y2="100" stroke="#E1F1FE" stroke-width="1"/>
                                <line x1="40" y1="150" x2="580" y2="150" stroke="#E1F1FE" stroke-width="1"/>
                                <line x1="40" y1="200" x2="580" y2="200" stroke="#E1F1FE" stroke-width="1"/>
                                {{-- Y Axis Labels --}}
                                <text x="35" y="55" font-size="12" fill="#6a9ab5">60</text>
                                <text x="35" y="105" font-size="12" fill="#6a9ab5">40</text>
                                <text x="35" y="155" font-size="12" fill="#6a9ab5">20</text>
                                <text x="35" y="205" font-size="12" fill="#6a9ab5">0</text>
                                {{-- Area --}}
                                <path d="M50,120 L90,80 L130,110 L170,70 L210,50 L250,90 L290,60 L330,40 L370,85 L410,55 L450,70 L490,45 L530,35 L570,50 L570,230 L50,230 Z"
                                      fill="url(#gradTrx)"/>
                                {{-- Line --}}
                                <polyline points="50,120 90,80 130,110 170,70 210,50 250,90 290,60 330,40 370,85 410,55 450,70 490,45 530,35 570,50"
                                          fill="none" stroke="#3FBBA0" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>

                    {{-- BPJS vs Mandiri Chart --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">BPJS vs Mandiri</div>
                                <div class="dash-card-sub">Perbandingan tipe pembayaran</div>
                            </div>
                            <button class="btn-link">Detail →</button>
                        </div>
                        <div class="chart-container pie-container">
                            <svg class="pie-chart" viewBox="0 0 200 200">
                                {{-- Pie slices --}}
                                <circle cx="100" cy="100" r="70" fill="none" stroke="#3FBBA0" stroke-width="45" stroke-dasharray="164.93 329.87"/>
                                <circle cx="100" cy="100" r="100" fill="none" stroke="#b1ddff" stroke-width="45" stroke-dasharray="165.88 329.87" stroke-dashoffset="-164.93"/>
                                {{-- Center circle (donut) --}}
                                <circle cx="100" cy="100" r="50" fill="white"/>
                                {{-- Labels --}}
                                <text x="100" y="95" font-size="20" font-weight="bold" fill="#004369" text-anchor="middle">65%</text>
                                <text x="100" y="115" font-size="11" fill="#6a9ab5" text-anchor="middle">BPJS</text>
                            </svg>
                            <div class="pie-legend">
                                <div class="legend-item">
                                    <span class="legend-color" style="background:#3FBBA0;"></span>
                                    <span>BPJS: 65%</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background:#b1ddff;"></span>
                                    <span>Mandiri: 35%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Analytics Charts Row 2 --}}
                <div class="charts-grid">
                    {{-- Obat Terpopuler Chart --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Obat Terpopuler</div>
                                <div class="dash-card-sub">Top 5 obat yang paling banyak diresepkan</div>
                            </div>
                            <button class="btn-link">Lihat Semua →</button>
                        </div>
                        <div class="bar-chart-container">
                            <div class="bar-item">
                                <div class="bar-label">Paracetamol 500mg</div>
                                <div class="bar-wrap">
                                    <div class="bar" style="width: 95%; background: #3FBBA0;"></div>
                                    <span class="bar-value">245</span>
                                </div>
                            </div>
                            <div class="bar-item">
                                <div class="bar-label">Amoxicillin 500mg</div>
                                <div class="bar-wrap">
                                    <div class="bar" style="width: 78%; background: #004369;"></div>
                                    <span class="bar-value">198</span>
                                </div>
                            </div>
                            <div class="bar-item">
                                <div class="bar-label">Vitamin C 500mg</div>
                                <div class="bar-wrap">
                                    <div class="bar" style="width: 62%; background: #b1ddff;"></div>
                                    <span class="bar-value">156</span>
                                </div>
                            </div>
                            <div class="bar-item">
                                <div class="bar-label">CTM 4mg</div>
                                <div class="bar-wrap">
                                    <div class="bar" style="width: 48%; background: #3FBBA0;"></div>
                                    <span class="bar-value">121</span>
                                </div>
                            </div>
                            <div class="bar-item">
                                <div class="bar-label">Ibuprofen 200mg</div>
                                <div class="bar-wrap">
                                    <div class="bar" style="width: 35%; background: #004369;"></div>
                                    <span class="bar-value">89</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kunjungan Dokter Chart --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Kunjungan Pasien</div>
                                <div class="dash-card-sub">Per hari dalam bulan ini</div>
                            </div>
                            <button class="btn-link">Detail →</button>
                        </div>
                        <div class="stats-grid-mini">
                            <div class="stat-mini">
                                <div class="stat-label-mini">Total</div>
                                <div class="stat-value-mini">1,245</div>
                                <div class="stat-trend up">↑ 12%</div>
                            </div>
                            <div class="stat-mini">
                                <div class="stat-label-mini">Rata-rata/Hari</div>
                                <div class="stat-value-mini">40</div>
                                <div class="stat-trend neutral">→ 0%</div>
                            </div>
                            <div class="stat-mini">
                                <div class="stat-label-mini">Puncak</div>
                                <div class="stat-value-mini">65</div>
                                <div class="stat-trend-date">12 Mei</div>
                            </div>
                        </div>
                        <div class="sparkline-container">
                            <svg class="sparkline" viewBox="0 0 300 60" preserveAspectRatio="none">
                                <polyline points="10,40 25,35 40,38 55,30 70,32 85,28 100,25 115,30 130,22 145,20 160,25 175,18 190,15 205,20 220,12 235,10 250,15 265,8 280,5"
                                          fill="none" stroke="#3FBBA0" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Key Metrics --}}
                <div class="key-metrics">
                    <div class="metric-card">
                        <div class="metric-label">Pendapatan Bulan Ini</div>
                        <div class="metric-value">Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}</div>
                        <div class="metric-change up">Bulan ini</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Rata-rata Transaksi</div>
                        <div class="metric-value">Rp {{ number_format($averageTransaction ?? 0, 0, ',', '.') }}</div>
                        <div class="metric-change up">Dari transaksi lunas</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Dokter Paling Aktif</div>
                        <div class="metric-value">Dr. Reza Pratama</div>
                        <div class="metric-change">185 konsultasi</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Waktu Pelayanan Rata-rata</div>
                        <div class="metric-value">15 Menit</div>
                        <div class="metric-change down">↓ 2 menit dari bulan lalu</div>
                    </div>
                </div>
            </div>

            {{-- RECENT REPORTS --}}
            <div class="reports-section">
                <h3 class="section-title">Laporan Terbaru</h3>
                <div class="dash-card">
                    <div class="reports-list">
                        <div class="report-item">
                            <div class="report-icon">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div class="report-info">
                                <div class="report-name">Laporan Transaksi Mei 2026</div>
                                <div class="report-date">Dibuat: 15 Mei 2026 • 847 transaksi</div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-small btn-download"><i class="fa-solid fa-download"></i> Download</button>
                                <button class="btn-small btn-view"><i class="fa-solid fa-eye"></i> Lihat</button>
                            </div>
                        </div>

                        <div class="report-item">
                            <div class="report-icon">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <div class="report-info">
                                <div class="report-name">Laporan Stok Obat Bulan Mei</div>
                                <div class="report-date">Dibuat: 14 Mei 2026 • 156 item obat</div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-small btn-download"><i class="fa-solid fa-download"></i> Download</button>
                                <button class="btn-small btn-view"><i class="fa-solid fa-eye"></i> Lihat</button>
                            </div>
                        </div>

                        <div class="report-item">
                            <div class="report-icon">
                                <i class="fa-solid fa-file-chart-column"></i>
                            </div>
                            <div class="report-info">
                                <div class="report-name">Analisis Kinerja Staf Q1 2026</div>
                                <div class="report-date">Dibuat: 10 Mei 2026 • 25 staf</div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-small btn-download"><i class="fa-solid fa-download"></i> Download</button>
                                <button class="btn-small btn-view"><i class="fa-solid fa-eye"></i> Lihat</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- /CONTENT --}}

    </div>
    {{-- /MAIN AREA --}}

</div>
@endsection
