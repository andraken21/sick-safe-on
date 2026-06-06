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
                <div class="alert alert-success" style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            {{-- SUMMARY CARDS — data dari $obatList --}}
            @php
                $allObat       = \App\Models\Obat::with('kategori')->get();
                $totalObat     = $allObat->count();
                $stokMenipis   = $allObat->where('stok', '>', 0)->where('stok', '<', 10)->count();
                $stokHabis     = $allObat->where('stok', '<=', 0)->count();
                $akanKadaluarsa = $allObat->filter(function($o) {
                    return $o->tanggal_kadaluarsa && $o->tanggal_kadaluarsa->diffInDays(now()) <= 30 && $o->tanggal_kadaluarsa >= now();
                })->count();
            @endphp

            <div class="med-summary">
                <div class="summary-card">
                    <div class="summary-icon icon-total">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Obat</div>
                        <div class="summary-value">{{ $totalObat }}</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-low">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Stok Menipis</div>
                        <div class="summary-value">{{ $stokMenipis }}</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-empty">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Stok Habis</div>
                        <div class="summary-value">{{ $stokHabis }}</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-expired">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Akan Kadaluarsa</div>
                        <div class="summary-value">{{ $akanKadaluarsa }}</div>
                    </div>
                </div>
            </div>

            {{-- FILTERS & SEARCH — form GET, kategori dari DB --}}
            <form method="GET" action="{{ route('kelolaDataObat') }}" class="filter-section" id="filterForm">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" id="search-input"
                           value="{{ request('search') }}"
                           placeholder="Cari nama obat..."
                           class="search-input">
                </div>

                <div class="filter-group">
                    <select class="filter-select" name="kategori" id="filter-category"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}"
                                    {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->kategori_obat }}
                            </option>
                        @endforeach
                    </select>

                    <select class="filter-select" name="status" id="filter-status"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Status</option>
                        <option value="tersedia"   {{ request('status') === 'tersedia'   ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis"      {{ request('status') === 'habis'      ? 'selected' : '' }}>Habis</option>
                        <option value="kadaluarsa" {{ request('status') === 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                    </select>

                    <button type="submit" class="btn-tambah" style="background:linear-gradient(135deg,#475569,#334155);">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>

                    <button type="button" class="btn-tambah" id="btnTambahObat">
                        <i class="fa-solid fa-plus"></i> Tambah Obat
                    </button>
                </div>
            </form>

            {{-- TABEL OBAT — data dari $obatList --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table medicines-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Nama Obat</th>
                                <th style="text-align:center;">Kategori</th>
                                <th style="text-align:center;">Stok</th>
                                <th style="text-align:center;">Harga</th>
                                <th style="text-align:center;">Tgl Kadaluarsa</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obatList as $obat)
                                @php
                                    $stokColor = $obat->stok <= 0 ? '#ef4444' : ($obat->stok < 10 ? '#f59e0b' : '#22c55e');
                                    $statusClass = match($obat->status) {
                                        'tersedia'   => 'badge-ok',
                                        'habis'      => 'badge-danger',
                                        'kadaluarsa' => 'badge-expired',
                                        default      => 'badge-ok',
                                    };
                                    $statusLabel = match($obat->status) {
                                        'tersedia'   => 'Tersedia',
                                        'habis'      => 'Habis',
                                        'kadaluarsa' => 'Kadaluarsa',
                                        default      => ucfirst($obat->status),
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:600;color:#1e293b;">{{ $obat->nama_obat }}</div>
                                        <div style="font-size:.72rem;color:#94a3b8;">ID #{{ $obat->id_obat }}</div>
                                    </td>
                                    <td style="text-align:center;">
                                        <span style="background:#e0f2fe;color:#0369a1;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;">
                                            {{ $obat->kategori->kategori_obat ?? '-' }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <span style="font-weight:700;color:{{ $stokColor }};">
                                            {{ $obat->stok }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;font-weight:600;color:#1e293b;">
                                        Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align:center;color:#64748b;font-size:.82rem;">
                                        {{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('d M Y') : '-' }}
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="stok-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td style="text-align:center;">
                                        <div style="display:flex;gap:6px;justify-content:center;">
                                            <button type="button" class="btn-aksi btn-edit"
                                                    title="Edit"
                                                    onclick="bukaModalEditObat({{ $obat->id_obat }})">
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
    <div class="modal-overlay" id="modalTambahObat" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-icon">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Tambah Obat Baru</div>
                    <div class="modal-subtitle">Isi data obat dengan lengkap</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalTambahObat')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.obat.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Obat <span style="color:#DC2626">*</span></label>
                            <input type="text" name="nama_obat" placeholder="Nama obat" required value="{{ old('nama_obat') }}">
                        </div>
                        <div class="form-group">
                            <label>Kategori <span style="color:#DC2626">*</span></label>
                            <select name="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->kategori_obat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Stok <span style="color:#DC2626">*</span></label>
                            <input type="number" name="stok" min="0" placeholder="0" required value="{{ old('stok') }}">
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp) <span style="color:#DC2626">*</span></label>
                            <input type="number" name="harga" min="0" step="0.01" placeholder="0" required value="{{ old('harga') }}">
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
                            <input type="date" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalTambahObat')">
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
    <div class="modal-overlay" id="modalEditObat" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#0369a1,#0284c7);">
                    <i class="fa-solid fa-pen"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Edit Obat</div>
                    <div class="modal-subtitle" id="editObatSub">Perbarui data obat</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalEditObat')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" id="formEditObat" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Obat <span style="color:#DC2626">*</span></label>
                            <input type="text" name="nama_obat" id="editNamaObat" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori <span style="color:#DC2626">*</span></label>
                            <select name="id_kategori" id="editKategoriObat" required>
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
                            <input type="number" name="stok" id="editStokObat" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp) <span style="color:#DC2626">*</span></label>
                            <input type="number" name="harga" id="editHargaObat" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Status <span style="color:#DC2626">*</span></label>
                            <select name="status" id="editStatusObat" required>
                                <option value="tersedia">Tersedia</option>
                                <option value="habis">Habis</option>
                                <option value="kadaluarsa">Kadaluarsa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa</label>
                            <input type="date" name="tanggal_kadaluarsa" id="editKadaluarsaObat">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalEditObat')">
                        <i class="fa-solid fa-xmark" style="margin-right:5px"></i>Batal
                    </button>
                    <button class="btn-modal-save" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL TAMBAH KATEGORI --}}
    <div class="modal-overlay" id="modalTambahKategori" style="display:none;">
        <div class="modal-box" style="max-width:420px;">
            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
                    <i class="fa-solid fa-tag"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Tambah Kategori</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalTambahKategori')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.kategori.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori <span style="color:#DC2626">*</span></label>
                        <input type="text" name="kategori_obat" placeholder="Contoh: Antibiotik" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalTambahKategori')">Batal</button>
                    <button class="btn-modal-save" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- Data obat untuk modal edit --}}
<script>
    const OBAT_DATA = @json($obatList->keyBy('id_obat')->map(function($o) {
        return [
            'id_obat'            => $o->id_obat,
            'nama_obat'          => $o->nama_obat,
            'id_kategori'        => $o->id_kategori,
            'stok'               => $o->stok,
            'harga'              => $o->harga,
            'status'             => $o->status,
            'tanggal_kadaluarsa' => $o->tanggal_kadaluarsa?->format('Y-m-d'),
        ];
    }));

    const ROUTE_UPDATE_OBAT = "{{ url('/admin/kelolaDataObat') }}";

    function tutupModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    document.getElementById('btnTambahObat').addEventListener('click', () => {
        document.getElementById('modalTambahObat').style.display = 'flex';
    });

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.style.display = 'none';
        });
    });

    function bukaModalEditObat(idObat) {
        const o = OBAT_DATA[idObat];
        if (!o) return;

        document.getElementById('editNamaObat').value       = o.nama_obat          ?? '';
        document.getElementById('editKategoriObat').value   = o.id_kategori        ?? '';
        document.getElementById('editStokObat').value       = o.stok               ?? 0;
        document.getElementById('editHargaObat').value      = o.harga              ?? 0;
        document.getElementById('editStatusObat').value     = o.status             ?? 'tersedia';
        document.getElementById('editKadaluarsaObat').value = o.tanggal_kadaluarsa ?? '';
        document.getElementById('editObatSub').textContent  = `Edit: ${o.nama_obat}`;
        document.getElementById('formEditObat').action      = `${ROUTE_UPDATE_OBAT}/${idObat}`;

        document.getElementById('modalEditObat').style.display = 'flex';
    }
</script>

@endsection

@push('scripts')
@endpush