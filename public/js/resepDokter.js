/**
 * resepDokter.js
 * Mengelola tabel obat dinamis di form buat resep.
 *
 * Kolom tabel:
 *  # | Nama Obat | Dosis | Jumlah | Aturan Pakai | (hapus)
 *
 * Data dikirim ke controller sebagai:
 *  obat[i][id_obat], obat[i][dosis], obat[i][jumlah], obat[i][aturan_pakai], obat[i][satuan]
 */

(function () {
    'use strict';

    /* ── Data obat dari Blade (window.obatOptions) ── */
    const obatOptions = window.obatOptions || [];

    /* ── Referensi elemen DOM ── */
    const tbody           = document.getElementById('obatTableBody');
    const btnAdd          = document.getElementById('btnAddObat');
    const countDisplay    = document.getElementById('obatCountDisplay');
    const rkObatCount     = document.getElementById('rkObatCount');
    const rkDiagnosa      = document.getElementById('rkDiagnosa');
    const inputDiagnosa   = document.getElementById('inputDiagnosa');

    let rowIndex = 0;

    /* ── Build <option> list untuk select obat ── */
    function buildSelectOptions(selectedId = '') {
        return obatOptions.map(o => {
            const sel = o.id == selectedId ? ' selected' : '';
            return `<option value="${o.id}" data-stok="${o.stok}" data-harga="${o.harga}"${sel}>${o.nama} (stok: ${o.stok})</option>`;
        }).join('');
    }

    /* ── Buat satu baris obat baru ── */
    function addRow() {
        const i   = rowIndex++;
        const tr  = document.createElement('tr');
        tr.dataset.row = i;

        tr.innerHTML = `
            <td class="col-no">${tbody.children.length + 1}</td>

            <td class="col-nama">
                <select name="obat[${i}][id_obat]" class="sel-obat" required>
                    <option value="">— Pilih Obat —</option>
                    ${buildSelectOptions()}
                </select>
                <input type="hidden" name="obat[${i}][satuan]" class="inp-satuan" value="tablet">
            </td>

            <td class="col-dosis">
                <input type="text"
                       name="obat[${i}][dosis]"
                       class="inp-dosis"
                       placeholder="Cth: 500 mg"
                       required>
            </td>

            <td class="col-jml">
                <input type="number"
                       name="obat[${i}][jumlah]"
                       class="inp-jumlah"
                       min="1"
                       value="1"
                       required
                       style="width:90px;font-size:1rem;font-weight:700;text-align:center;padding:8px 6px;">
            </td>

            <td class="col-aturan">
                <input type="text"
                       name="obat[${i}][aturan_pakai]"
                       class="inp-aturan"
                       placeholder="Cth: 3x1 sesudah makan"
                       required>
            </td>

            <td class="col-del">
                <button type="button" class="btn-del-row" title="Hapus baris">
                    <i class="bi bi-trash3"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        updateCount();
        attachRowEvents(tr);
    }

    /* ── Pasang event listener ke baris ── */
    function attachRowEvents(tr) {
        /* Hapus baris */
        tr.querySelector('.btn-del-row').addEventListener('click', () => {
            tr.remove();
            reindexRows();
            updateCount();
        });

        /* Validasi jumlah tidak melebihi stok saat pilih obat */
        const selObat  = tr.querySelector('.sel-obat');
        const inpJml   = tr.querySelector('.inp-jumlah');

        selObat.addEventListener('change', () => {
            const opt  = selObat.options[selObat.selectedIndex];
            const stok = parseInt(opt?.dataset.stok ?? 999);
            inpJml.max = stok;
            if (parseInt(inpJml.value) > stok) inpJml.value = stok;
        });
    }

    /* ── Reindex nomor baris dan name attribute ── */
    function reindexRows() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach((tr, idx) => {
            /* Update nomor tampilan */
            tr.querySelector('.col-no').textContent = idx + 1;

            /* Update name attribute agar array PHP tetap rapi */
            const fields = ['id_obat', 'satuan', 'dosis', 'jumlah', 'aturan_pakai'];
            fields.forEach(field => {
                const el = tr.querySelector(`[name*="[${field}]"]`);
                if (el) el.name = `obat[${idx}][${field}]`;
            });
        });
    }

    /* ── Update counter tampilan ── */
    function updateCount() {
        const count = tbody.children.length;
        if (countDisplay)  countDisplay.textContent  = count;
        if (rkObatCount)   rkObatCount.textContent   = count;
    }

    /* ── Sinkronisasi ringkasan diagnosa ── */
    if (inputDiagnosa && rkDiagnosa) {
        inputDiagnosa.addEventListener('input', () => {
            rkDiagnosa.textContent     = inputDiagnosa.value.trim() || 'Belum diisi';
            rkDiagnosa.style.fontStyle = inputDiagnosa.value.trim() ? 'normal' : 'italic';
            rkDiagnosa.style.color     = inputDiagnosa.value.trim() ? 'inherit' : '#6a8fa5';
        });
    }

    /* ── Tombol Tambah Obat ── */
    if (btnAdd) {
        btnAdd.addEventListener('click', addRow);
    }

    /* ── Validasi sebelum submit: minimal 1 obat ── */
    const form = document.getElementById('formResep');
    if (form) {
        form.addEventListener('submit', e => {
            if (tbody.children.length === 0) {
                e.preventDefault();
                showToast('Tambahkan minimal satu obat sebelum mengirim resep.');
            }
        });
    }

    /* ── Toast helper ── */
    function showToast(msg) {
        const toast    = document.getElementById('toast');
        const toastMsg = document.getElementById('toastMsg');
        if (!toast) return;
        toastMsg.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    /* ── Mulai dengan satu baris kosong ── */
    addRow();

})();