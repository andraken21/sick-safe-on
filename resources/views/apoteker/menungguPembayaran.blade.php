@extends('layouts.app')

@section('title', 'Menunggu Pembayaran - Sick Safe ON')

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
                <a href="{{ route('apoteker.pembayaran') }}" class="tab active">
                    <span class="tab-label">Menunggu Pembayaran</span>
                    <span class="tab-badge badge-info">{{ $resepList->total() }}</span>
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
                            <th>Total Harga</th>
                            <th>Status Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resepList as $index => $detail)
                            @php
                                $transaksi = $detail->resep->detailTransaksi->first()?->transaksi;
                                $totalBayar = $transaksi?->total_bayar ?? 0;
                                $statusBayar = $transaksi?->status ?? 'pending';
                                $obatList = $detail->resep->resepObat->map(fn($ro) => [
                                    'nama'   => $ro->obat->nama_obat ?? '-',
                                    'dosis'  => $ro->dosis ?? '-',
                                    'jumlah' => $ro->jumlah,
                                    'harga'  => $ro->obat->harga ?? 0,
                                ]);
                            @endphp
                            <tr class="resep-row {{ $loop->first ? 'selected' : '' }}"
                                data-id="{{ $detail->id_detail_resep }}"
                                data-pasien="{{ $detail->pasien->user->nama ?? '-' }}"
                                data-dokter="{{ $detail->dokter->user->nama ?? '-' }}"
                                data-tanggal="{{ $detail->tanggal ? $detail->tanggal->translatedFormat('d M Y') : '-' }}"
                                data-total="{{ 'Rp ' . number_format($totalBayar, 0, ',', '.') }}"
                                data-status-bayar="{{ $statusBayar }}"
                                data-obat="{{ json_encode($obatList) }}">
                                <td>{{ $resepList->firstItem() + $index }}</td>
                                <td><span class="resep-id">RSP-{{ str_pad($detail->id_detail_resep, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td>{{ $detail->pasien->user->nama ?? '-' }}</td>
                                <td>{{ $detail->dokter->user->nama ?? '-' }}</td>
                                <td>{{ $detail->tanggal ? $detail->tanggal->translatedFormat('d M Y') : '-' }}</td>
                                <td>Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                <td>
                                    @if($statusBayar === 'pending')
                                        <span class="status-badge status-warning">Belum Bayar</span>
                                    @elseif($statusBayar === 'lunas')
                                        <span class="status-badge status-success">Sudah Bayar</span>
                                    @else
                                        <span class="status-badge status-info">{{ $statusBayar }}</span>
                                    @endif
                                </td>
                                <td><span class="status-badge status-info">Menunggu Pembayaran</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">Tidak ada resep yang menunggu pembayaran.</td>
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
            @php
                $first       = $resepList->first();
                $firstTrx    = $first->resep->detailTransaksi->first()?->transaksi;
                $firstTotal  = $firstTrx?->total_bayar ?? 0;
                $firstStatus = $firstTrx?->status ?? 'pending';
            @endphp
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
                            <span class="detail-label">Total Harga</span>
                            <span class="detail-value highlight" id="detail-total">
                                Rp {{ number_format($firstTotal, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status Bayar</span>
                            <span class="detail-value" id="detail-status-bayar">
                                @if($firstStatus === 'pending')
                                    <span class="status-badge status-warning">Belum Bayar</span>
                                @else
                                    <span class="status-badge status-success">Sudah Bayar</span>
                                @endif
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
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="detail-obat-tbody">
                                @foreach($first->resep->resepObat as $ro)
                                    <tr>
                                        <td>{{ $ro->obat->nama_obat ?? '-' }}</td>
                                        <td>{{ $ro->dosis ?? '-' }}</td>
                                        <td>{{ $ro->jumlah }}</td>
                                        <td>Rp {{ number_format($ro->obat->harga ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="actions">
                    {{-- Konfirmasi Pembayaran --}}
                    <form id="form-konfirmasi" method="POST"
                          action="{{ route('apoteker.pembayaran.konfirmasi', $first->id_detail_resep) }}"
                          style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-custom btn-dark" id="btn-konfirmasi">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </main>
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

            var id          = this.dataset.id;
            var pasien      = this.dataset.pasien;
            var dokter      = this.dataset.dokter;
            var tanggal     = this.dataset.tanggal;
            var total       = this.dataset.total;
            var statusBayar = this.dataset.statusBayar;
            var obat        = JSON.parse(this.dataset.obat);

            document.getElementById('detail-id').textContent      = 'RSP-' + String(id).padStart(4, '0');
            document.getElementById('detail-pasien').textContent  = pasien;
            document.getElementById('detail-dokter').textContent  = dokter;
            document.getElementById('detail-tanggal').textContent = tanggal;
            document.getElementById('detail-total').textContent   = total;

            // Status bayar badge
            var statusEl = document.getElementById('detail-status-bayar');
            statusEl.innerHTML = statusBayar === 'pending'
                ? '<span class="status-badge status-warning">Belum Bayar</span>'
                : '<span class="status-badge status-success">Sudah Bayar</span>';

            // Tabel obat
            var tbody = document.getElementById('detail-obat-tbody');
            tbody.innerHTML = '';
            obat.forEach(function (o) {
                var hargaFmt = 'Rp ' + Number(o.harga).toLocaleString('id-ID');
                tbody.insertAdjacentHTML('beforeend',
                    '<tr><td>' + o.nama + '</td><td>' + o.dosis +
                    '</td><td>' + o.jumlah + '</td><td>' + hargaFmt + '</td></tr>'
                );
            });

            // Update action form konfirmasi
            var formKonfirmasi = document.getElementById('form-konfirmasi');
            formKonfirmasi.action = '{{ url("apoteker/pembayaran") }}/' + id;
        });
    });
})();
</script>
@endpush
