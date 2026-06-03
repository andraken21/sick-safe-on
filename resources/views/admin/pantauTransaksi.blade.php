@extends('layouts.app')

@section('title', 'Pantau Transaksi - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/pantauTransaksi.css') }}">

    <div class="dash-main">
        <div class="dash-content">

            {{-- SUMMARY CARDS --}}
            <div class="trx-summary">
                <div class="summary-card filter-card active" data-filter-status="all" title="Tampilkan semua transaksi">
                    <div class="summary-icon icon-total">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Transaksi</div>
                        <div class="summary-value" id="count-total">0</div>
                        <div class="summary-sub">Bulan ini</div>
                    </div>
                </div>

                <div class="summary-card filter-card" data-filter-status="selesai" title="Tampilkan transaksi selesai">
                    <div class="summary-icon icon-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Transaksi Selesai</div>
                        <div class="summary-value" id="count-selesai">0</div>
                        <div class="summary-sub" id="sub-selesai">Rp 0</div>
                    </div>
                </div>

                <div class="summary-card filter-card" data-filter-status="pending" title="Tampilkan transaksi pending">
                    <div class="summary-icon icon-pending">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Transaksi Pending</div>
                        <div class="summary-value" id="count-pending">0</div>
                        <div class="summary-sub" id="sub-pending">Rp 0</div>
                    </div>
                </div>
            </div>

            {{-- FILTERS & SEARCH --}}
            <div class="filter-section">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="search-input"
                           placeholder="Cari No. Transaksi atau nama pasien..."
                           class="search-input">
                    <button class="search-clear" id="search-clear" style="display:none;" title="Hapus pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="filter-group">
                    <select class="filter-select" id="filter-type">
                        <option value="">Semua Tipe</option>
                        <option value="bpjs">BPJS</option>
                        <option value="mandiri">Mandiri</option>
                    </select>
                    <select class="filter-select" id="filter-status">
                        <option value="">Semua Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            {{-- TRANSACTIONS TABLE --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table transactions-table">
                        <thead>
                            <tr>
                                <th width="4%"><input type="checkbox" id="check-all"></th>
                                <th>No. Transaksi</th>
                                <th>Nama Pasien</th>
                                <th>No. RM</th>
                                <th>Tipe</th>
                                <th>Total</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="trx-tbody"></tbody>
                    </table>
                    <div id="empty-state" style="display:none;" class="empty-state">
                        <i class="fa-solid fa-receipt"></i>
                        <p>Tidak ada transaksi yang ditemukan.</p>
                    </div>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Menampilkan <strong id="pag-from">0</strong>–<strong id="pag-to">0</strong>
                    dari <strong id="pag-total">0</strong> transaksi
                </div>
                <div class="pagination" id="pagination-controls"></div>
            </div>

        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal-overlay" id="modal-detail" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Detail Transaksi</h3>
                <button class="modal-close" id="modal-detail-close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-detail-body"></div>
            <div class="modal-footer">
                <button class="btn-modal-secondary" id="modal-detail-print">
                    <i class="fa-solid fa-print"></i> Cetak
                </button>
                <button class="btn-modal-primary" id="modal-detail-close-btn">
                    <i class="fa-solid fa-xmark"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast-container" id="toast-container"></div>

</div>

<script src="{{ asset('js/pantauTransaksi.js') }}"></script>
@endsection