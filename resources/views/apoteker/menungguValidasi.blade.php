@extends('layouts.app')

@section('title', 'Menunggu Validasi - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">
@endpush

@section('content')

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <main class="main-content">

            <div class="page-header">
                <h2 class="section-title">Resep Masuk</h2>
                <p class="section-subtitle">Kelola dan validasi resep yang masuk dari dokter</p>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- TABS --}}
            <div class="tabs">
                <a href="{{ route('apoteker.validasi') }}" class="tab active">
                    <span class="tab-label">Menunggu Validasi</span>
                    <span class="tab-badge badge-warning">{{ $resepList->total() }}</span>
                </a>
                <a href="{{ route('apoteker.pembayaran') }}" class="tab">
                    <span class="tab-label">Menunggu Pembayaran</span>
                </a>
                <a href="{{ route('apoteker.diproses') }}" class="tab">
                    <span class="tab-label">Diproses</span>
                </a>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="resepTable" class="resep-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Resep</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resepList as $index => $detail)
                            <tr class="resep-row {{ $loop->first ? 'selected' : '' }}"
                                data-id="{{ $detail->id_detail_resep }}"
                                data-pasien="{{ $detail->pasien->user->nama ?? '-' }}"
                                data-dokter="{{ $detail->dokter->user->nama ?? '-' }}"
                                data-tanggal="{{ $detail->tanggal ? $detail->tanggal->translatedFormat('d M Y') : '-' }}"
                                data-catatan="{{ $detail->keterangan ?? '-' }}"
                                data-obat="{{ json_encode(
                                    $detail->resep->resepObat->map(fn($ro) => [
                                        'nama'   => $ro->obat->nama_obat ?? '-',
                                        'dosis'  => $ro->dosis ?? '-',
                                        'jumlah' => $ro->jumlah,
                                    ])
                                ) }}">
                                <td>{{ $resepList->firstItem() + $index }}</td>
                                <td><span class="resep-id">RSP-{{ str_pad($detail->id_detail_resep, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td>{{ $detail->pasien->user->nama ?? '-' }}</td>
                                <td>{{ $detail->dokter->user->nama ?? '-' }}</td>
                                <td>{{ $detail->tanggal ? $detail->tanggal->translatedFormat('d M Y') : '-' }}</td>
                                <td><span class="status-badge status-warning">Menunggu Validasi</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">Tidak ada resep yang menunggu validasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($resepList->hasPages())
                <div class="pagination-wrapper">
                    {{ $resepList->links() }}
                </div>
            @endif

            {{-- DETAIL SECTION (ditampilkan jika ada data) --}}
            @if($resepList->isNotEmpty())
            @php $first = $resepList->first(); @endphp
            <div class="detail-section" id="detail-section">
                <div class="detail-header">
                    <h3>Detail Resep</h3>
                    <span class="detail-id" id="detail-id">
                        RSP-{{ str_pad($first->id_detail_resep, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="detail-grid">
                    <div class="detail-info">
                        <div class="detail-item">
                            <span class="detail-label">Pasien</span>
                            <span class="detail-value" id="detail-pasien">{{ $first->pasien->user->nama ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Dokter</span>
                            <span class="detail-value" id="detail-dokter">{{ $first->dokter->user->nama ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tanggal</span>
                            <span class="detail-value" id="detail-tanggal">
                                {{ $first->tanggal ? $first->tanggal->translatedFormat('d M Y') : '-' }}
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Catatan</span>
                            <span class="detail-value" id="detail-catatan">{{ $first->keterangan ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="detail-obat">
                        <h4 class="obat-title">Daftar Obat</h4>
                        <table class="obat-table">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Dosis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="detail-obat-tbody">
                                @foreach($first->resep->resepObat as $ro)
                                    <tr>
                                        <td>{{ $ro->obat->nama_obat ?? '-' }}</td>
                                        <td>{{ $ro->dosis ?? '-' }}</td>
                                        <td>{{ $ro->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="actions">
                    {{-- Tombol Tolak → buka modal tolak --}}
                    <button type="button" class="btn-custom btn-outline" id="btn-open-tolak">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        Tolak
                    </button>

                    {{-- Tombol Validasi → submit form validasi --}}
                    <form id="form-validasi" method="POST" action="{{ route('apoteker.validasi.proses', $first->id_detail_resep) }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id_detail_resep" id="input-id-validasi" value="{{ $first->id_detail_resep }}">
                        <button type="submit" class="btn-custom btn-primary" id="btn-validasi">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            Validasi
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </main>
    </div>
</div>

{{-- MODAL TOLAK --}}
<div class="modal-overlay" id="modal-tolak" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title">Tolak Resep</h3>
            <button class="modal-close" id="modal-tolak-close">×</button>
        </div>
        <form id="form-tolak" method="POST" action="">
            @csrf
            <div class="modal-body">
                <div class="modal-content-center">
                    <p>Masukkan alasan penolakan resep ini:</p>
                    <textarea name="keterangan" id="input-keterangan" rows="3"
                        class="form-control" placeholder="Contoh: Stok obat habis..." required
                        style="width:100%; margin-top:8px; padding:8px; border-radius:8px; border:1px solid #ddd;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" id="modal-tolak-cancel">Batal</button>
                <button type="submit" class="btn-modal-primary btn-danger">Tolak Resep</button>
            </div>
        </form>
    </div>
</div>

<div id="toast-container" class="toast-container"></div>

@endsection

@push('scripts')
<script src="{{ asset('js/dashboardApoteker.js') }}"></script>
<script>
(function () {
    // ── Klik baris tabel → update detail panel ──────────────
    document.querySelectorAll('.resep-row').forEach(function (row) {
        row.addEventListener('click', function () {
            // Hapus selected dari semua baris
            document.querySelectorAll('.resep-row').forEach(r => r.classList.remove('selected'));
            this.classList.add('selected');

            var id      = this.dataset.id;
            var pasien  = this.dataset.pasien;
            var dokter  = this.dataset.dokter;
            var tanggal = this.dataset.tanggal;
            var catatan = this.dataset.catatan;
            var obat    = JSON.parse(this.dataset.obat);

            // Update teks detail
            document.getElementById('detail-id').textContent =
                'RSP-' + String(id).padStart(4, '0');
            document.getElementById('detail-pasien').textContent  = pasien;
            document.getElementById('detail-dokter').textContent  = dokter;
            document.getElementById('detail-tanggal').textContent = tanggal;
            document.getElementById('detail-catatan').textContent = catatan;

            // Update tabel obat
            var tbody = document.getElementById('detail-obat-tbody');
            tbody.innerHTML = '';
            obat.forEach(function (o) {
                tbody.insertAdjacentHTML('beforeend',
                    '<tr><td>' + o.nama + '</td><td>' + o.dosis + '</td><td>' + o.jumlah + '</td></tr>'
                );
            });

            // Update action form dengan id yang dipilih
            var formValidasi = document.getElementById('form-validasi');
            formValidasi.action = '{{ url("apoteker/validasi") }}/' + id;
            document.getElementById('input-id-validasi').value = id;

            // Simpan id aktif untuk modal tolak
            document.getElementById('modal-tolak').dataset.activeId = id;
        });
    });

    // ── Modal Tolak ──────────────────────────────────────────
    var modalTolak = document.getElementById('modal-tolak');
    var formTolak  = document.getElementById('form-tolak');

    document.getElementById('btn-open-tolak').addEventListener('click', function () {
        var activeId = document.getElementById('modal-tolak').dataset.activeId
            || document.querySelector('.resep-row.selected')?.dataset.id;
        if (!activeId) return;
        formTolak.action = '{{ url("apoteker/validasi") }}/' + activeId + '/tolak';
        modalTolak.style.display = 'flex';
    });

    document.getElementById('modal-tolak-close').addEventListener('click', function () {
        modalTolak.style.display = 'none';
    });
    document.getElementById('modal-tolak-cancel').addEventListener('click', function () {
        modalTolak.style.display = 'none';
    });
    modalTolak.addEventListener('click', function (e) {
        if (e.target === modalTolak) modalTolak.style.display = 'none';
    });

    // Set activeId awal dari baris pertama
    var firstRow = document.querySelector('.resep-row');
    if (firstRow) {
        document.getElementById('modal-tolak').dataset.activeId = firstRow.dataset.id;
    }
})();
</script>
@endpush
