@extends('layouts.app')

@section('title', 'Dashboard Admin - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">
@endpush

@section('content')

<div class="dashboard-wrap">

    <div class="dash-main">
        <div class="dash-content">

            {{-- GREETING --}}
            <div class="dashboard-greeting">
                <div>
                    <div class="greeting-title">Hallo, Admin!</div>
                    <div class="greeting-sub">Selamat datang. Periksa statistik dan akses cepat di bawah.</div>
                </div>
                {{-- Tanggal & hari — warna lebih terang & kontras --}}
            </div>

            {{-- STAT CARDS — 3 kolom: Pasien, Dokter, Apoteker --}}
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-icon pasien">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Pasien</div>
                        <div class="stat-value">120</div>
                        <div class="stat-sub">↑ 8 bulan ini</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon dokter">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Dokter</div>
                        <div class="stat-value">25</div>
                        <div class="stat-sub">Aktif bertugas</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon apoteker">
                        <i class="fa-solid fa-mortar-pestle"></i>
                    </div>
                    <div>
                        <div class="stat-label">Apoteker</div>
                        <div class="stat-value">18</div>
                        <div class="stat-sub">3 jadwal hari ini</div>
                    </div>
                </div>
            </div>

            {{-- MID GRID --}}
            <div class="mid-grid">

                {{-- AKSES CEPAT — preview card style --}}
                <div class="dash-card dash-card-halo">
                    <div class="dash-card-header">
                    
                    </div>

                    <div class="shortcut-links">

                        {{-- Card: Kelola Akun Pengguna --}}
                        <a href="{{ route('kelolaAkunPengguna') }}" class="shortcut-item">
                            <div class="shortcut-dot" style="background: linear-gradient(135deg,#F97316,#EA580C);">
                                <i class="fa-solid fa-users-cog"></i>
                            </div>
                            <div class="shortcut-info">
                                <div class="shortcut-name">Kelola Akun Pengguna</div>
                                <div class="shortcut-preview">
                                    <div class="preview-row">
                                        <div class="preview-dot" style="background:#F97316"></div>
                                        Dokter aktif
                                        <span class="preview-val">25 akun</span>
                                    </div>
                                    <div class="preview-row">
                                        <div class="preview-dot" style="background:#FB923C"></div>
                                        Apoteker aktif
                                        <span class="preview-val">18 akun</span>
                                    </div>
                                    <div class="preview-row">
                                        <div class="preview-dot" style="background:#FED7AA"></div>
                                        Admin aktif
                                        <span class="preview-val">3 akun</span>
                                    </div>
                                </div>
                            </div>
                            <div class="shortcut-arrow"><i class="fa-solid fa-chevron-right"></i></div>
                        </a>

                        {{-- Card: Laporan & Analisis --}}
                        <a href="{{ route('laporanAnalisisData') }}" class="shortcut-item">
                            <div class="shortcut-dot" style="background: linear-gradient(135deg,#FB923C,#F59E0B);">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <div class="shortcut-info">
                                <div class="shortcut-name">Laporan &amp; Analisis Data</div>
                                <div class="shortcut-preview">
                                    <div class="preview-row">
                                        <div class="preview-dot" style="background:#F97316"></div>
                                        Transaksi bulan ini
                                        <span class="preview-val">320</span>
                                    </div>
                                    <div class="preview-row">
                                        <div class="preview-dot" style="background:#34D399"></div>
                                        Transaksi selesai
                                        <span class="preview-badge badge-ok">Selesai</span>
                                    </div>
                                    <div class="preview-row">
                                        <div class="preview-dot" style="background:#FCD34D"></div>
                                        Transaksi pending
                                        <span class="preview-badge badge-warning">Pending</span>
                                    </div>
                                </div>
                            </div>
                            <div class="shortcut-arrow"><i class="fa-solid fa-chevron-right"></i></div>
                        </a>

                    </div>
                </div>

                {{-- STOK OBAT MENIPIS --}}
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div>
                            <div class="dash-card-title">Stok Obat Menipis</div>
                            <div class="dash-card-sub">Perlu segera diisi ulang</div>
                        </div>
                    </div>
                    <div class="stok-list">
                        <div class="stok-item">
                            <div class="stok-dot" style="background:#F97316;"></div>
                            <div class="stok-info">
                                <div class="stok-name">Paracetamol 500mg</div>
                                <div class="stok-detail">Stok: 45 &nbsp;·&nbsp; Min: 100</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:45%;background:#F97316;"></div>
                            </div>
                            <span class="stok-badge badge-warning">Menipis</span>
                        </div>
                        <div class="stok-item">
                            <div class="stok-dot" style="background:#EA580C;"></div>
                            <div class="stok-info">
                                <div class="stok-name">Amoxicillin 500mg</div>
                                <div class="stok-detail">Stok: 32 &nbsp;·&nbsp; Min: 100</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:32%;background:#EA580C;"></div>
                            </div>
                            <span class="stok-badge badge-danger">Menipis</span>
                        </div>
                        <div class="stok-item">
                            <div class="stok-dot" style="background:#FCD34D;"></div>
                            <div class="stok-info">
                                <div class="stok-name">CTM 4mg</div>
                                <div class="stok-detail">Stok: 20 &nbsp;·&nbsp; Min: 50</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:40%;background:#FCD34D;"></div>
                            </div>
                            <span class="stok-badge badge-danger">Menipis</span>
                        </div>
                        <div class="stok-item">
                            <div class="stok-dot" style="background:#34D399;"></div>
                            <div class="stok-info">
                                <div class="stok-name">Vitamin C 500mg</div>
                                <div class="stok-detail">Stok: 80 &nbsp;·&nbsp; Min: 100</div>
                            </div>
                            <div class="stok-bar-wrap">
                                <div class="stok-bar" style="width:80%;background:#34D399;"></div>
                            </div>
                            <span class="stok-badge badge-ok">Aman</span>
                        </div>
                    </div>
                    <a href="{{ route('kelolaDataObat') }}" class="btn-all full">
                        <i class="fa-solid fa-box-open"></i> Lihat Semua Obat
                    </a>
                </div>

            </div>
            {{-- /MID GRID --}}

            {{-- TRANSAKSI TERBARU --}}
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Transaksi Terbaru</div>
                        <div class="dash-card-sub">Data transaksi hari ini</div>
                    </div>
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
                                <td><span class="status-badge status-selesai"><i class="fa-solid fa-circle-check" style="font-size:10px;"></i> Selesai</span></td>
                            </tr>
                            <tr>
                                <td><span class="trx-id">TRX-2024-0080</span></td>
                                <td><span class="trx-name">Jawak hiacek</span></td>
                                <td><span class="trx-type type-mandiri">Mandiri</span></td>
                                <td class="trx-amount">Rp 85.000</td>
                                <td class="trx-date">10 Mei 2026</td>
                                <td><span class="status-badge status-selesai"><i class="fa-solid fa-circle-check" style="font-size:10px;"></i> Selesai</span></td>
                            </tr>
                            <tr>
                                <td><span class="trx-id">TRX-2024-0079</span></td>
                                <td><span class="trx-name">Yeeree</span></td>
                                <td><span class="trx-type type-bpjs">BPJS</span></td>
                                <td class="trx-amount">Rp 210.000</td>
                                <td class="trx-date">07 Mei 2026</td>
                                <td><span class="status-badge status-pending"><i class="fa-solid fa-clock" style="font-size:10px;"></i> Pending</span></td>
                            </tr>
                            <tr>
                                <td><span class="trx-id">TRX-2024-0078</span></td>
                                <td><span class="trx-name">Regenn</span></td>
                                <td><span class="trx-type type-mandiri">Mandiri</span></td>
                                <td class="trx-amount">Rp 55.000</td>
                                <td class="trx-date">10 Mei 2026</td>
                                <td><span class="status-badge status-selesai"><i class="fa-solid fa-circle-check" style="font-size:10px;"></i> Selesai</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn-all-wrap">
                    <a href="{{ route('pantauTransaksi') }}" class="btn-all">
                        <i class="fa-solid fa-list"></i> Lihat Semua Transaksi
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/dashboardAdmin.js') }}"></script>
<script>
    // Tanggal & jam live di greeting
    function updateDatetime() {
        const el = document.getElementById('greeting-datetime');
        if (!el) return;
        const now  = new Date();
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const mons = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const hh   = String(now.getHours()).padStart(2,'0');
        const mm   = String(now.getMinutes()).padStart(2,'0');
        el.textContent = `${days[now.getDay()]}, ${now.getDate()} ${mons[now.getMonth()]} ${now.getFullYear()} — ${hh}:${mm}`;
    }
    updateDatetime();
    setInterval(updateDatetime, 30000);
</script>
@endpush