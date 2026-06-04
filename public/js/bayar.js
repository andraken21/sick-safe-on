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