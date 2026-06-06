@extends('layouts.app')

@section('title', 'Daftar Resep - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/daftarResep.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="daftar-resep-wrap">
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <h2>Daftar Resep</h2>
                <p>Semua resep yang pernah dibuat - {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <a href="{{ route('dokter.pilih.pasien') }}" class="btn-new">
                <i class="bi bi-plus-circle-fill"></i> Buat Resep Baru
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon tosca"><i class="bi bi-file-medical-fill"></i></div>
            <div>
                <div class="stat-label">Total Resep</div>
                <div class="stat-value">{{ $totalResep ?? 0 }}</div>
                <div class="stat-sub">Semua status</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-label">Menunggu Validasi</div>
                <div class="stat-value">{{ $totalMenunggu ?? 0 }}</div>
                <div class="stat-sub">Belum diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-gear-fill"></i></div>
            <div>
                <div class="stat-label">Diproses</div>
                <div class="stat-value">{{ $totalDiproses ?? 0 }}</div>
                <div class="stat-sub">Sedang berjalan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $totalSelesai ?? 0 }}</div>
                <div class="stat-sub">Semua waktu</div>
            </div>
        </div>
    </div>

    <div class="filter-tabs">
        <a class="filter-tab {{ empty($status) ? 'active' : '' }}" href="{{ route('dokter.resep') }}">Semua</a>
        <a class="filter-tab {{ $status === 'menunggu' ? 'active' : '' }}" href="{{ route('dokter.resep', ['status' => 'menunggu']) }}">Menunggu Validasi</a>
        <a class="filter-tab {{ $status === 'menunggu_pembayaran' ? 'active' : '' }}" href="{{ route('dokter.resep', ['status' => 'menunggu_pembayaran']) }}">Menunggu Pembayaran</a>
        <a class="filter-tab {{ $status === 'diproses' ? 'active' : '' }}" href="{{ route('dokter.resep', ['status' => 'diproses']) }}">Diproses</a>
        <a class="filter-tab {{ $status === 'selesai' ? 'active' : '' }}" href="{{ route('dokter.resep', ['status' => 'selesai']) }}">Selesai</a>
    </div>

    <div class="toolbar">
        <form method="GET" action="{{ route('dokter.resep') }}" class="search-wrap">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <i class="bi bi-calendar"></i>
            <input type="date" name="tanggal" value="{{ $tanggal }}">
            <button type="submit" class="btn-new" style="border:0;">Filter</button>
        </form>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3>Riwayat Resep</h3>
            <span>Menampilkan {{ $resepList->count() }} resep</span>
        </div>
        <div class="table-wrap">
            <table id="resepTable">
                <thead>
                    <tr>
                        <th>ID Resep</th>
                        <th>Pasien</th>
                        <th>Diagnosa</th>
                        <th>Jml Obat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resepList as $detail)
                        @php
                            $namaPasien = $detail->pasien->user->nama ?? 'Pasien';
                            $initial = strtoupper(substr($namaPasien, 0, 2));
                            $statusClass = match($detail->status) {
                                'menunggu' => 's-validasi',
                                'menunggu_pembayaran' => 's-pembayaran',
                                'diproses' => 's-diproses',
                                'selesai' => 's-selesai',
                                default => 's-draft',
                            };
                        @endphp
                        <tr data-status="{{ $detail->status }}">
                            <td><span class="resep-id">RSP-{{ str_pad($detail->id_resep, 4, '0', STR_PAD_LEFT) }}</span></td>
                            <td>
                                <div class="patient-cell">
                                    <div class="av av-1">{{ $initial }}</div>
                                    <div>
                                        <div class="pat-name">{{ $namaPasien }}</div>
                                        <div class="pat-id">#PAT-{{ str_pad($detail->id_pasien, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $detail->diagnosa ?? '-' }}</td>
                            <td><span class="obat-count">{{ $detail->resep->resepObat->count() }} obat</span></td>
                            <td class="tgl">{{ optional($detail->tanggal)->format('d M Y') }}</td>
                            <td><span class="status-badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $detail->status)) }}</span></td>
                            <td><a class="btn-aksi-detail" href="{{ route('dokter.resep.detail', $detail->id_detail_resep) }}">Detail</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;">Belum ada resep.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($resepList->hasPages())
            <div style="padding:16px;">
                {{ $resepList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/daftarResep.js') }}"></script>
@endpush
