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

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <h2>Daftar Resep</h2>
                <p>Semua resep yang pernah dibuat &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <a href="{{ route('dokter.pilih-pasien') }}" class="btn-new">
                <i class="bi bi-plus-circle-fill"></i> Buat Resep Baru
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon tosca"><i class="bi bi-file-medical-fill"></i></div>
            <div>
                <div class="stat-label">Total Resep</div>
                <div class="stat-value">24</div>
                <div class="stat-sub">Semua status</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-label">Menunggu Validasi</div>
                <div class="stat-value">3</div>
                <div class="stat-sub">Belum diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-gear-fill"></i></div>
            <div>
                <div class="stat-label">Diproses</div>
                <div class="stat-value">8</div>
                <div class="stat-sub">Sedang berjalan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value">13</div>
                <div class="stat-sub">Bulan ini</div>
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="filter-tabs">
        <button class="filter-tab active" data-filter="semua">Semua</button>
        <button class="filter-tab" data-filter="validasi">Menunggu Validasi</button>
        <button class="filter-tab" data-filter="pembayaran">Menunggu Pembayaran</button>
        <button class="filter-tab" data-filter="diproses">Diproses</button>
        <button class="filter-tab" data-filter="selesai">Selesai</button>
        <button class="filter-tab" data-filter="draft">Draft</button>
    </div>

    {{-- TOOLBAR --}}
    <div class="toolbar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama pasien atau ID resep...">
        </div>    
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        <div class="table-header">
            <h3>Riwayat Resep</h3>
            <span id="jumlahTampil">Menampilkan 8 resep</span>
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
                    <tr data-status="validasi">
                        <td><span class="resep-id">RSP-2024-0053</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Rudi Hartono</div>
                                    <div class="pat-id">#PAT-0003</div>
                                </div>
                            </div>
                        </td>
                        <td>Infeksi Saluran Napas Atas</td>
                        <td><span class="obat-count">3 obat</span></td>
                        <td class="tgl">20 Mei 2024</td>
                        <td><span class="status-badge s-validasi">Menunggu Validasi</span></td>
                        <td>
                            <button class="btn-aksi-detail">Detail</button>
                            <button class="btn-aksi-edit">Edit</button>
                        </td>
                    </tr>
                    <tr data-status="validasi">
                        <td><span class="resep-id">RSP-2024-0052</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Dinda Permata</div>
                                    <div class="pat-id">#PAT-0002</div>
                                </div>
                            </div>
                        </td>
                        <td>Demam Tifoid</td>
                        <td><span class="obat-count">2 obat</span></td>
                        <td class="tgl">20 Mei 2024</td>
                        <td><span class="status-badge s-validasi">Menunggu Validasi</span></td>
                        <td>
                          <div class="aksi-wrap">
                            <button class="btn-aksi-detail">Detail</button>
                            <button class="btn-aksi-edit">Edit</button>
                          </div>
                        </td>
                    </tr>
                    <tr data-status="pembayaran">
                        <td><span class="resep-id">RSP-2024-0050</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Rini Wulandari</div>
                                    <div class="pat-id">#PAT-0005</div>
                                </div>
                            </div>
                        </td>
                        <td>Gastritis Akut</td>
                        <td><span class="obat-count">2 obat</span></td>
                        <td class="tgl">19 Mei 2024</td>
                        <td><span class="status-badge s-pembayaran">Menunggu Pembayaran</span></td>
                        <td>
                            <div class="aksi-wrap">
                            <button class="btn-aksi-detail">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="diproses">
                        <td><span class="resep-id">RSP-2024-0049</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Budi Hartono</div>
                                    <div class="pat-id">#PAT-0006</div>
                                </div>
                            </div>
                        </td>
                        <td>Hipertensi Grade 1</td>
                        <td><span class="obat-count">3 obat</span></td>
                        <td class="tgl">18 Mei 2024</td>
                        <td><span class="status-badge s-diproses">Diproses</span></td>
                        <td>
                            <div class="aksi-wrap">
                            <button class="btn-aksi-detail">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="selesai">
                        <td><span class="resep-id">RSP-2024-0051</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Andi Setiawan</div>
                                    <div class="pat-id">#PAT-0001</div>
                                </div>
                            </div>
                        </td>
                        <td>Diabetes Mellitus Tipe 2</td>
                        <td><span class="obat-count">4 obat</span></td>
                        <td class="tgl">17 Mei 2024</td>
                        <td><span class="status-badge s-selesai">Selesai</span></td>
                        <td>
                             <div class="aksi-wrap">
                            <button class="btn-aksi-detail">Detail</button>
                             </div>
                        </td>
                    </tr>
                    <tr data-status="selesai">
                        <td><span class="resep-id">RSP-2024-0048</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Maya Sari</div>
                                    <div class="pat-id">#PAT-0007</div>
                                </div>
                            </div>
                        </td>
                        <td>Faringitis Akut</td>
                        <td><span class="obat-count">2 obat</span></td>
                        <td class="tgl">16 Mei 2024</td>
                        <td><span class="status-badge s-selesai">Selesai</span></td>
                        <td>
                            <div class="aksi-wrap">
                            <button class="btn-aksi-detail">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="draft">
                        <td><span class="resep-id">RSP-2024-0047</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Lina Permata</div>
                                    <div class="pat-id">#PAT-0008</div>
                                </div>
                            </div>
                        </td>
                        <td>Belum diisi</td>
                        <td><span class="obat-count">1 obat</span></td>
                        <td class="tgl">15 Mei 2024</td>
                        <td><span class="status-badge s-draft">Draft</span></td>
                        <td>
                            <div class="aksi-wrap">
                            <button class="btn-aksi-detail">Detail</button>
                            <button class="btn-aksi-edit">Lanjutkan</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="diproses">
                        <td><span class="resep-id">RSP-2024-0046</span></td>
                        <td>
                            <div class="patient-cell">
                                    <div class="pat-name">Agus Salim</div>
                                    <div class="pat-id">#PAT-0009</div>
                                </div>
                            </div>
                        </td>
                        <td>Bronkitis Akut</td>
                        <td><span class="obat-count">3 obat</span></td>
                        <td class="tgl">14 Mei 2024</td>
                        <td><span class="status-badge s-diproses">Diproses</span></td>
                        <td>
                            <div class="aksi-wrap">
                            <button class="btn-aksi-detail">Detail</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/daftarResep.js') }}"></script>
@endpush