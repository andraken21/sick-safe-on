@extends('layouts.app')

@section('title', 'Kelola Data Obat - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kelolaDataObat.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">
    <div class="dash-main">
        <div class="dash-content">

            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;
                            padding:12px 16px;border-radius:10px;margin-bottom:16px;
                            display:flex;align-items:center;gap:10px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;
                            padding:12px 16px;border-radius:10px;margin-bottom:16px;
                            display:flex;align-items:center;gap:10px;">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            {{-- SUMMARY CARDS — dari DB --}}
            @php
                $countTotal   = $obatList->total();
                $countRendah  = \App\Models\Obat::whereBetween('stok', [1, 9])->count();
                $countHabis   = \App\Models\Obat::where('stok', 0)->count();
                $countExpired = \App\Models\Obat::where('status', 'kadaluarsa')->count();
            @endphp
            <div class="med-summary">
                <div class="summary-card">
                    <div class="summary-icon icon-total">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Obat</div>
                        <div class="summary-value">{{ $countTotal }}</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon icon-low">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Stok Menipis</div>
                        <div class="summary-value">{{ $countRendah }}</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon icon-empty">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Stok Habis</div>
                        <div class="summary-value">{{ $countHabis }}</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon icon-expired">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Kadaluarsa</div>
                        <div class="summary-value">{{ $countExpired }}</div>
                    </div>
                </div>
            </div>

            {{-- FILTERS & SEARCH — GET form --}}
            <form method="GET" action="{{ route('kelolaDataObat') }}" class="filter-section" id="filterForm">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" id="search-input"
                           value="{{ request('search') }}"
                           placeholder="Cari nama obat..."
                           class="search-input">
                </div>
                <div class="filter-group">
                    {{-- Kategori dari DB --}}
                    <select class="filter-select" name="kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
<<<<<<< HEAD
                        <option value="umum">Umum</option>
                        <option value="analgesik">Analgesik</option>
                        <option value="antibiotik">Antibiotik</option>
                        <option value="antihistamin">Antihistamin</option>
                        <option value="vitamin">Vitamin</option>
=======
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}"
                                {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->kategori_obat }}
                            </option>
                        @endforeach
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                    </select>
                    <select class="filter-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="tersedia"   {{ request('status') === 'tersedia'   ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis"      {{ request('status') === 'habis'      ? 'selected' : '' }}>Habis</option>
                        <option value="kadaluarsa" {{ request('status') === 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                    </select>
                    <button type="submit" class="btn-tambah" style="background:linear-gradient(135deg,#475569,#334155);">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                    @if(request()->hasAny(['search','kategori','status']))
                        <a href="{{ route('kelolaDataObat') }}" class="btn-tambah" style="background:linear-gradient(135deg,#94a3b8,#64748b);">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </a>
                    @endif
                    <button type="button" class="btn-tambah" id="btnTambahObat">
                        <i class="fa-solid fa-plus"></i> Tambah Obat
                    </button>
                    <button type="button" class="btn-tambah" id="btnKelolaKategori"
                            style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
                        <i class="fa-solid fa-tags"></i> Kategori
                    </button>
                </div>
            </form>

            {{-- MEDICINES TABLE — dari DB --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table medicines-table">
                        <thead>
                            <tr>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th style="text-align:center;">Stok</th>
                                <th>Harga</th>
                                <th>Tgl Kadaluarsa</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obatList as $obat)
                                @php
                                    $statusInfo = match($obat->status) {
                                        'tersedia'   => ['label' => 'Tersedia',   'class' => 'status-selesai'],
                                        'habis'      => ['label' => 'Habis',      'class' => 'status-batal'],
                                        'kadaluarsa' => ['label' => 'Kadaluarsa', 'class' => 'status-batal'],
                                        default      => ['label' => ucfirst($obat->status), 'class' => 'status-pending'],
                                    };
                                    $stokClass = $obat->stok === 0 ? 'color:#ef4444;font-weight:700;'
                                               : ($obat->stok < 10 ? 'color:#f59e0b;font-weight:600;' : 'color:#22c55e;font-weight:600;');
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:600;color:#1e293b;">{{ $obat->nama_obat }}</div>
                                        <div style="font-size:.72rem;color:#94a3b8;">ID #{{ $obat->id_obat }}</div>
                                    </td>
                                    <td>{{ $obat->kategori->kategori_obat ?? '-' }}</td>
                                    <td style="text-align:center;">
                                        <span style="{{ $stokClass }}">{{ $obat->stok }}</span>
                                    </td>
                                    <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                    <td style="color:#64748b;font-size:.85rem;">
                                        {{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('d M Y') : '-' }}
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="status-badge {{ $statusInfo['class'] }}">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <div style="display:flex;gap:6px;justify-content:center;">
                                            <button type="button" class="btn-aksi btn-edit"
                                                    title="Edit"
                                                    onclick="bukaModalEdit({{ $obat->id_obat }})">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <form method="POST"
                                                  action="{{ route('admin.obat.destroy', $obat->id_obat) }}"
                                                  onsubmit="return confirm('Hapus obat {{ addslashes($obat->nama_obat) }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-aksi btn-hapus" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">
                                        <i class="fa-solid fa-box-open" style="font-size:2rem;"></i>
                                        <p style="margin-top:10px;">Tidak ada data obat ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Menampilkan {{ $obatList->firstItem() ?? 0 }}–{{ $obatList->lastItem() ?? 0 }}
                    dari {{ $obatList->total() }} obat
                </div>
                <div class="pagination">
                    {{ $obatList->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL TAMBAH OBAT --}}
    <div class="modal-overlay" id="modalTambah" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-icon">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Tambah Obat Baru</div>
                    <div class="modal-subtitle">Isi data obat dengan lengkap</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalTambah')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.obat.store') }}">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                        <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;
                                    padding:10px 14px;border-radius:8px;margin-bottom:12px;font-size:.82rem;">
                            <ul style="margin:0;padding-left:16px;">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Obat <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-pills"></i>
                                <input type="text" name="nama_obat"
                                       value="{{ old('nama_obat') }}"
                                       placeholder="Contoh: Paracetamol 500mg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kategori <span style="color:#DC2626">*</span></label>
                            <select name="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}"
                                        {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->kategori_obat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Stok <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-boxes-stacking"></i>
                                <input type="number" name="stok" min="0"
                                       value="{{ old('stok', 0) }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp) <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-tag"></i>
                                <input type="number" name="harga" min="0" step="100"
                                       value="{{ old('harga') }}"
                                       placeholder="Contoh: 5000" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Status <span style="color:#DC2626">*</span></label>
                            <select name="status" required>
                                <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="habis"    {{ old('status') === 'habis'    ? 'selected' : '' }}>Habis</option>
                                <option value="kadaluarsa" {{ old('status') === 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-calendar-xmark"></i>
                                <input type="date" name="tanggal_kadaluarsa"
                                       value="{{ old('tanggal_kadaluarsa') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalTambah')">
                        <i class="fa-solid fa-xmark" style="margin-right:5px"></i>Batal
                    </button>
                    <button class="btn-modal-save" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Obat
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT OBAT --}}
    <div class="modal-overlay" id="modalEdit" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#0369a1,#0284c7);">
                    <i class="fa-solid fa-pen"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Edit Obat</div>
                    <div class="modal-subtitle" id="editObatSubtitle">Perbarui data obat</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalEdit')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" id="formEditObat" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Obat <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-pills"></i>
                                <input type="text" name="nama_obat" id="editNamaObat" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kategori <span style="color:#DC2626">*</span></label>
                            <select name="id_kategori" id="editKategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->kategori_obat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Stok <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-boxes-stacking"></i>
                                <input type="number" name="stok" id="editStok" min="0" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp) <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-tag"></i>
                                <input type="number" name="harga" id="editHarga" min="0" step="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Status <span style="color:#DC2626">*</span></label>
                            <select name="status" id="editStatus" required>
                                <option value="tersedia">Tersedia</option>
                                <option value="habis">Habis</option>
                                <option value="kadaluarsa">Kadaluarsa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-calendar-xmark"></i>
                                <input type="date" name="tanggal_kadaluarsa" id="editTglKadaluarsa">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalEdit')">
                        <i class="fa-solid fa-xmark" style="margin-right:5px"></i>Batal
                    </button>
                    <button class="btn-modal-save" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL KELOLA KATEGORI --}}
    <div class="modal-overlay" id="modalKategori" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Kelola Kategori Obat</div>
                    <div class="modal-subtitle">Tambah atau hapus kategori</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalKategori')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                {{-- Form tambah kategori --}}
                <form method="POST" action="{{ route('admin.kategori.store') }}" style="display:flex;gap:10px;margin-bottom:16px;">
                    @csrf
                    <div class="input-with-icon" style="flex:1;">
                        <i class="fa-solid fa-tag"></i>
                        <input type="text" name="kategori_obat" placeholder="Nama kategori baru..." required>
                    </div>
                    <button type="submit" class="btn-modal-save" style="white-space:nowrap;">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </button>
                </form>

                {{-- Daftar kategori --}}
                <div style="max-height:300px;overflow-y:auto;">
                    @forelse ($kategori as $kat)
                        <div style="display:flex;align-items:center;justify-content:space-between;
                                    padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:6px;">
                            <span style="font-weight:500;color:#1e293b;">{{ $kat->kategori_obat }}</span>
                            <form method="POST" action="{{ route('admin.kategori.destroy', $kat->id_kategori) }}"
                                  onsubmit="return confirm('Hapus kategori {{ addslashes($kat->kategori_obat) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus" title="Hapus kategori">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p style="text-align:center;color:#94a3b8;padding:20px;">Belum ada kategori.</p>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalKategori')">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast-container" id="toast-container"></div>

</div>

{{-- Data obat untuk modal edit (JSON) --}}
@php
    $obatJson = $obatList->keyBy('id_obat')->map(function($o) {
        return [
            'id_obat'            => $o->id_obat,
            'nama_obat'          => $o->nama_obat,
            'id_kategori'        => $o->id_kategori,
            'stok'               => $o->stok,
            'harga'              => $o->harga,
            'status'             => $o->status,
            'tanggal_kadaluarsa' => $o->tanggal_kadaluarsa?->format('Y-m-d'),
        ];
    });
@endphp
<script>
const OBAT_DATA = @json($obatJson);
const ROUTE_OBAT_BASE = "{{ url('/admin/kelolaDataObat') }}";
</script>
@endsection

@push('scripts')
<script>
function tutupModal(id) {
    document.getElementById(id).style.display = 'none';
}
function bukaModal(id) {
    document.getElementById(id).style.display = 'flex';
}

document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => {
        if (e.target === overlay) overlay.style.display = 'none';
    });
});

document.getElementById('btnTambahObat').addEventListener('click', () => bukaModal('modalTambah'));
document.getElementById('btnKelolaKategori').addEventListener('click', () => bukaModal('modalKategori'));

// Buka modal tambah jika ada error validasi
@if ($errors->any())
    bukaModal('modalTambah');
@endif

function bukaModalEdit(idObat) {
    const obat = OBAT_DATA[idObat];
    if (!obat) return;

    document.getElementById('editNamaObat').value      = obat.nama_obat          ?? '';
    document.getElementById('editKategori').value      = obat.id_kategori        ?? '';
    document.getElementById('editStok').value          = obat.stok               ?? 0;
    document.getElementById('editHarga').value         = obat.harga              ?? 0;
    document.getElementById('editStatus').value        = obat.status             ?? 'tersedia';
    document.getElementById('editTglKadaluarsa').value = obat.tanggal_kadaluarsa ?? '';

    document.getElementById('editObatSubtitle').textContent = 'Edit: ' + obat.nama_obat;
    document.getElementById('formEditObat').action = ROUTE_OBAT_BASE + '/' + idObat;

    bukaModal('modalEdit');
}
</script>
<script src="{{ asset('js/kelolaDataObat.js') }}"></script>
@endpush
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
