@extends('layouts.app')

@section('title', 'Laporan Analisis Data - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/LaporanAnalisisData.css') }}">
@endpush


@section('content')
<div class="dashboard-wrap">

    <div class="dash-main">
        <div class="dash-content">

            {{-- REPORT FILTERS --}}
            <div class="report-filters">
                <div class="filter-group">
                    <label class="filter-label">Tipe Laporan</label>
                    <select class="filter-select" id="filter-type">
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
                    <select class="filter-select" id="filter-period">
                        <option value="today">Hari Ini</option>
                        <option value="week">Minggu Ini</option>
                        <option value="month" selected>Bulan Ini</option>
                        <option value="year">Tahun Ini</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Format</label>
                    <select class="filter-select" id="filter-format">
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                    </select>
                </div>

                <button class="btn-generate" id="btn-generate">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Buat Laporan
                </button>
            </div>

            {{-- DASHBOARD ANALYTICS --}}
            <div class="analytics-section">
                <h3 class="section-title">Analitik Sistem</h3>

                <div class="charts-grid">
                    {{-- Transaksi Per Hari --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Transaksi Per Hari</div>
                                <div class="dash-card-sub">30 hari terakhir</div>
                            </div>
                            <button class="btn-link" id="btn-detail-trx">Detail →</button>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart-trx"></canvas>
                        </div>
                    </div>

                    {{-- BPJS vs Mandiri --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">BPJS vs Mandiri</div>
                                <div class="dash-card-sub">Perbandingan tipe pembayaran</div>
                            </div>
                            <button class="btn-link" id="btn-detail-pay">Detail →</button>
                        </div>
                        <div class="chart-container pie-container">
                            <canvas id="chart-pay"></canvas>
                            <div class="pie-legend" id="pie-legend"></div>
                        </div>
                    </div>
                </div>

                <div class="charts-grid">
                    {{-- Obat Terpopuler --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Obat Terpopuler</div>
                                <div class="dash-card-sub">Top 5 obat yang paling banyak diresepkan</div>
                            </div>
                            <button class="btn-link" id="btn-all-obat">Lihat Semua →</button>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart-obat"></canvas>
                        </div>
                    </div>

                    {{-- Kunjungan Pasien --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Kunjungan Pasien</div>
                                <div class="dash-card-sub">Per hari dalam bulan ini</div>
                            </div>
                            <button class="btn-link" id="btn-detail-visit">Detail →</button>
                        </div>
                        <div class="stats-grid-mini">
                            <div class="stat-mini">
                                <div class="stat-label-mini">Total</div>
                                <div class="stat-value-mini">1.245</div>
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
                            <canvas id="chart-visit"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Key Metrics --}}
                <div class="key-metrics">
                    <div class="metric-card">
                        <div class="metric-label">Pendapatan Bulan Ini</div>
                        <div class="metric-value">Rp 245,5 Juta</div>
                        <div class="metric-change up">↑ 18% dari bulan lalu</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Rata-rata Transaksi</div>
                        <div class="metric-value">Rp 289.500</div>
                        <div class="metric-change up">↑ 5% dari bulan lalu</div>
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
                    <div class="reports-list" id="reports-list">
                        {{-- injected by JS --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL LAPORAN --}}
    <div class="modal-overlay" id="modal-report" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-report-title">Detail Laporan</h3>
                <button class="modal-close" id="modal-report-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body" id="modal-report-body"></div>
            <div class="modal-footer">
                <button class="btn-modal-primary" id="modal-report-close-btn">Tutup</button>
            </div>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast-container" id="toast-container"></div>

</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="{{ asset('js/laporanAnalisisData.js') }}"></script>
@endpush