@extends('layouts.app')

@section('title', 'Pantau Transaksi - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pantauTransaksi.css') }}">
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

            {{-- SUMMARY CARDS — dari controller --}}
            <div class="trx-summary">
                <div class="summary-card">
                    <div class="summary-icon icon-total">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Transaksi</div>
                        <div class="summary-value">{{ $transaksiList->total() }}</div>
                        <div class="summary-sub">Semua data</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Pendapatan Lunas</div>
                        <div class="summary-value" style="font-size:1rem;">
                            Rp {{ number_format($totalLunas, 0, ',', '.') }}
                        </div>
                        <div class="summary-sub">Semua waktu</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-pending">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Transaksi Pending</div>
                        <div class="summary-value">{{ $totalPending }}</div>
                        <div class="summary-sub">Menunggu konfirmasi</div>
                    </div>
                </div>
            </div>

            {{-- FILTERS & SEARCH — GET form --}}
            <form method="GET" action="{{ route('pantauTransaksi') }}" class="filter-section" id="filterForm">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" id="search-input"
                           value="{{ request('search') }}"
                           placeholder="Cari nama pasien atau No. Transaksi..."
                           class="search-input">
                </div>
                <div class="filter-group">
                    <select class="filter-select" name="metode" onchange="this.form.submit()">
                        <option value="">Semua Metode</option>
                        <option value="bpjs"     {{ request('metode') === 'bpjs'     ? 'selected' : '' }}>BPJS</option>
                        <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="qris"     {{ request('metode') === 'qris'     ? 'selected' : '' }}>QRIS</option>
                    </select>
                    <select class="filter-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="lunas"   {{ request('status') === 'lunas'   ? 'selected' : '' }}>Lunas</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="batal"   {{ request('status') === 'batal'   ? 'selected' : '' }}>Batal</option>
                    </select>
                    <input type="date" class="filter-select" name="dari"
                           value="{{ request('dari') }}" title="Dari tanggal">
                    <input type="date" class="filter-select" name="sampai"
                           value="{{ request('sampai') }}" title="Sampai tanggal">
                    <button type="submit" class="btn-tambah" style="background:linear-gradient(135deg,#475569,#334155);">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                    @if(request()->hasAny(['search','metode','status','dari','sampai']))
                        <a href="{{ route('pantauTransaksi') }}" class="btn-tambah" style="background:linear-gradient(135deg,#94a3b8,#64748b);">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- TRANSACTIONS TABLE --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table transactions-table">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Nama Pasien</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksiList as $trx)
                                @php
                                    $noTrx = 'TRX-' . $trx->created_at->format('Y') . '-' . str_pad($trx->id_transaksi, 4, '0', STR_PAD_LEFT);
                                    $metode = match($trx->metode) {
                                        'bpjs'     => ['label' => 'BPJS',     'class' => 'type-bpjs'],
                                        'transfer' => ['label' => 'Transfer', 'class' => 'type-mandiri'],
                                        'qris'     => ['label' => 'QRIS',     'class' => 'type-qris'],
                                        default    => ['label' => '-',        'class' => 'type-mandiri'],
                                    };
                                    $status = match($trx->status) {
                                        'lunas'   => ['label' => 'Lunas',   'class' => 'status-selesai', 'icon' => 'fa-circle-check'],
                                        'pending' => ['label' => 'Pending', 'class' => 'status-pending', 'icon' => 'fa-clock'],
                                        'batal'   => ['label' => 'Batal',   'class' => 'status-batal',   'icon' => 'fa-circle-xmark'],
                                        default   => ['label' => ucfirst($trx->status), 'class' => 'status-pending', 'icon' => 'fa-clock'],
                                    };
                                @endphp
                                <tr>
                                    <td><span class="trx-id">{{ $noTrx }}</span></td>
                                    <td><span class="trx-name">{{ $trx->pasien->user->nama ?? '-' }}</span></td>
                                    <td>
                                        <span class="trx-type {{ $metode['class'] }}">
                                            {{ $metode['label'] }}
                                        </span>
                                    </td>
                                    <td class="trx-amount">
                                        Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="trx-date">
                                        {{ $trx->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $status['class'] }}">
                                            <i class="fa-solid {{ $status['icon'] }}" style="font-size:10px;"></i>
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px;">
                                            {{-- Konfirmasi (hanya jika pending & ada metode) --}}
                                            @if ($trx->status === 'pending' && $trx->metode)
                                                <form method="POST"
                                                      action="{{ route('admin.pembayaran.konfirmasi', $trx->id_transaksi) }}"
                                                      onsubmit="return confirm('Konfirmasi pembayaran {{ $noTrx }}?')">
                                                    @csrf
                                                    <button type="submit" class="btn-aksi btn-konfirmasi" title="Konfirmasi Lunas">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                                {{-- Batalkan --}}
                                                <button type="button" class="btn-aksi btn-hapus"
                                                        title="Batalkan"
                                                        onclick="bukaModalBatal({{ $trx->id_transaksi }}, '{{ $noTrx }}')">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            @else
                                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">
                                        <i class="fa-solid fa-receipt" style="font-size:2rem;"></i>
                                        <p style="margin-top:10px;">Tidak ada transaksi ditemukan.</p>
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
                    Menampilkan {{ $transaksiList->firstItem() ?? 0 }}–{{ $transaksiList->lastItem() ?? 0 }}
                    dari {{ $transaksiList->total() }} transaksi
                </div>
                <div class="pagination">
                    {{ $transaksiList->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL BATALKAN PEMBAYARAN --}}
    <div class="modal-overlay" id="modalBatal" style="display:none;">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Batalkan Pembayaran</div>
                    <div class="modal-subtitle" id="batalSubtitle">Masukkan alasan pembatalan</div>
                </div>
                <button class="modal-close" type="button" onclick="document.getElementById('modalBatal').style.display='none'">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" id="formBatal" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Keterangan Pembatalan <span style="color:#DC2626">*</span></label>
                        <textarea name="keterangan" rows="3" required
                                  placeholder="Contoh: Bukti transfer tidak valid, nominal tidak sesuai..."
                                  style="width:100%;border:1px solid #e2e8f0;border-radius:8px;padding:10px;font-size:.9rem;resize:vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button"
                            onclick="document.getElementById('modalBatal').style.display='none'">
                        <i class="fa-solid fa-xmark" style="margin-right:5px"></i>Batal
                    </button>
                    <button class="btn-modal-save" type="submit"
                            style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
                        <i class="fa-solid fa-ban"></i> Batalkan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast-container" id="toast-container"></div>

</div>
@endsection

@push('scripts')
<script>
const ROUTE_BATAL_BASE = "{{ url('/admin/konfirmasiPembayaran') }}";

function bukaModalBatal(idTrx, noTrx) {
    document.getElementById('batalSubtitle').textContent = 'Batalkan: ' + noTrx;
    document.getElementById('formBatal').action = ROUTE_BATAL_BASE + '/' + idTrx + '/batal';
    document.getElementById('modalBatal').style.display = 'flex';
}

document.getElementById('modalBatal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endpush