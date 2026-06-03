@extends('layouts.app')

@section('title', 'Kelola Data Obat - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/kelolaDataObat.css') }}">

    <div class="dash-main">
        <div class="dash-content">

            {{-- SUMMARY CARDS --}}
            <div class="med-summary">
                <div class="summary-card filter-card active" data-filter-status="all" title="Tampilkan semua obat">
                    <div class="summary-icon icon-total">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Obat</div>
                        <div class="summary-value" id="count-total">0</div>
                    </div>
                </div>

                <div class="summary-card filter-card" data-filter-status="rendah" title="Tampilkan stok menipis">
                    <div class="summary-icon icon-low">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Stok Menipis</div>
                        <div class="summary-value" id="count-rendah">0</div>
                    </div>
                </div>

                <div class="summary-card filter-card" data-filter-status="habis" title="Tampilkan stok habis">
                    <div class="summary-icon icon-empty">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Stok Habis</div>
                        <div class="summary-value" id="count-habis">0</div>
                    </div>
                </div>

                <div class="summary-card filter-card" data-filter-status="expired" title="Tampilkan akan kadaluarsa">
                    <div class="summary-icon icon-expired">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Akan Kadaluarsa</div>
                        <div class="summary-value" id="count-expired">0</div>
                    </div>
                </div>
            </div>

            {{-- FILTERS & SEARCH --}}
            <div class="filter-section">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="search-input" placeholder="Cari nama obat, kode, atau supplier..." class="search-input">
                    <button class="search-clear" id="search-clear" style="display:none;" title="Hapus pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="filter-group">
                    <select class="filter-select" id="filter-category">
                        <option value="">Semua Kategori</option>
                        <option value="analgesik">Analgesik</option>
                        <option value="antibiotik">Antibiotik</option>
                        <option value="antihistamin">Antihistamin</option>
                        <option value="vitamin">Vitamin</option>
                    </select>

                    <select class="filter-select" id="filter-status">
                        <option value="">Semua Status</option>
                        <option value="aman">Aman</option>
                        <option value="rendah">Rendah</option>
                        <option value="menipis">Menipis</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
            </div>

            {{-- MEDICINES TABLE --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table medicines-table">
                        <thead>
                            <tr>
                                <th width="5%" style="text-align:center;"><input type="checkbox" id="check-all"></th>
                                <th style="text-align:center;">Nama Obat</th>
                                <th style="text-align:center;">Kategori</th>
                                <th style="text-align:center;">Stok</th>
                                <th style="text-align:center;">Minimum</th>
                                <th style="text-align:center;">Harga</th>
                                <th style="text-align:center;">Supplier</th>
                                <th style="text-align:center;">Tgl Exp</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="medicine-tbody"></tbody>
                    </table>
                    <div id="empty-state" style="display:none;" class="empty-state">
                        <i class="fa-solid fa-box-open"></i>
                        <p>Tidak ada data obat yang ditemukan.</p>
                    </div>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Menampilkan <strong id="pag-from">0</strong>-<strong id="pag-to">0</strong>
                    dari <strong id="pag-total">0</strong> obat
                </div>
                <div class="pagination" id="pagination-controls"></div>
            </div>

        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal-overlay" id="modal-detail" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Detail Obat</h3>
                <button class="modal-close" id="modal-detail-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body" id="modal-detail-body"></div>
            <div class="modal-footer">
                <button class="btn-modal-primary" id="modal-detail-close-btn">Tutup</button>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal-overlay" id="modal-edit" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Edit Obat</h3>
                <button class="modal-close" id="modal-edit-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body" id="modal-edit-body"></div>
            <div class="modal-footer">
                <button class="btn-modal-secondary" id="modal-edit-cancel">Batal</button>
                <button class="btn-modal-primary" id="modal-edit-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    {{-- CONTEXT MENU — posisi fixed, tidak ikut scroll --}}
    <div class="context-menu" id="context-menu" style="display:none;">
        <button class="ctx-item ctx-edit"    id="ctx-edit"><i class="fa-solid fa-pen"></i> Edit Obat</button>
        <button class="ctx-item ctx-restock" id="ctx-restock"><i class="fa-solid fa-boxes-stacking"></i> Restock</button>
        <button class="ctx-item ctx-delete"  id="ctx-delete"><i class="fa-solid fa-trash"></i> Hapus Obat</button>
    </div>

    {{-- TOAST --}}
    <div class="toast-container" id="toast-container"></div>

<script src="{{ asset('js/kelolaDataObat.js') }}"></script>
</div>
@endsection