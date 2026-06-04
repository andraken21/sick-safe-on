const tbody     = document.getElementById('obatTableBody');
const btnAdd    = document.getElementById('btnAddObat');
const countDisp = document.getElementById('obatCountDisplay');
const rkCount   = document.getElementById('rkObatCount');
const rkDiag    = document.getElementById('rkDiagnosa');

const satuanList = ['Tablet','Kapsul','Sirup (ml)','Injeksi (ml)','Tetes','Salep (gr)','Sachet'];
const aturanList = ['1x1','2x1','3x1','4x1','Tiap 6 jam','Tiap 8 jam','Tiap 12 jam','1x sehari','Sesuai kebutuhan'];
let rowCount = 0;

function updateCount() {
    const n = tbody.querySelectorAll('tr').length;
    countDisp.textContent = n;
    rkCount.textContent   = n;
}

function addRow(data = {}) {
    rowCount++;
    const idx = rowCount;
    const tr  = document.createElement('tr');
    tr.innerHTML = `
        <td class="col-no">${tbody.querySelectorAll('tr').length + 1}</td>
        <td class="col-nama">
            <input type="text" name="obat[${idx}][nama_obat]" placeholder="Nama obat..." required value="${data.nama_obat ?? ''}">
        </td>
        <td class="col-dosis">
            <input type="text" name="obat[${idx}][dosis]" placeholder="500 mg" value="${data.dosis ?? ''}">
        </td>
        <td class="col-jml">
            <input type="number" name="obat[${idx}][jumlah]" placeholder="0" min="1" value="${data.jumlah ?? ''}">
        </td>
        <td class="col-sat">
            <select name="obat[${idx}][satuan]">
                ${satuanList.map(s => `<option ${data.satuan===s?'selected':''}>${s}</option>`).join('')}
            </select>
        </td>
        <td class="col-aturan">
            <select name="obat[${idx}][aturan_pakai]">
                ${aturanList.map(a => `<option ${data.aturan_pakai===a?'selected':''}>${a}</option>`).join('')}
            </select>
        </td>
        <td class="col-ket">
            <input type="text" name="obat[${idx}][keterangan]" placeholder="Ket. tambahan..." value="${data.keterangan ?? ''}">
        </td>
        <td class="col-del">
            <button type="button" class="btn-del-row" title="Hapus"><i class="bi bi-trash3"></i></button>
        </td>
    `;
    tr.querySelector('.btn-del-row').addEventListener('click', () => {
        tr.remove(); renumberRows(); updateCount();
    });
    tbody.appendChild(tr);
    updateCount();
}

function renumberRows() {
    tbody.querySelectorAll('tr').forEach((tr, i) => {
        tr.querySelector('.col-no').textContent = i + 1;
    });
}

// Mulai dengan 1 baris
addRow();
btnAdd.addEventListener('click', () => addRow());

// Live diagnosa
document.getElementById('inputDiagnosa')?.addEventListener('input', function () {
    if (this.value.trim()) {
        rkDiag.textContent = this.value.trim();
        rkDiag.style.cssText = 'font-weight:600;color:#004369;font-style:normal';
    } else {
        rkDiag.textContent = 'Belum diisi';
        rkDiag.style.cssText = 'color:#6a8fa5;font-weight:400;font-style:italic';
    }
});

// Draft
document.getElementById('btnDraft')?.addEventListener('click', () => {
    document.getElementById('inputStatus').value = 'draft';
    showToast('Menyimpan sebagai draft...');
    setTimeout(() => document.getElementById('formResep').submit(), 600);
});

// Validasi
document.getElementById('formResep')?.addEventListener('submit', function(e) {
    const rows = tbody.querySelectorAll('tr');
    if (rows.length === 0) {
        e.preventDefault(); showToast('Tambahkan minimal 1 obat!', true); return;
    }
    let valid = true;
    rows.forEach(tr => {
        const inp = tr.querySelector('input[type="text"]');
        if (inp && !inp.value.trim()) valid = false;
    });
    if (!valid) { e.preventDefault(); showToast('Nama obat tidak boleh kosong!', true); }
});

function showToast(msg, isError = false) {
    const toast = document.getElementById('toast');
    const icon  = toast.querySelector('i');
    document.getElementById('toastMsg').textContent = msg;
    icon.className   = isError ? 'bi bi-exclamation-circle-fill' : 'bi bi-check-circle-fill';
    icon.style.color = isError ? '#FF6B6B' : '#3DD5C8';
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}
