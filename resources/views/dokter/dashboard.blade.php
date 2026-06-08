@extends('layouts.app')

@section('title', 'Dashboard Dokter - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">
    <div class="page-header">
        <h1>Selamat datang, {{ Auth::user()->nama }}</h1>
        <p>Dashboard Dokter - {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon tosca"><i class="fas fa-list-ol"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $antrianHariIni ?? 0 }}</span>
                <span class="stat-label">Antrian Pasien</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-file-prescription"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $resepHariIni ?? 0 }}</span>
                <span class="stat-label">Resep Dibuat</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $pasienDilayaniBulanIni ?? 0 }}</span>
                <span class="stat-label">Pasien Dilayani</span>
                <span class="stat-sub">Bulan ini</span>
            </div>
        </div>
    </div>

    <div class="mid-grid">
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <div class="dash-card-title">Aksi Cepat</div>
                    <div class="dash-card-sub">Mulai tugas dokter hari ini</div>
                </div>
            </div>
            <div class="shortcut-grid">
                <a href="{{ route('dokter.pilih.pasien') }}" class="shortcut-card">
                    <div class="shortcut-icon tosca"><i class="fas fa-users"></i></div>
                    <span>Pilih Pasien</span>
                </a>
                <a href="{{ route('dokter.pilih.pasien') }}" class="shortcut-card">
                    <div class="shortcut-icon blue"><i class="fas fa-file-prescription"></i></div>
                    <span>Buat Resep</span>
                </a>
                <a href="{{ route('dokter.resep') }}" class="shortcut-card">
                    <div class="shortcut-icon navy"><i class="fas fa-clipboard-list"></i></div>
                    <span>Daftar Resep</span>
                </a>
                <a href="{{ route('dokter.antrian') }}" class="shortcut-card">
                    <div class="shortcut-icon pink"><i class="fas fa-chart-bar"></i></div>
                    <span>Antrian</span>
                </a>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <div class="dash-card-title">Antrian Pasien</div>
                    <div class="dash-card-sub">Hari ini</div>
                </div>
                <a href="{{ route('dokter.antrian') }}" class="btn-link">Lihat Semua</a>
            </div>
            <div class="antrian-list">
                @forelse($antrianTerbaru ?? [] as $antrian)
                    <div class="antrian-item">
                        <strong>#{{ $antrian->nomor_antrian }}</strong>
                        <span>{{ $antrian->pasien->user->nama ?? 'Pasien' }}</span>
                        <small>{{ ucfirst($antrian->status) }}</small>
                    </div>
                @empty
                    <div class="antrian-empty">
                        <i class="fas fa-user-clock"></i>
                        <p>Belum ada antrian hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card-header">
            <div>
                <div class="dash-card-title">Resep Terbaru</div>
                <div class="dash-card-sub">Resep yang baru saja dibuat</div>
            </div>
            <a href="{{ route('dokter.resep') }}" class="btn-link">Lihat Semua</a>
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID Resep</th>
                        <th>Nama Pasien</th>
                        <th>Diagnosa</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resepTerbaru ?? [] as $detail)
                        <tr>
                            <td><span class="trx-id">RSP-{{ str_pad($detail->id_resep, 4, '0', STR_PAD_LEFT) }}</span></td>
                            <td><span class="trx-name">{{ $detail->pasien->user->nama ?? '-' }}</span></td>
                            <td>{{ $detail->diagnosa ?? '-' }}</td>
                            <td class="trx-date">{{ optional($detail->tanggal)->format('d M Y') }}</td>
                            <td><span class="status-badge status-{{ $detail->status === 'selesai' ? 'selesai' : ($detail->status === 'menunggu' ? 'warning' : 'success') }}">{{ ucfirst(str_replace('_', ' ', $detail->status)) }}</span></td>
                            <td><a href="{{ route('dokter.resep.detail', $detail->id_detail_resep) }}" class="btn-aksi">Detail</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">Belum ada resep.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboardDokter.js') }}"></script>
@endpush
