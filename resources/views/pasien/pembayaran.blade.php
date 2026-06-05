@extends('layouts.app')

@section('title', 'Pembayaran — Sick Safe ON')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
<div class="bayar-page">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <h1>Pembayaran 💳</h1>
            <p>Kelola dan pantau semua transaksi pembayaran Anda</p>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon stat-icon--teal">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stat-text">
                <div class="num">Rp {{ number_format($totalDibayar ?? 0, 0, ',', '.') }}</div>
                <div class="lbl">Total Dibayar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--warning">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color:var(--ss-warning);">{{ $menungguBayar ?? 0 }}</div>
                <div class="lbl">Menunggu Bayar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--success">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color:var(--ss-success);">{{ $totalLunas ?? 0 }}</div>
                <div class="lbl">Lunas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--info">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-text">
                <div class="num" style="color:var(--ss-info);">BPJS</div>
                <div class="lbl">Metode Utama</div>
            </div>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="main-grid">

        {{-- TABEL RIWAYAT --}}
        <div class="table-card"
             id="pembayaranTableData"
             data-transactions="{{ base64_encode(json_encode($pembayaranList ?? [])) }}">
            <div class="card-head">
                <h2>Riwayat Pembayaran</h2>
                <span class="badge-count">{{ count($pembayaranList ?? []) }} Transaksi</span>
            </div>

            <div class="filter-bar">
                <div class="search-wrap">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" placeholder="Cari invoice...">
                </div>
                <select class="filter-select">
                    <option value="Semua Status">Semua Status</option>
                    <option value="lunas">Lunas</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="proses">Diproses</option>
                    <option value="gagal">Gagal</option>
                </select>
                <select class="filter-select">
                    <option value="Semua Metode">Semua Metode</option>
                    <option value="BPJS">BPJS</option>
                    <option value="Mandiri">Mandiri</option>
                </select>
            </div>

            <table class="bayar-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Baris awal diisi oleh pembayaran.js (renderTable()) --}}
                </tbody>
            </table>

            <div class="pagination-wrap">
                <div class="pagination-info"></div>
                <div class="pagination-btns"></div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="side-col">

            {{-- TAGIHAN AKTIF --}}
            <div class="side-card">
                <div class="side-card-head">
                    <h3>Tagihan Aktif</h3>
                </div>
                <div class="side-card-body">
                    @if($detailPembayaran)
                    {{--
                        Semua nilai PHP disimpan di data-* agar JS bisa
                        membacanya tanpa Blade syntax di dalam file .js
                    --}}
                    <div class="tagihan-list"
                         id="tagihanData"
                         data-subtotal="{{ $detailPembayaran['subtotal_obat'] }}"
                         data-layanan="{{ $detailPembayaran['biaya_layanan'] }}"
                         data-total-normal="{{ $detailPembayaran['total'] }}"
                         data-invoice="{{ $detailPembayaran['nomor_invoice'] }}"
                         data-status="{{ strtolower($detailPembayaran['status']) }}"
                         data-bayar-url="{{ route('pasien.pembayaran.bayar', $detailPembayaran['id_transaksi']) }}"
                         data-proses-url="{{ route('pasien.pembayaran.proses') }}">

                        <div class="tagihan-row">
                            <span class="lbl">NO. INVOICE</span>
                            <span class="val" style="color:var(--ss-primary);">{{ $detailPembayaran['nomor_invoice'] }}</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Resep</span>
                            <span class="val">{{ $detailPembayaran['resep_id'] }}</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Dokter &amp; Obat</span>
                            <span class="val">{{ $detailPembayaran['dokter'] }}</span>
                        </div>
                        <div class="tagihan-divider"></div>
                        <div class="tagihan-row">
                            <span class="lbl">Subtotal obat</span>
                            <span class="val" id="tagihanSubtotal">Rp {{ number_format($detailPembayaran['subtotal_obat'], 0, ',', '.') }}</span>
                        </div>
                        <div class="tagihan-row">
                            <span class="lbl">Biaya layanan</span>
                            <span class="val" id="tagihanLayanan">Rp {{ number_format($detailPembayaran['biaya_layanan'], 0, ',', '.') }}</span>
                        </div>
                        <div class="tagihan-row" id="tagihanDiskonRow">
                            <span class="lbl" id="tagihanDiskonLbl">Diskon {{ $detailPembayaran['metode'] }}</span>
                            <span class="val" id="tagihanDiskon">- Rp {{ number_format($detailPembayaran['diskon'], 0, ',', '.') }}</span>
                        </div>
                        <div class="tagihan-divider"></div>
                        <div class="tagihan-total">
                            <span class="lbl">Total Bayar</span>
                            <span class="val" id="tagihanTotal">Rp {{ number_format($detailPembayaran['total_bayar'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if(strtolower($detailPembayaran['status']) === 'menunggu')
                    {{-- href diisi oleh JS berdasarkan metode terpilih --}}
                    <a href="#" id="btnBayarSekarang" class="btn-bayar" style="margin-top:12px;">
                        Bayar Sekarang
                    </a>
                    @endif

                    <p id="btnBayarInfo" style="display:none; text-align:center; font-size:.78rem; color:var(--ss-muted); margin-top:8px;"></p>
                    @else
                    <p style="text-align: center; color: var(--ss-muted);">Tidak ada tagihan aktif.</p>
                    @endif
                </div>
            </div>

            {{-- METODE PEMBAYARAN --}}
            <div class="side-card">
                <div class="side-card-head">
                    <h3>Metode Pembayaran</h3>
                </div>
                <div class="side-card-body">
                    <div class="metode-list">
                        <div class="metode-item active" data-metode="BPJS">
                            <div class="metode-item-left">
                                <div class="metode-badge metode-badge--bpjs">📋</div>
                                <div>
                                    <div class="metode-name">BPJS Kesehatan</div>
                                    <div class="metode-desc">Peserta aktif</div>
                                </div>
                            </div>
                            <div class="metode-check"></div>
                        </div>
                        <div class="metode-item" data-metode="Mandiri">
                            <div class="metode-item-left">
                                <div class="metode-badge metode-badge--mandiri">🏦</div>
                                <div>
                                    <div class="metode-name">Mandiri</div>
                                </div>
                            </div>
                            <div class="metode-check"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL PEMBAYARAN --}}
    <div class="modal-overlay" id="modalPayment">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-left">
                    <h2 id="modalTitle">Konfirmasi Pembayaran</h2>
                    <p id="modalSubtitle">INV-2026-0077</p>
                </div>
                <button class="modal-close" id="modalCloseBtn">✕</button>
            </div>
            <div class="modal-body">
                <div class="modal-invoice" id="modalInvoice">
                    <div class="modal-invoice-row">
                        <span>Resep</span><span>RSP-2026-0051</span>
                    </div>
                    <div class="modal-invoice-row">
                        <span>Dokter</span><span>Dr. Budi Santoso</span>
                    </div>
                    <div class="modal-invoice-row">
                        <span>Subtotal Obat</span><span>Rp 75.000</span>
                    </div>
                    <div class="modal-invoice-row">
                        <span>Biaya Layanan</span><span>Rp 12.500</span>
                    </div>
                    <div class="modal-invoice-total">
                        <span class="lbl">Total Bayar</span>
                        <span class="val">Rp 87.500</span>
                    </div>
                </div>

                <div class="panel-bpjs" id="panelBpjs">
                    <div class="bpjs-number-wrap">
                        <div class="bpjs-label">📋 Nomor BPJS Kesehatan</div>
                        <div class="bpjs-number" id="bpjsNumber">0001 2345 6789 01</div>
                        <div class="bpjs-name" id="bpjsName">Nama Peserta Aktif</div>
                        <div class="bpjs-status">✅ Peserta Aktif</div>
                    </div>
                    <div class="bpjs-info">
                        ℹ️ Tunjukkan nomor BPJS ini kepada petugas apotek. Biaya ditanggung sesuai ketentuan BPJS Kesehatan.
                    </div>
                </div>

                <div class="panel-mandiri" id="panelMandiri">
                    <div class="barcode-dashed">
                        <div class="barcode-lbl">Barcode Pembayaran Mandiri</div>
                        <div class="barcode-img-wrap">
                            <img id="barcodeImg" src="" alt="Barcode" style="display:none;">
                            <div class="barcode-placeholder" id="barcodePlaceholder">
                                🖼️<br>Tambahkan gambar barcode<br>di sini
                            </div>
                        </div>
                        <div class="barcode-ref" id="barcodeRef">MDR-00000000-000000</div>
                        <div class="barcode-hint">Scan barcode untuk transfer via Bank Mandiri</div>
                    </div>
                </div>

                <div class="modal-processing" id="modalProcessing">
                    <div class="modal-spinner"></div>
                    <div style="font-weight:700;margin-bottom:4px;">Memproses Pembayaran…</div>
                    <div style="font-size:.8rem;color:var(--ss-muted);">Mohon tunggu sebentar</div>
                </div>

                <div class="modal-success" id="modalSuccess">
                    <div class="icon">✅</div>
                    <div class="title">Pembayaran Dikonfirmasi!</div>
                    <div class="sub">Invoice Anda telah berhasil diproses</div>
                    <div style="font-size:1.2rem;font-weight:800;color:var(--ss-primary);margin-top:12px;">Rp 87.500</div>
                </div>

                <button class="btn-konfirmasi" id="btnKonfirmasi">Konfirmasi Bayar</button>
            </div>
        </div>
    </div>

</div>

{{-- CSRF untuk AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('scripts')
<script src="{{ asset('js/pembayaran.js') }}"></script>
@endpush
