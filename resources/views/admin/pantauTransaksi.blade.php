@extends('layouts.app')

@section('title', 'Pantau Transaksi - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/pantauTransaksi.css') }}">

    {{-- MAIN AREA --}}
    <div class="dash-main">

        <!-- {{-- TOPBAR --}}
        <div class="dash-topbar">
            <div>
                <div class="topbar-title">Pantau Transaksi</div>
                <div class="topbar-sub">Pantau semua transaksi BPJS dan pembayaran mandiri</div>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Refresh">
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                </button>
                <button class="topbar-btn" title="Export">
                    <i class="fa-solid fa-download"></i>
                </button>
            </div>
        </div> -->

        {{-- CONTENT --}}
        <div class="dash-content">

            {{-- SUMMARY CARDS --}}
            <div class="trx-summary">
                <div class="summary-card">
                    <div class="summary-icon icon-total">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Transaksi</div>
                        <div class="summary-value">847</div>
                        <div class="summary-sub">Bulan ini</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Transaksi Selesai</div>
                        <div class="summary-value">823</div>
                        <div class="summary-sub">Rp 245.5 Juta</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-pending">
                        <i class="fa-solid fa-hourglass-end"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Transaksi Pending</div>
                        <div class="summary-value">18</div>
                        <div class="summary-sub">Rp 12.3 Juta</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-failed">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Transaksi Gagal</div>
                        <div class="summary-value">6</div>
                        <div class="summary-sub">Rp 850.000</div>
                    </div>
                </div>
            </div>

            {{-- FILTERS & SEARCH --}}
            <div class="filter-section">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari No. Transaksi atau nama pasien..." class="search-input">
                </div>

                <div class="filter-group">
                    <select class="filter-select">
                        <option value="">Semua Tipe</option>
                        <option value="bpjs">BPJS</option>
                        <option value="mandiri">Mandiri</option>
                    </select>

                    <select class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="pending">Pending</option>
                        <option value="gagal">Gagal</option>
                    </select>

                    <input type="date" class="filter-date">

                    <button class="btn-filter">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                </div>
            </div>

            {{-- TRANSACTIONS TABLE --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table transactions-table">
                        <thead>
                            <tr>
                                <th width="5%"><input type="checkbox" class="check-all"></th>
                                <th>No. Transaksi</th>
                                <th>Nama Pasien</th>
                                <th>No. RM</th>
                                <th>Tipe</th>
                                <th>Total</th>
                                <th>Waktu</th>
                                <th>Kasir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Transaction 1 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0847</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Andi Setiawan</div>
                                        <div class="patient-sub">Pasien Umum</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-02456</span></td>
                                <td><span class="type-badge type-bpjs">BPJS</span></td>
                                <td class="amount-cell">Rp 125.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">14:32 WIB</div>
                                </td>
                                <td>Siti Indriyani</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 2 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0846</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Dewi Kusuma</div>
                                        <div class="patient-sub">Pasien BPJS</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-01298</span></td>
                                <td><span class="type-badge type-mandiri">Mandiri</span></td>
                                <td class="amount-cell">Rp 85.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">13:15 WIB</div>
                                </td>
                                <td>Reza Pratama</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 3 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0845</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Bambang Sutrisno</div>
                                        <div class="patient-sub">Pasien Umum</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-03121</span></td>
                                <td><span class="type-badge type-bpjs">BPJS</span></td>
                                <td class="amount-cell">Rp 210.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">12:45 WIB</div>
                                </td>
                                <td>Aprina Santoso</td>
                                <td><span class="status-badge status-pending">⏳ Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 4 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0844</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Lina Maulida</div>
                                        <div class="patient-sub">Pasien BPJS</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-02897</span></td>
                                <td><span class="type-badge type-mandiri">Mandiri</span></td>
                                <td class="amount-cell">Rp 55.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">11:20 WIB</div>
                                </td>
                                <td>Siti Indriyani</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 5 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0843</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Hendra Gunawan</div>
                                        <div class="patient-sub">Pasien Umum</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-01567</span></td>
                                <td><span class="type-badge type-bpjs">BPJS</span></td>
                                <td class="amount-cell">Rp 320.000</td>
                                <td class="time-cell">
                                    <div>15 Mei 2026</div>
                                    <div class="time-sub">16:05 WIB</div>
                                </td>
                                <td>Nurul Putri</td>
                                <td><span class="status-badge status-gagal">✗ Gagal</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 6 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0842</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Maya Safitri</div>
                                        <div class="patient-sub">Pasien BPJS</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-02345</span></td>
                                <td><span class="type-badge type-mandiri">Mandiri</span></td>
                                <td class="amount-cell">Rp 175.000</td>
                                <td class="time-cell">
                                    <div>15 Mei 2026</div>
                                    <div class="time-sub">15:30 WIB</div>
                                </td>
                                <td>Reza Pratama</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Menampilkan <strong>1-6</strong> dari <strong>847</strong> transaksi
                </div>
                <div class="pagination">
                    <button class="page-btn" disabled><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">4</button>
                    <button class="page-btn">5</button>
                    <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>

        </div>
        {{-- /CONTENT --}}

    </div>
    {{-- /MAIN AREA --}}

<script src="{{ asset('js/monitorTransaction.js') }}"></script>
</div>
@endsection