@extends('layouts.app')

@section('title', 'Dashboard Admin - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">
@endpush

@section('content')

<div class="dashboard-wrap">
    <div class="dash-main">
        <div class="dash-content">

            {{-- ═══════════════════════════════════════════
                 STAT CARDS — data dari controller
            ═══════════════════════════════════════════ --}}
            <div class="stat-grid">

                <div class="stat-card">
                    <div class="stat-icon pasien">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Pasien</div>
<<<<<<< HEAD
                        <div class="stat-value">{{ number_format($stats['pasien'] ?? 0, 0, ',', '.') }}</div>
=======
                        <div class="stat-value">{{ $totalPasien }}</div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                        <div class="stat-sub">Terdaftar di sistem</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon dokter">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Dokter</div>
<<<<<<< HEAD
                        <div class="stat-value">{{ number_format($stats['dokter'] ?? 0, 0, ',', '.') }}</div>
=======
                        <div class="stat-value">{{ $totalDokter }}</div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                        <div class="stat-sub">Aktif bertugas</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon apoteker">
                        <i class="fa-solid fa-mortar-pestle"></i>
                    </div>
                    <div>
                        <div class="stat-label">Apoteker</div>
<<<<<<< HEAD
                        <div class="stat-value">{{ number_format($stats['apoteker'] ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-sub">Aktif di sistem</div>
=======
                        <div class="stat-value">{{ $totalApoteker }}</div>
                        <div class="stat-sub">Aktif bertugas</div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon resep">
                        <i class="fa-solid fa-file-prescription"></i>
                    </div>
                    <div>
<<<<<<< HEAD
                        <div class="stat-label">Resep Bulan Ini</div>
                        <div class="stat-value">{{ number_format($stats['resep_bulan_ini'] ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-sub">Bulan ini</div>
=======
                        <div class="stat-label">Resep Menunggu</div>
                        <div class="stat-value">{{ $resepMenunggu }}</div>
                        <div class="stat-sub">
                            <span style="color:#f59e0b;">{{ $resepDiproses }} diproses</span>
                            &nbsp;·&nbsp;
                            <span style="color:#22c55e;">{{ $resepSelesai }} selesai</span>
                        </div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Pendapatan</div>
                        <div class="stat-value" style="font-size:1.1rem;">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </div>
                        <div class="stat-sub">Transaksi lunas</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div>
                        <div class="stat-label">Transaksi Pending</div>
                        <div class="stat-value">{{ $transaksiPending }}</div>
                        <div class="stat-sub">{{ $transaksiHariIni }} lunas hari ini</div>
                    </div>
                </div>

            </div>
            {{-- /STAT CARDS --}}

            {{-- ═══════════════════════════════════════════
                 MID GRID: GRAFIK PENDAPATAN + STOK MENIPIS
            ═══════════════════════════════════════════ --}}
            <div class="mid-grid">

                {{-- GRAFIK PENDAPATAN 7 HARI --}}
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div>
                            <div class="dash-card-title">Pendapatan 7 Hari Terakhir</div>
                            <div class="dash-card-sub">Total transaksi lunas per hari</div>
                        </div>
                        <a href="{{ route('pantauTransaksi') }}" class="btn-link">Lihat Detail →</a>
                    </div>
                    <div class="chart-area">
                        <canvas id="chartPendapatan" height="160"></canvas>
                    </div>
                </div>
                {{-- /GRAFIK PENDAPATAN --}}

                {{-- STOK MENIPIS --}}
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div>
                            <div class="dash-card-title">Stok Obat Menipis</div>
                            <div class="dash-card-sub">Stok &lt; 10, perlu segera diisi ulang</div>
                        </div>
                    </div>
                    <div class="stok-list">

                        @forelse ($obatHampirHabis as $obat)
                            @php
                                $pct   = $obat->stok > 0 ? min(100, $obat->stok) : 0;
                                $color = $obat->stok <= 3 ? '#ef4444' : ($obat->stok <= 6 ? '#f59e0b' : '#3FBBA0');
                                $badge = $obat->stok <= 3 ? 'badge-danger' : ($obat->stok <= 6 ? 'badge-warning' : 'badge-ok');
                                $label = $obat->stok <= 3 ? 'Kritis' : ($obat->stok <= 6 ? 'Menipis' : 'Rendah');
                            @endphp
                            <div class="stok-item">
                                <div class="stok-dot" style="background:{{ $color }};"></div>
                                <div class="stok-info">
                                    <div class="stok-name">{{ $obat->nama_obat }}</div>
                                    <div class="stok-detail">
                                        Stok: {{ $obat->stok }}
                                        &nbsp;·&nbsp;
                                        {{ $obat->kategori->kategori_obat ?? '-' }}
                                    </div>
                                </div>
                                <div class="stok-bar-wrap">
                                    <div class="stok-bar" style="width:{{ $pct }}%;background:{{ $color }};"></div>
                                </div>
                                <span class="stok-badge {{ $badge }}">{{ $label }}</span>
                            </div>
                        @empty
                            <div style="text-align:center;padding:24px;color:#94a3b8;">
                                <i class="fa-solid fa-circle-check" style="font-size:1.5rem;color:#22c55e;"></i>
                                <p style="margin-top:8px;">Semua stok obat dalam kondisi aman.</p>
                            </div>
                        @endforelse

                    </div>
                    <a href="{{ route('kelolaDataObat') }}" class="btn-all full">
                        <i class="fa-solid fa-box-open"></i> Lihat Semua Obat
                    </a>
                </div>
                {{-- /STOK MENIPIS --}}

            </div>
            {{-- /MID GRID --}}

            {{-- ═══════════════════════════════════════════
                 TRANSAKSI TERBARU
            ═══════════════════════════════════════════ --}}
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Transaksi Terbaru</div>
                        <div class="dash-card-sub">5 transaksi terakhir masuk</div>
                    </div>
                    <a href="{{ route('pantauTransaksi') }}" class="btn-link">Lihat Semua →</a>
                </div>
                <div class="table-wrap">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Nama Pasien</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksiTerbaru as $trx)
                                @php
                                    $noTrx  = 'TRX-' . $trx->created_at->format('Y') . '-' . str_pad($trx->id_transaksi, 4, '0', STR_PAD_LEFT);
                                    $metode = match($trx->metode) {
                                        'bpjs'     => ['label' => 'BPJS',     'class' => 'type-bpjs'],
                                        'transfer' => ['label' => 'Mandiri',  'class' => 'type-mandiri'],
                                        'qris'     => ['label' => 'QRIS',     'class' => 'type-qris'],
                                        default    => ['label' => 'Belum dipilih', 'class' => 'type-mandiri'],
                                    };
                                    $status = match($trx->status) {
                                        'lunas'   => ['label' => 'Lunas',   'class' => 'status-selesai', 'icon' => 'fa-circle-check'],
                                        'pending' => ['label' => 'Pending', 'class' => 'status-pending', 'icon' => 'fa-clock'],
                                        'batal'   => ['label' => 'Batal',   'class' => 'status-batal',   'icon' => 'fa-circle-xmark'],
                                        default   => ['label' => ucfirst($trx->status), 'class' => 'status-pending', 'icon' => 'fa-clock'],
                                    };
                                @endphp
                                <tr>
                                    <td><span class="trx-id">{{ $noTrx }}</span></td>
                                    <td><span class="trx-name">{{ $trx->pasien->user->nama ?? '-' }}</span></td>
                                    <td>
                                        <span class="trx-type {{ $metode['class'] }}">
                                            {{ $metode['label'] }}
                                        </span>
                                    </td>
                                    <td class="trx-amount">
                                        Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="trx-date">
                                        {{ $trx->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $status['class'] }}">
                                            <i class="fa-solid {{ $status['icon'] }}" style="font-size:10px;"></i>
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($trx->status === 'pending' && $trx->metode)
                                            <form method="POST" action="{{ route('admin.pembayaran.konfirmasi', $trx->id_transaksi) }}"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('Konfirmasi pembayaran ini?')">
                                                @csrf
                                                <button type="submit" class="btn-aksi btn-konfirmasi"
                                                        title="Konfirmasi Lunas">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center;padding:32px;color:#94a3b8;">
                                        <i class="fa-solid fa-receipt" style="font-size:1.5rem;"></i>
                                        <p style="margin-top:8px;">Belum ada transaksi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="btn-all-wrap">
                    <a href="{{ route('pantauTransaksi') }}" class="btn-all">
                        <i class="fa-solid fa-list"></i> Lihat Semua Transaksi
                    </a>
                </div>
            </div>
            {{-- /TRANSAKSI TERBARU --}}

        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // ── Data dari controller (PHP → JS) ──────────────────
    const grafikRaw = @json($grafikPendapatan);

    // Siapkan label & nilai
    const labels = grafikRaw.map(item => {
        const d = new Date(item.tanggal);
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
    });
    const values = grafikRaw.map(item => parseFloat(item.total));

    // ── Render Chart.js ───────────────────────────────────
    const ctx = document.getElementById('chartPendapatan').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length ? labels : ['Tidak ada data'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: values.length ? values : [0],
                borderColor: '#3FBBA0',
                backgroundColor: 'rgba(63,187,160,0.12)',
                borderWidth: 2.5,
                pointBackgroundColor: '#004369',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4,
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
                x: {
                    grid: { color: '#E1F1FE' },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#6a9ab5' }
                },
                y: {
                    grid: { color: '#E1F1FE' },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#6a9ab5',
                        callback: val => 'Rp ' + (val / 1000).toFixed(0) + 'k'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script src="{{ asset('js/dashboardAdmin.js') }}"></script>
<<<<<<< HEAD
</div>
@endsection
=======
@endpush
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
