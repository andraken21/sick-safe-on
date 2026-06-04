@extends('layouts.app')

@section('title', 'Pembayaran — Sick Safe ON')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.bayar-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 32px 16px 48px;
}

/* ── HEADER ── */
.bayar-header {
    text-align: center;
    margin-bottom: 28px;
}
.bayar-header-icon {
    width: 40px; height: 40px;
    background: #14b8a6;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem; font-weight: 800;
    margin: 0 auto 10px;
}
.bayar-header h1 { font-size: 1.4rem; font-weight: 800; color: #1e293b; margin: 0 0 4px; }
.bayar-header p  { font-size: .78rem; color: #64748b; margin: 0; }

/* ── CARD ── */
.bayar-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 40px rgba(0,0,0,.1);
    padding: 26px;
    width: 100%;
    max-width: 420px;
    margin-bottom: 24px;
}

/* Invoice header */
.inv-head {
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 16px;
    margin-bottom: 16px;
}
.inv-head-top {
    display: flex; justify-content: space-between;
    align-items: flex-start; margin-bottom: 12px;
}
.inv-no-lbl { font-size: .7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
.inv-no-val { font-size: 1.1rem; font-weight: 700; color: #0d9488; }
.inv-status {
    padding: 6px 12px;
    background: #fef3c7; color: #92400e;
    font-size: .72rem; font-weight: 700;
    border-radius: 6px;
}
.inv-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 12px; font-size: .8rem; margin-bottom: 10px;
}
.inv-grid-item .lbl { font-size: .7rem; color: #64748b; margin-bottom: 3px; }
.inv-grid-item .val { font-weight: 700; color: #1e293b; }
.inv-dokter .lbl { font-size: .7rem; color: #64748b; margin-bottom: 3px; }
.inv-dokter .val { font-size: .83rem; font-weight: 700; color: #1e293b; }

/* Price breakdown */
.price-list { margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0; }
.price-row { display: flex; justify-content: space-between; font-size: .82rem; margin-bottom: 10px; }
.price-row span:first-child { color: #64748b; }
.price-row span:last-child  { font-weight: 600; color: #1e293b; }

/* Total */
.total-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 22px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;
}
.total-row .lbl { font-size: 1rem; font-weight: 800; color: #1e293b; }
.total-row .val { font-size: 1.65rem; font-weight: 800; color: #0d9488; }

/* ── PANEL BPJS ── */
.panel-bpjs { display: none; margin-bottom: 22px; }
.panel-bpjs.show { display: block; }
.bpjs-box {
    background: linear-gradient(135deg, #e6f9f4, #d0f5ea);
    border: 2px solid #a7f3d0;
    border-radius: 12px; padding: 22px; text-align: center;
}
.bpjs-box .lbl {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .8px;
    color: #065f46; margin-bottom: 10px;
}
.bpjs-number {
    font-family: 'Courier New', monospace;
    font-size: 1.6rem; font-weight: 800; letter-spacing: .15em; color: #1a202c;
}
.bpjs-name { font-size: .8rem; color: #64748b; margin-top: 6px; }
.bpjs-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: #dcfce7; color: #15803d;
    font-size: .72rem; font-weight: 700;
    padding: 4px 14px; border-radius: 999px; margin-top: 10px;
}
.bpjs-note {
    background: #fffbeb; border: 1px solid #fcd34d;
    border-radius: 10px; padding: 12px 14px;
    font-size: .78rem; color: #92400e; line-height: 1.55;
    margin-top: 14px;
}

/* ── PANEL BARCODE MANDIRI ── */
.panel-mandiri { display: none; margin-bottom: 22px; }
.panel-mandiri.show { display: block; }
.barcode-box {
    background: linear-gradient(to bottom, #f8fafc, #fff);
    border: 2px dashed #cbd5e1;
    border-radius: 12px; padding: 18px; text-align: center;
}
.barcode-box .lbl {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .8px;
    color: #64748b; margin-bottom: 14px;
}
.barcode-img-wrap {
    width: 200px; height: 200px; margin: 0 auto 14px;
    border-radius: 8px; overflow: hidden;
    border: 1px solid #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    background: #f0f9ff;
}
.barcode-img-wrap img { width: 100%; height: 100%; object-fit: contain; }
.barcode-placeholder {
    color: #94a3b8; font-size: .75rem; text-align: center; padding: 12px; line-height: 1.6;
}
.barcode-ref {
    font-family: 'Courier New', monospace;
    font-size: .82rem; font-weight: 700; letter-spacing: .12em; color: #0f172a; margin-bottom: 5px;
}
.barcode-hint { font-size: .72rem; color: #64748b; }

/* ── METODE SELECTOR ── */
.metode-selector { margin-bottom: 22px; }
.metode-selector .ttl { font-size: .82rem; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
.metode-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.metode-btn {
    padding: 13px 10px;
    border: 2px solid #e2e8f0;
    background: #fff; border-radius: 10px;
    cursor: pointer; text-align: center;
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
}
.metode-btn:hover { border-color: #a5f3e0; }
.metode-btn.active { border-color: #14b8a6; background: #f0fdfa; }
.metode-btn .icon  { font-size: 1.4rem; margin-bottom: 4px; }
.metode-btn .name  { font-size: .75rem; font-weight: 700; color: #1e293b; }

/* ── PROCESSING / SUCCESS STATE ── */
.state-processing, .state-success {
    display: none; text-align: center; padding: 28px 0;
}
.state-processing.show, .state-success.show { display: block; }
.spinner {
    width: 46px; height: 46px;
    border: 4px solid #e2e8f0; border-top-color: #14b8a6;
    border-radius: 50%; animation: spin 1s linear infinite;
    margin: 0 auto 14px;
}
@keyframes spin { to { transform: rotate(360deg); } }
.state-title { font-size: .95rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.state-sub   { font-size: .8rem; color: #64748b; }
.success-icon { font-size: 3rem; margin-bottom: 10px; }
.success-total { font-size: 1.4rem; font-weight: 800; color: #0d9488; margin-top: 12px; }

/* ── TOMBOL BAYAR ── */
.btn-bayar-now {
    display: block; width: 100%; padding: 15px;
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    color: #fff; border: none; border-radius: 10px;
    font-size: 1rem; font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; text-align: center;
    box-shadow: 0 4px 14px rgba(20,184,166,.35);
    transition: all .2s;
}
.btn-bayar-now:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(20,184,166,.4); }
.btn-bayar-now:active { transform: scale(.97); }

/* ── BACK LINK ── */
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .8rem; color: #64748b; text-decoration: none;
    margin-bottom: 18px; transition: color .2s;
}
.back-link:hover { color: #0d9488; }

/* ── FOOTER ── */
.bayar-footer { text-align: center; font-size: .75rem; color: #64748b; }
.bayar-footer .contact { font-weight: 700; color: #1e293b; margin-top: 4px; }
</style>

<div class="bayar-wrap">

    {{-- Header --}}
    <div class="bayar-header">
        <div class="bayar-header-icon">✓</div>
        <h1>Sick Safe ON</h1>
        <p>Aplikasi Kesehatan Digital</p>
    </div>

    {{-- Tombol kembali --}}
    <a href="{{ route('pasien.pembayaran.index') }}" class="back-link">
        ← Kembali ke Pembayaran
    </a>

    {{-- Card utama --}}
    <div class="bayar-card">

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
                <span>Rp {{ number_format($detail['subtotal_obat'], 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span>Biaya layanan</span>
                <span>Rp {{ number_format($detail['biaya_layanan'], 0, ',', '.') }}</span>
            </div>
            @if($detail['metode'] === 'BPJS')
            <div class="price-row" style="color:#15803d;">
                <span>Diskon BPJS</span>
                <span>- Rp {{ number_format($detail['diskon'], 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        {{-- Total --}}
        <div class="total-row">
            <span class="lbl">Total Bayar</span>
            <span class="val" @if($detail['metode']==='BPJS') style="color:#1fa85c;" @endif>
                Rp {{ number_format($detail['total_bayar'], 0, ',', '.') }}
            </span>
        </div>

        {{-- Panel BPJS (muncul kalau metode BPJS dipilih) --}}
        <div class="panel-bpjs" id="panelBpjs">
            <div class="bpjs-box">
                <div class="lbl">📋 Nomor BPJS Kesehatan</div>
                <div class="bpjs-number">0001 2345 6789 01</div>
                <div class="bpjs-name">{{ $pasien->name ?? 'Andra Kenzie' }}</div>
                <div class="bpjs-badge">✅ Peserta Aktif</div>
            </div>
            
            
        </div>

        {{-- Panel Barcode Mandiri (muncul kalau Mandiri dipilih) --}}
        <div class="panel-mandiri" id="panelMandiri">
            <div class="barcode-box">
                <div class="lbl">Barcode Pembayaran Mandiri</div>
                <div class="barcode-img-wrap">
                    {{-- Ganti src dengan path gambar barcode kamu, lalu hapus style="display:none" dan div placeholder --}}
                    <img id="barcodeImg" src="{{ asset('image/barcode.png') }}" alt="Barcode Mandiri" style="width:100%; height:100%; object-fit:contain;"
                        
                    </div>
                </div>
                <div class="barcode-ref" id="barcodeRef"></div>
                <div class="barcode-hint">Scan barcode ini</div>
            </div>
        </div>

        {{-- Pilih metode --}}
        <div class="metode-selector" id="metodeSelector">
            <div class="ttl">Pilih Metode Pembayaran</div>
            <div class="metode-grid">
                <button class="metode-btn" data-metode="BPJS">
                    <div class="icon">🏥</div>
                    <div class="name">BPJS Kesehatan</div>
                </button>
                <button class="metode-btn active" data-metode="Mandiri">
                    <div class="icon">🏦</div>
                    <div class="name">Mandiri</div>
                </button>
            </div>
        </div>

        {{-- Processing state --}}
        <div class="state-processing" id="stateProcessing">
            <div class="spinner"></div>
            <div class="state-title">Memproses Pembayaran…</div>
            <div class="state-sub">Mohon tunggu sebentar</div>
        </div>

        {{-- State: menunggu konfirmasi apoteker --}}
        <div class="state-success" id="stateSuccess">
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

    </div>

    {{-- Footer --}}
    <div class="bayar-footer">
        <p>Butuh bantuan? Hubungi customer service kami</p>
        <p class="contact">📞 1500-123 | 📧 support@sicksafeon.com</p>
    </div>

</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
(function () {
    // ── Baca metode & total dari query string URL ──
    const urlParams      = new URLSearchParams(window.location.search);
    const metodeFromUrl  = urlParams.get('metode');   // 'BPJS' atau 'Mandiri'
    const totalFromUrl   = parseInt(urlParams.get('total') || '0');
    let selectedMetode   = metodeFromUrl || 'Mandiri';

    const panelBpjs      = document.getElementById('panelBpjs');
    const panelMandiri   = document.getElementById('panelMandiri');
    const metodeSelector = document.getElementById('metodeSelector');
    const stateProcessing= document.getElementById('stateProcessing');
    const stateSuccess   = document.getElementById('stateSuccess');
    const btnBayarNow    = document.getElementById('btnBayarNow');
    const barcodeRef     = document.getElementById('barcodeRef');
    const successSub     = document.getElementById('successSub');

    // ── Update total bayar sesuai metode ──
    function updateTotalDisplay(metode) {
        const elTotal = document.querySelector('.total-row .val');
        const elSuccess = document.querySelector('.success-total');
        if (metode === 'BPJS') {
            if (elTotal)   elTotal.textContent   = 'Rp 0';
            if (elTotal)   elTotal.style.color   = '#1fa85c';
            if (elSuccess) elSuccess.textContent = 'Rp 0';
            // Tandai tombol bayar
            if (btnBayarNow) btnBayarNow.textContent = 'Konfirmasi BPJS';
        } else {
            const totalNormal = totalFromUrl || {{ $detail['total_bayar'] }};
            const fmt = 'Rp ' + totalNormal.toLocaleString('id-ID');
            if (elTotal)   elTotal.textContent   = fmt;
            if (elTotal)   elTotal.style.color   = '';
            if (elSuccess) elSuccess.textContent = fmt;
            if (btnBayarNow) btnBayarNow.textContent = 'Bayar Sekarang';
        }
    }

    // Generate referensi unik Mandiri
    function genRef() {
        const ts   = Date.now().toString().slice(-8);
        const rand = Math.random().toString(36).substring(2, 8).toUpperCase();
        return `MDR-${ts}-${rand}`;
    }

    // Tampilkan panel sesuai metode + set active button
    function tampilkanPanel(metode) {
        // Update tombol metode agar sesuai
        document.querySelectorAll('.metode-btn').forEach(b => {
            b.classList.toggle('active', b.dataset.metode === metode);
        });
        if (metode === 'BPJS') {
            panelBpjs.classList.add('show');
            panelMandiri.classList.remove('show');
        } else {
            panelMandiri.classList.add('show');
            panelBpjs.classList.remove('show');
            barcodeRef.textContent = genRef();
        }
        updateTotalDisplay(metode);
    }

    // Init: tampilkan sesuai metode dari URL
    tampilkanPanel(selectedMetode);

    // ── Kalau metode sudah dipilih dari halaman sebelumnya, sembunyikan selector ──
    if (metodeFromUrl) {
        metodeSelector.style.display = 'none';
    }

    // Pilih metode
    document.querySelectorAll('.metode-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.metode-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedMetode = this.dataset.metode;
            tampilkanPanel(selectedMetode);
        });
    });

    // Tombol Bayar Sekarang → POST ke route prosesBayar
    btnBayarNow.addEventListener('click', async function () {
        // Sembunyikan panel & tombol
        panelBpjs.classList.remove('show');
        panelMandiri.classList.remove('show');
        metodeSelector.style.display = 'none';
        btnBayarNow.style.display    = 'none';
        stateProcessing.classList.add('show');

        try {
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const res  = await fetch('{{ route("pasien.pembayaran.proses") }}', {
                method : 'POST',
                headers: {
                    'Content-Type'    : 'application/json',
                    'Accept'          : 'application/json',
                    'X-CSRF-TOKEN'    : csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    invoice_id : '{{ $detail["nomor_invoice"] }}',
                    metode     : selectedMetode,
                    total_bayar: {{ $detail['total_bayar'] }},
                }),
            });

            const data = await res.json();
            stateProcessing.classList.remove('show');

            if (data.success) {
                // Tampilkan state "menunggu konfirmasi apoteker" — BUKAN langsung sukses
                successSub.textContent = `Kode Ref: ${data.kode_ref} • ${data.waktu}`;
                stateSuccess.classList.add('show');
                // Tombol kembali ke riwayat muncul setelah 2 detik
                setTimeout(() => {
                    const backBtn = document.createElement('a');
                    backBtn.href = '{{ route("pasien.pembayaran.index") }}';
                    backBtn.textContent = '← Kembali ke Riwayat Pembayaran';
                    backBtn.style.cssText = 'display:block;margin-top:16px;font-size:.82rem;font-weight:700;color:#0d9488;text-decoration:none;text-align:center;';
                    stateSuccess.appendChild(backBtn);
                }, 1500);
            } else {
                alert('Pembayaran gagal. Silakan coba lagi.');
                reset();
            }

        } catch (err) {
            console.error(err);
            stateProcessing.classList.remove('show');
            alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
            reset();
        }
    });

    function reset() {
        metodeSelector.style.display = '';
        btnBayarNow.style.display    = '';
        tampilkanPanel(selectedMetode);
    }
})();
</script>
@endsection