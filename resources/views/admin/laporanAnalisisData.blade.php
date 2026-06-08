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

            {{-- REPORT FILTERS — filter bulan & tahun --}}
            <form method="GET" action="{{ route('laporanAnalisisData') }}" class="report-filters" id="filterForm">
                <div class="filter-group">
                    <label class="filter-label">Bulan</label>
                    <select class="filter-select" name="bulan" onchange="this.form.submit()">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Tahun</label>
                    <select class="filter-select" name="tahun" onchange="this.form.submit()">
                        @foreach(range(now()->year, now()->year - 3) as $y)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Export</label>
                    <button type="button" class="btn-generate" id="btn-export-pdf">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </button>
                </div>
            </form>

            {{-- KEY METRICS — dari DB --}}
            <div class="key-metrics">
                <div class="metric-card">
                    <div class="metric-label">Pendapatan Bulan Ini</div>
                    <div class="metric-value">
                        Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}
                    </div>
                    <div class="metric-change">
                        Transaksi lunas {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-label">Total Resep Selesai</div>
                    <div class="metric-value">{{ number_format($totalResepBulanIni, 0, ',', '.') }}</div>
                    <div class="metric-change">Resep selesai bulan ini</div>
                </div>
                <div class="metric-card">
                    <div class="metric-label">Pasien Baru</div>
                    <div class="metric-value">{{ $totalPasienBaru }}</div>
                    <div class="metric-change">Daftar bulan ini</div>
                </div>
                <div class="metric-card">
                    <div class="metric-label">Dokter Paling Aktif</div>
                    @if($dokterAktif->isNotEmpty())
                        <div class="metric-value" style="font-size:1rem;">
                            {{ $dokterAktif->first()->dokter->user->nama ?? '-' }}
                        </div>
                        <div class="metric-change">
                            {{ $dokterAktif->first()->total_pasien }} resep ditangani
                        </div>
                    @else
                        <div class="metric-value" style="font-size:1rem;">-</div>
                        <div class="metric-change">Belum ada data</div>
                    @endif
                </div>
            </div>

            {{-- DASHBOARD ANALYTICS --}}
            <div class="analytics-section">
                <h3 class="section-title">
                    Analitik — {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                </h3>

                <div class="charts-grid">
                    {{-- Pendapatan per bulan sepanjang tahun --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Pendapatan Per Bulan</div>
                                <div class="dash-card-sub">Sepanjang tahun {{ $tahun }}</div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart-pendapatan"></canvas>
                        </div>
                    </div>

                    {{-- Obat terlaris --}}
                    <div class="dash-card chart-card">
                        <div class="dash-card-header">
                            <div>
                                <div class="dash-card-title">Obat Paling Banyak Diresepkan</div>
                                <div class="dash-card-sub">Top 10 bulan ini</div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart-obat"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Tabel Dokter Aktif --}}
                <div class="dash-card" style="margin-top:20px;">
                    <div class="dash-card-header">
                        <div>
                            <div class="dash-card-title">Dokter Paling Aktif Bulan Ini</div>
                            <div class="dash-card-sub">Berdasarkan jumlah resep yang ditangani</div>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Dokter</th>
                                    <th>Spesialis</th>
                                    <th style="text-align:center;">Jumlah Pasien</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dokterAktif as $i => $da)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <div style="font-weight:600;color:#1e293b;">
                                                {{ $da->dokter->user->nama ?? '-' }}
                                            </div>
                                        </td>
                                        <td style="color:#64748b;">
                                            {{ $da->dokter->spesialis ?? '-' }}
                                        </td>
                                        <td style="text-align:center;">
                                            <span style="font-weight:700;color:#0369a1;">
                                                {{ $da->total_pasien }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;padding:30px;color:#94a3b8;">
                                            Belum ada data dokter aktif bulan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast-container" id="toast-container"></div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// ── Data dari controller (PHP → JS) ─────────────────────
const pendapatanBulanan = @json($pendapatanBulanan);
const obatTerlaris      = @json($obatTerlaris);

// ── Label bulan Indonesia ────────────────────────────────
const namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

// Siapkan array 12 bulan (isi 0 jika tidak ada data)
const pendapatanArr = Array(12).fill(0);
pendapatanBulanan.forEach(row => {
    pendapatanArr[row.bulan - 1] = parseFloat(row.total);
});

// ── Chart Pendapatan Per Bulan ───────────────────────────
const ctxPendapatan = document.getElementById('chart-pendapatan').getContext('2d');
new Chart(ctxPendapatan, {
    type: 'bar',
    data: {
        labels: namaBulan,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: pendapatanArr,
            backgroundColor: 'rgba(63,187,160,0.75)',
            borderColor: '#3FBBA0',
            borderWidth: 1.5,
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            x: { grid: { color: '#E1F1FE' }, ticks: { color: '#6a9ab5', font: { size: 11 } } },
            y: {
                grid: { color: '#E1F1FE' },
                beginAtZero: true,
                ticks: {
                    color: '#6a9ab5', font: { size: 11 },
                    callback: val => 'Rp ' + (val / 1000000).toFixed(1) + 'jt'
                }
            }
        }
    }
});

// ── Chart Obat Terlaris ──────────────────────────────────
const ctxObat = document.getElementById('chart-obat').getContext('2d');
new Chart(ctxObat, {
    type: 'bar',
    data: {
        labels: obatTerlaris.map(o => o.nama_obat),
        datasets: [{
            label: 'Total Terjual',
            data: obatTerlaris.map(o => parseInt(o.total_terjual)),
            backgroundColor: 'rgba(14,116,175,0.75)',
            borderColor: '#0e74af',
            borderWidth: 1.5,
            borderRadius: 4,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ctx.parsed.x + ' unit' } }
        },
        scales: {
            x: { grid: { color: '#E1F1FE' }, beginAtZero: true, ticks: { color: '#6a9ab5', font: { size: 11 } } },
            y: { grid: { display: false }, ticks: { color: '#334155', font: { size: 11 } } }
        }
    }
});

// ── Export PDF sederhana (print) ─────────────────────────
document.getElementById('btn-export-pdf').addEventListener('click', () => {
    window.print();
});
</script>
@endpush
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
