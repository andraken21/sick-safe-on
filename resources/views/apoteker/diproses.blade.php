@extends('layouts.app')

@section('title', 'Diproses - Sick Safe ON')

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
                <a href="{{ route('apoteker.validasi') }}" class="tab">
                    <span class="tab-label">Menunggu Validasi</span>
                </a>
                <a href="{{ route('apoteker.pembayaran') }}" class="tab">
                    <span class="tab-label">Menunggu Pembayaran</span>
                </a>
                <a href="{{ route('apoteker.diproses') }}" class="tab active">
                    <span class="tab-label">Diproses</span>
                    <span class="tab-badge badge-success">{{ $resepList->total() }}</span>
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
                            @php
                                $obatList = $detail->resep->resepObat->map(fn($ro) => [
                                    'nama'   => $ro->obat->nama_obat ?? '-',
                                    'dosis'  => $ro->dosis ?? '-',
                                    'jumlah' => $ro->jumlah,
                                    'stok'   => $ro->obat->stok ?? 0,
                                ]);
                            @endphp
                            <tr class="resep-row {{ $loop->first ? 'selected' : '' }}"
                                data-id="{{ $detail->id_detail_resep }}"
                                data-pasien="{{ $detail->pasien->user->nama ?? '-' }}"
                                data-dokter="{{ $detail->dokter->user->nama ?? '-' }}"
                                data-tanggal="{{ $detail->tanggal ? $detail->tanggal->translatedFormat('d M Y') : '-' }}"
                                data-obat="{{ json_encode($obatList) }}">
                                <td>{{ $resepList->firstItem() + $index }}</td>
                                <td><span class="resep-id">RSP-{{ str_pad($detail->id_detail_resep, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td>{{ $detail->pasien->user->nama ?? '-' }}</td>
                                <td>{{ $detail->dokter->user->nama ?? '-' }}</td>
                                <td>{{ $detail->tanggal ? $detail->tanggal->translatedFormat('d M Y') : '-' }}</td>
                                <td><span class="status-badge status-success">Diproses</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">Tidak ada resep yang sedang diproses.</td>
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

            {{-- DETAIL SECTION --}}
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
                            <span class="detail-label">Jumlah Jenis Obat</span>
                            <span class="detail-value" id="detail-jml-obat">
                                {{ $first->resep->resepObat->count() }} jenis
                            </span>
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
                                    <th>Stok Tersisa</th>
                                </tr>
                            </thead>
                            <tbody id="detail-obat-tbody">
                                @foreach($first->resep->resepObat as $ro)
                                    <tr>
                                        <td>{{ $ro->obat->nama_obat ?? '-' }}</td>
                                        <td>{{ $ro->dosis ?? '-' }}</td>
                                        <td>{{ $ro->jumlah }}</td>
                                        <td>
                                            @if(($ro->obat->stok ?? 0) <= 0)
                                                <span class="status-badge status-danger">Habis</span>
                                            @elseif(($ro->obat->stok ?? 0) < 10)
                                                <span class="status-badge status-warning">{{ $ro->obat->stok }}</span>
                                            @else
                                                <span class="status-badge status-success">{{ $ro->obat->stok }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="actions">
                    {{-- Tandai Selesai --}}
                    <form id="form-selesai" method="POST"
                          action="{{ route('apoteker.diproses.selesai', $first->id_detail_resep) }}"
                          style="display:inline;">
                        @csrf
                        <button type="button" class="btn-custom btn-dark" id="btn-open-selesai">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            Tandai Selesai
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </main>
    </div>
</div>

{{-- MODAL KONFIRMASI SELESAI --}}
<div class="modal-overlay" id="modal-selesai" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title">Tandai Selesai</h3>
            <button class="modal-close" id="modal-selesai-close">×</button>
        </div>
        <div class="modal-body">
            <div class="modal-content-center">
                <h2>Konfirmasi Penyelesaian</h2>
                <p>Apakah semua obat sudah disiapkan?<br>
                   Stok obat akan otomatis <strong>dikurangi</strong> setelah dikonfirmasi.</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-secondary" id="modal-selesai-cancel">Batal</button>
            <button class="btn-modal-primary" id="modal-selesai-confirm">Ya, Selesaikan</button>
        </div>
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
            document.querySelectorAll('.resep-row').forEach(r => r.classList.remove('selected'));
            this.classList.add('selected');

            var id      = this.dataset.id;
            var pasien  = this.dataset.pasien;
            var dokter  = this.dataset.dokter;
            var tanggal = this.dataset.tanggal;
            var obat    = JSON.parse(this.dataset.obat);

            document.getElementById('detail-id').textContent      = 'RSP-' + String(id).padStart(4, '0');
            document.getElementById('detail-pasien').textContent  = pasien;
            document.getElementById('detail-dokter').textContent  = dokter;
            document.getElementById('detail-tanggal').textContent = tanggal;
            document.getElementById('detail-jml-obat').textContent = obat.length + ' jenis';

            // Tabel obat dengan indikator stok
            var tbody = document.getElementById('detail-obat-tbody');
            tbody.innerHTML = '';
            obat.forEach(function (o) {
                var stokBadge;
                if (o.stok <= 0) {
                    stokBadge = '<span class="status-badge status-danger">Habis</span>';
                } else if (o.stok < 10) {
                    stokBadge = '<span class="status-badge status-warning">' + o.stok + '</span>';
                } else {
                    stokBadge = '<span class="status-badge status-success">' + o.stok + '</span>';
                }
                tbody.insertAdjacentHTML('beforeend',
                    '<tr><td>' + o.nama + '</td><td>' + o.dosis +
                    '</td><td>' + o.jumlah + '</td><td>' + stokBadge + '</td></tr>'
                );
            });

            // Update action form selesai
            var formSelesai = document.getElementById('form-selesai');
            formSelesai.action = '{{ url("apoteker/diproses") }}/' + id + '/selesai';
        });
    });

    // ── Modal Tandai Selesai ─────────────────────────────────
    var modalSelesai = document.getElementById('modal-selesai');
    var formSelesai  = document.getElementById('form-selesai');

    document.getElementById('btn-open-selesai').addEventListener('click', function () {
        modalSelesai.style.display = 'flex';
    });
    document.getElementById('modal-selesai-close').addEventListener('click', function () {
        modalSelesai.style.display = 'none';
    });
    document.getElementById('modal-selesai-cancel').addEventListener('click', function () {
        modalSelesai.style.display = 'none';
    });
    document.getElementById('modal-selesai-confirm').addEventListener('click', function () {
        formSelesai.submit();
    });
    modalSelesai.addEventListener('click', function (e) {
        if (e.target === modalSelesai) modalSelesai.style.display = 'none';
    });
})();
</script>
@endpush
