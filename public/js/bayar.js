/**
 * bayar.js
 * PENTING: File ini adalah JS murni — TIDAK ada Blade/PHP syntax di sini.
 * Semua nilai dari server dibaca dari atribut data-* pada #bayarApp.
 */
(function () {
    'use strict';

    // ── Baca semua nilai PHP dari data-* pada #bayarApp ──────────────────────
    const app = document.getElementById('bayarApp');
    if (!app) return; // halaman bukan bayar.blade.php

    const invoiceId   = app.dataset.invoice    || '';
    const metodeAwal  = app.dataset.metode     || 'Mandiri';
    const subtotal    = parseInt(app.dataset.subtotal   || 0, 10);
    const layanan     = parseInt(app.dataset.layanan    || 0, 10);
    const totalNormal = subtotal + layanan;
    const prosesUrl   = app.dataset.prosesUrl  || '/pasien/pembayaran/proses';
    const kembaliUrl  = app.dataset.kembaliUrl || '/pasien/pembayaran';

    // ── Baca metode dari query string URL jika ada ────────────────────────────
    // (dikirim oleh halaman pembayaran.blade.php lewat ?metode=...)
    const urlParams  = new URLSearchParams(window.location.search);
    let selectedMetode = urlParams.get('metode') || metodeAwal;
    // Validasi — hanya boleh BPJS atau Mandiri
    if (!['BPJS', 'Mandiri'].includes(selectedMetode)) selectedMetode = 'Mandiri';

    // ── Elemen UI ────────────────────────────────────────────────────────────
    const panelBpjs      = document.getElementById('panelBpjs');
    const panelMandiri   = document.getElementById('panelMandiri');
    const metodeSelector = document.getElementById('metodeSelector');
    const stateProcessing= document.getElementById('stateProcessing');
    const stateSuccess   = document.getElementById('stateSuccess');
    const btnBayarNow    = document.getElementById('btnBayarNow');
    const barcodeRef     = document.getElementById('barcodeRef');
    const successSub     = document.getElementById('successSub');
    const priceTotal     = document.getElementById('priceTotal');
    const priceDiskonRow = document.getElementById('priceDiskonRow');
    const priceDiskon    = document.getElementById('priceDiskon');

    // ── Helpers ───────────────────────────────────────────────────────────────
    const fmt = (n) => 'Rp ' + n.toLocaleString('id-ID');

    function genRef() {
        return 'MDR-' + Date.now().toString().slice(-8) + '-' +
               Math.random().toString(36).substring(2, 8).toUpperCase();
    }

    // ── Tampilkan panel & update harga sesuai metode ──────────────────────────
    function applyMetode(metode) {
        const isBpjs   = metode === 'BPJS';
        const diskon   = isBpjs ? totalNormal : 0;
        const total    = totalNormal - diskon;

        // Tombol aktif
        document.querySelectorAll('.metode-btn').forEach(b => {
            b.classList.toggle('active', b.dataset.metode === metode);
        });

        // Panel instruksi
         if (panelBpjs)    panelBpjs.style.display    = isBpjs  ? '' : 'none';
         if (panelMandiri) panelMandiri.style.display = !isBpjs ? '' : 'none';
         const panelQr = document.getElementById('panelQr');
         if (panelQr)      panelQr.style.display      = !isBpjs ? '' : 'none';

        // Barcode Mandiri: generate ref baru tiap kali panel ditampilkan
        if (!isBpjs && barcodeRef) barcodeRef.textContent = genRef();

        // Harga
        if (priceDiskonRow) {
            if (isBpjs) {
                priceDiskonRow.style.display = '';
                priceDiskonRow.style.color   = '#15803d';
                if (priceDiskon) priceDiskon.textContent = '- ' + fmt(diskon);
            } else {
                priceDiskonRow.style.display = 'none';
            }
        }

        if (priceTotal) {
            priceTotal.textContent = fmt(total);
            priceTotal.style.color = isBpjs ? '#1fa85c' : '';
        }

        // Teks tombol bayar
        if (btnBayarNow) {
            btnBayarNow.textContent = isBpjs ? 'Konfirmasi BPJS' : 'Bayar Sekarang';
        }
    }

    // ── Pilih metode ──────────────────────────────────────────────────────────
    document.querySelectorAll('.metode-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            selectedMetode = this.dataset.metode || 'Mandiri';
            applyMetode(selectedMetode);
        });
    });

    // Jika metode datang dari query string, sembunyikan selector
    // (user sudah memilih di halaman pembayaran.blade.php)
    if (urlParams.get('metode') && metodeSelector) {
        metodeSelector.style.display = 'none';
    }

    // Init
    applyMetode(selectedMetode);

    // ── Reset ke state awal ───────────────────────────────────────────────────
    function resetUI() {
        if (metodeSelector) metodeSelector.style.display = '';
        if (btnBayarNow)    btnBayarNow.style.display    = '';
        applyMetode(selectedMetode);
    }

    // ── Tombol Bayar / Konfirmasi ─────────────────────────────────────────────
    if (btnBayarNow) {
        btnBayarNow.addEventListener('click', async function () {
            // Sembunyikan panel & selector
            if (panelBpjs)      panelBpjs.style.display    = 'none';
            if (panelMandiri)   panelMandiri.style.display = 'none';
            if (metodeSelector) metodeSelector.style.display = 'none';
            btnBayarNow.style.display = 'none';
            if (stateProcessing) stateProcessing.style.display = '';

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const totalBayar = selectedMetode === 'BPJS' ? 0 : totalNormal;

                const res = await fetch(prosesUrl, {
                    method : 'POST',
                    headers: {
                        'Content-Type'    : 'application/json',
                        'Accept'          : 'application/json',
                        'X-CSRF-TOKEN'    : csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        invoice_id : invoiceId,
                        metode     : selectedMetode,
                        total_bayar: totalBayar,
                    }),
                });

                const data = await res.json();
                if (stateProcessing) stateProcessing.style.display = 'none';

                if (data.success) {
                    if (successSub) {
                        successSub.textContent = data.kode_ref
                            ? `Kode Ref: ${data.kode_ref} • ${data.waktu || ''}`
                            : '';
                    }
                    if (stateSuccess) 
                    setTimeout(() => {
                    const modalUlasan = document.getElementById('modalUlasan');
                    if (modalUlasan) modalUlasan.style.display = 'flex';}                    , 1500);stateSuccess.style.display = '';

                    const btnSkipUlasan = document.getElementById('btnSkipUlasan');
                    if (btnSkipUlasan) {
                    btnSkipUlasan.addEventListener('click', () => {
                    document.getElementById('modalUlasan').style.display = 'none';
                     window.location.href = kembaliUrl;
    });
}

                    // Tampilkan tombol kembali setelah 1.5 detik
                    setTimeout(() => {
                        if (!stateSuccess) return;
                        const backBtn = document.createElement('a');
                        backBtn.href      = kembaliUrl;
                        backBtn.textContent = '← Kembali ke Riwayat Pembayaran';
                        backBtn.style.cssText = [
                            'display:block', 'margin-top:16px', 'font-size:.82rem',
                            'font-weight:700', 'color:#0d9488', 'text-decoration:none',
                            'text-align:center'
                        ].join(';');
                        // Hindari duplikat tombol
                        if (!stateSuccess.querySelector('a')) {
                            stateSuccess.appendChild(backBtn);
                        }
                    }, 1500);

                } else {
                    alert(data.message || 'Pembayaran gagal. Silakan coba lagi.');
                    resetUI();
                }

            } catch (err) {
                console.error('Bayar error:', err);
                if (stateProcessing) stateProcessing.style.display = 'none';
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
                resetUI();
            }
        });
    }

})();