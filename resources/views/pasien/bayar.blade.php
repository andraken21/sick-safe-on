@extends('layouts.app')

@section('title', 'Pembayaran — Sick Safe ON')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bayar.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
<div class="bayar-wrap">

    {{-- Header --}}
    <div class="bayar-header">
        <div class="bayar-header-icon">✓</div>
        <h1>Sick Safe ON</h1>
        <p>Aplikasi Kesehatan Digital</p>
    </div>

    {{-- Tombol kembali --}}
    <a href="{{ route('pasien.pembayaran') }}" class="back-link">
        ← Kembali ke Pembayaran
    </a>

    {{-- Card utama --}}
    {{--
        Semua nilai PHP disimpan di data-* pada elemen #bayarApp
        agar bayar.js (file .js murni) bisa membacanya tanpa Blade syntax.
    --}}
    <div class="bayar-card"
         id="bayarApp"
         data-invoice="{{ $detail['nomor_invoice'] }}"
         data-metode="{{ $detail['metode'] }}"
         data-subtotal="{{ $detail['subtotal_obat'] }}"
         data-layanan="{{ $detail['biaya_layanan'] }}"
         data-total-bayar="{{ $detail['total_bayar'] }}"
         data-proses-url="{{ route('pasien.pembayaran.proses') }}"
         data-kembali-url="{{ route('pasien.pembayaran') }}">

        {{-- Invoice detail --}}
        <div class="inv-head">
            <div class="inv-head-top">
                <div>
                    <div class="inv-no-lbl">No. Invoice</div>
                    <div class="inv-no-val">{{ $detail['nomor_invoice'] }}</div>
                </div>
                <span class="inv-status">{{ $detail['status'] }}</span>
            </div>
            <div class="inv-grid">
                <div class="inv-grid-item">
                    <div class="lbl">Resep</div>
                    <div class="val">{{ $detail['resep_id'] }}</div>
                </div>
                <div class="inv-grid-item">
                    <div class="lbl">Tanggal</div>
                    <div class="val">{{ $detail['tanggal'] }}</div>
                </div>
            </div>
            <div class="inv-dokter">
                <div class="lbl">Dokter &amp; Obat</div>
                <div class="val">{{ $detail['dokter'] }} • {{ $detail['jumlah_obat'] }} Obat</div>
            </div>
        </div>

        {{-- Rincian harga --}}
        <div class="price-list">
            <div class="price-row">
                <span>Subtotal obat</span>
                <span id="priceSubtotal">Rp {{ number_format($detail['subtotal_obat'], 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span>Biaya layanan</span>
                <span id="priceLayanan">Rp {{ number_format($detail['biaya_layanan'], 0, ',', '.') }}</span>
            </div>
            <div class="price-row" id="priceDiskonRow" style="{{ $detail['metode'] === 'BPJS' ? 'color:#15803d;' : 'display:none;' }}">
                <span id="priceDiskonLbl">Diskon {{ $detail['metode'] }}</span>
                <span id="priceDiskon">- Rp {{ number_format($detail['diskon'], 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Total --}}
        <div class="total-row">
            <span class="lbl">Total Bayar</span>
            <span class="val" id="priceTotal" style="{{ $detail['metode'] === 'BPJS' ? 'color:#1fa85c;' : '' }}">
                Rp {{ number_format($detail['total_bayar'], 0, ',', '.') }}
            </span>
        </div>

        {{-- Panel BPJS --}}
        <div class="panel-bpjs" id="panelBpjs" style="{{ $detail['metode'] === 'BPJS' ? '' : 'display:none;' }}">
            <div class="bpjs-box">
                <div class="lbl">📋 Nomor BPJS Kesehatan</div>
                <div class="bpjs-number">0001 2345 6789 01</div>
                <div class="bpjs-name">{{ $pasien->name ?? 'Andra Kenzie' }}</div>
                <div class="bpjs-badge">✅ Peserta Aktif</div>
            </div>
        </div>

        {{-- Panel Barcode Mandiri --}}
        <div class="panel-mandiri" id="panelMandiri" style="{{ $detail['metode'] === 'Mandiri' ? '' : 'display:none;' }}">
            <div class="barcode-box">
                <div class="lbl">Barcode Pembayaran Mandiri</div>
                <div class="barcode-img-wrap">
                    {{-- Ganti src dengan path gambar barcode kamu, lalu hapus style="display:none" dan div placeholder --}}
                    <img id="barcodeImg" src="{{ asset('image/barcode.jpg') }}" alt="Barcode Mandiri" style="width:100%; height:100%; object-fit:contain;">
                        
                </div>
                <div class="barcode-ref" id="barcodeRef">MDR-{{ time() }}</div>
                <div class="barcode-hint">Scan barcode ini</div>
            </div>
        </div>

        {{-- Pilih metode --}}
        <div class="metode-selector" id="metodeSelector">
            <div class="ttl">Pilih Metode Pembayaran</div>
            <div class="metode-grid">
                <button class="metode-btn {{ $detail['metode'] === 'BPJS' ? 'active' : '' }}" data-metode="BPJS">
                    <div class="icon">🏥</div>
                    <div class="name">BPJS Kesehatan</div>
                </button>
                <button class="metode-btn {{ $detail['metode'] === 'Mandiri' ? 'active' : '' }}" data-metode="Mandiri">
                    <div class="icon">🏦</div>
                    <div class="name">Mandiri</div>
                </button>
            </div>
        </div>

        {{-- Processing state --}}
        <div class="state-processing" id="stateProcessing" style="display:none;">
            <div class="spinner"></div>
            <div class="state-title">Memproses Pembayaran…</div>
            <div class="state-sub">Mohon tunggu sebentar</div>
        </div>

        {{-- State: sukses / menunggu konfirmasi --}}
        <div class="state-success" id="stateSuccess" style="display:none;">
            <div class="success-icon">⏳</div>
            <div class="state-title">Pembayaran Dikirim!</div>
            <div class="state-sub">Menunggu konfirmasi dari apoteker</div>
            <div id="successSub" style="font-size:.78rem; color:#64748b; margin-top:6px;"></div>
            <div style="margin-top:16px; padding:12px 16px; background:#fffbeb; border:1px solid #fcd34d; border-radius:10px; font-size:.8rem; color:#92400e; line-height:1.55;">
                ℹ️ Apoteker akan memverifikasi pembayaran Anda. Status akan diperbarui setelah dikonfirmasi.
            </div>
        </div>

        {{-- Tombol bayar --}}
        <button class="btn-bayar-now" id="btnBayarNow">Bayar Sekarang</button>

    </div>{{-- /.bayar-card --}}

    {{-- Footer --}}
    <div class="bayar-footer">
        <p>Butuh bantuan? Hubungi customer service kami</p>
        <p class="contact">📞 1500-123 | 📧 support@sicksafeon.com</p>
    </div>

</div>

{{-- CSRF untuk AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('scripts')
<script src="{{ asset('js/bayar.js') }}"></script>
@endpush