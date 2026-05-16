@extends('layouts.app')

@section('title', 'Resep Digital - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/admin/resepDigital.css') }}">

    <div class="dash-main">
        <div class="dash-content">

            {{-- PAGE HEADER --}}
            <div class="page-header">
                <div>
                    <h1 class="page-title"><i class="fa-solid fa-file-prescription"></i> Resep Digital</h1>
                    <p class="page-sub">Kelola dan pantau semua resep digital pasien</p>
                </div>
                <div class="page-actions">
                    <button class="btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
                    <button class="btn-primary"><i class="fa-solid fa-plus"></i> Tambah Resep</button>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#eafaf7;color:#2ea08a;">
                        <i class="fa-solid fa-file-prescription"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Resep</div>
                        <div class="stat-value">320</div>
                        <div class="stat-sub">↑ 12% bulan ini</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fff3e0;color:#e65100;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <div class="stat-label">Menunggu Validasi</div>
                        <div class="stat-value">24</div>
                        <div class="stat-sub">Perlu segera diproses</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#e3f2fd;color:#004369;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="stat-label">Sudah Diproses</div>
                        <div class="stat-value">289</div>
                        <div class="stat-sub">90.3% completion rate</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fce4ec;color:#c2185b;">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div>
                        <div class="stat-label">Ditolak</div>
                        <div class="stat-value">7</div>
                        <div class="stat-sub">Perlu tindak lanjut</div>
                    </div>
                </div>
            </div>

            {{-- FILTER BAR --}}
            <div class="dash-card" style="margin-bottom:16px;">
                <div class="filter-bar">
                    <div class="search-wrap">
                        <i class="fa-solid fa-search"></i>
                        <input type="text" class="search-input" placeholder="Cari nama pasien, dokter, atau kode resep...">
                    </div>
                    <select class="filter-select">
                        <option>Semua Status</option>
                        <option>Menunggu Validasi</option>
                        <option>Diproses</option>
                        <option>Selesai</option>
                        <option>Ditolak</option>
                    </select>
                    <select class="filter-select">
                        <option>Semua Dokter</option>
                        <option>dr. Andi Pratama</option>
                        <option>dr. Sari Dewi</option>
                        <option>dr. Budi Santoso</option>
                    </select>
                    <input type="date" class="filter-select">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <div class="dash-card-title">Daftar Resep Digital</div>
                        <div class="dash-card-sub">Menampilkan 10 dari 320 data</div>
                    </div>
                    <button class="btn-link"><i class="fa-solid fa-download"></i> Export</button>
                </div>
                <div class="table-wrap">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Kode Resep</th>
                                <th>Nama Pasien</th>
                                <th>Dokter</th>
                                <th>Obat</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $reseps = [
                                ['RSP-2026-0081','Kenzi Nomik','dr. Andi Pratama','Paracetamol 500mg','01 Mei 2026','Selesai'],
                                ['RSP-2026-0080','Jawak Hiacek','dr. Sari Dewi','Amoxicillin 500mg, CTM 4mg','10 Mei 2026','Selesai'],
                                ['RSP-2026-0079','Yeeree Amirul','dr. Budi Santoso','Vitamin C 500mg','07 Mei 2026','Menunggu'],
                                ['RSP-2026-0078','Regenn Putra','dr. Andi Pratama','Antasida, Omeprazole','10 Mei 2026','Diproses'],
                                ['RSP-2026-0077','Sinta Marlina','dr. Sari Dewi','Metformin 500mg','05 Mei 2026','Selesai'],
                                ['RSP-2026-0076','Budi Hartono','dr. Rudi Firmansyah','Simvastatin 10mg','04 Mei 2026','Ditolak'],
                                ['RSP-2026-0075','Laila Fitria','dr. Andi Pratama','Captopril 12.5mg','03 Mei 2026','Menunggu'],
                                ['RSP-2026-0074','Ahmad Fauzi','dr. Budi Santoso','Cetirizine 10mg','02 Mei 2026','Selesai'],
                            ];
                            $statusMap = [
                                'Selesai'  => 'status-selesai',
                                'Menunggu' => 'status-pending',
                                'Diproses' => 'status-proses',
                                'Ditolak'  => 'status-tolak',
                            ];
                            @endphp
                            @foreach($reseps as $r)
                            <tr>
                                <td><span class="trx-id">{{ $r[0] }}</span></td>
                                <td><span class="trx-name">{{ $r[1] }}</span></td>
                                <td><span class="dokter-name">{{ $r[2] }}</span></td>
                                <td><span class="obat-list">{{ $r[3] }}</span></td>
                                <td class="trx-date">{{ $r[4] }}</td>
                                <td>
                                    <span class="status-badge {{ $statusMap[$r[5]] }}">
                                        @if($r[5] === 'Selesai') <i class="fa-solid fa-circle-check" style="font-size:10px;"></i>
                                        @elseif($r[5] === 'Menunggu') <i class="fa-solid fa-clock" style="font-size:10px;"></i>
                                        @elseif($r[5] === 'Diproses') <i class="fa-solid fa-spinner" style="font-size:10px;"></i>
                                        @else <i class="fa-solid fa-circle-xmark" style="font-size:10px;"></i>
                                        @endif
                                        {{ $r[5] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="act-btn act-view" title="Lihat Detail"><i class="fa-solid fa-eye"></i></button>
                                        <button class="act-btn act-edit" title="Edit"><i class="fa-solid fa-pen"></i></button>
                                        <button class="act-btn act-del" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="pagination-wrap">
                    <span class="page-info">Menampilkan 1–8 dari 320 resep</span>
                    <div class="page-btns">
                        <button class="page-btn" disabled><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <span class="page-dots">...</span>
                        <button class="page-btn">40</button>
                        <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL DETAIL RESEP --}}
<div class="modal-overlay" id="modalResep">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <div class="modal-title">Detail Resep Digital</div>
                <div class="modal-sub">RSP-2026-0081</div>
            </div>
            <button class="modal-close" onclick="document.getElementById('modalResep').classList.remove('show')">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-item"><span class="detail-label">Pasien</span><span class="detail-val">Kenzi Nomik</span></div>
                <div class="detail-item"><span class="detail-label">No. RM</span><span class="detail-val">RM-0012345</span></div>
                <div class="detail-item"><span class="detail-label">Dokter</span><span class="detail-val">dr. Andi Pratama</span></div>
                <div class="detail-item"><span class="detail-label">Poli</span><span class="detail-val">Poli Umum</span></div>
                <div class="detail-item"><span class="detail-label">Tanggal</span><span class="detail-val">01 Mei 2026</span></div>
                <div class="detail-item"><span class="detail-label">Tipe</span><span class="detail-val">BPJS</span></div>
            </div>
            <div class="detail-divider"></div>
            <div class="obat-detail-list">
                <div class="obat-detail-title">Daftar Obat</div>
                <div class="obat-detail-item">
                    <div class="obat-no">1</div>
                    <div>
                        <div class="obat-detail-name">Paracetamol 500mg</div>
                        <div class="obat-detail-info">3x1 · Sesudah makan · 10 tablet</div>
                    </div>
                    <div class="obat-detail-price">Rp 15.000</div>
                </div>
                <div class="obat-detail-item">
                    <div class="obat-no">2</div>
                    <div>
                        <div class="obat-detail-name">Vitamin C 500mg</div>
                        <div class="obat-detail-info">1x1 · Sesudah makan · 10 tablet</div>
                    </div>
                    <div class="obat-detail-price">Rp 12.000</div>
                </div>
            </div>
            <div class="detail-divider"></div>
            <div class="modal-total">
                <span>Total Biaya</span>
                <span class="total-val">Rp 27.000</span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-outline" onclick="document.getElementById('modalResep').classList.remove('show')">Tutup</button>
            <button class="btn-primary"><i class="fa-solid fa-print"></i> Cetak Resep</button>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.act-view').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('modalResep').classList.add('show');
    });
});
</script>
@endsection