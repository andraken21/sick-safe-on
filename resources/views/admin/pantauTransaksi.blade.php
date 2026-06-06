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
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            {{-- SUMMARY CARDS — data dari controller --}}
            @php
                $totalTrx    = $transaksiList->total();
                $totalSelesai = \App\Models\Transaksi::where('status', 'lunas')->count();
                $totalPendingCount = \App\Models\Transaksi::where('status', 'pending')->count();
                $totalBatal  = \App\Models\Transaksi::where('status', 'batal')->count();
            @endphp

            <div class="trx-summary">
                <div class="summary-card">
                    <div class="summary-icon icon-total">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Total Transaksi</div>
<<<<<<< HEAD
                        <div class="summary-value">{{ number_format($summary['total'] ?? 0, 0, ',', '.') }}</div>
                        <div class="summary-sub">Bulan ini</div>
=======
                        <div class="summary-value">{{ $totalTrx }}</div>
                        <div class="summary-sub">Semua data</div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="summary-info">
<<<<<<< HEAD
                        <div class="summary-label">Transaksi Selesai</div>
                        <div class="summary-value">{{ number_format($summary['selesai'] ?? 0, 0, ',', '.') }}</div>
                        <div class="summary-sub">Rp {{ number_format($summary['selesai_nominal'] ?? 0, 0, ',', '.') }}</div>
=======
                        <div class="summary-label">Transaksi Lunas</div>
                        <div class="summary-value">{{ $totalSelesai }}</div>
                        <div class="summary-sub">
                            Rp {{ number_format($totalLunas, 0, ',', '.') }}
                        </div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-pending">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">Transaksi Pending</div>
<<<<<<< HEAD
                        <div class="summary-value">{{ number_format($summary['pending'] ?? 0, 0, ',', '.') }}</div>
                        <div class="summary-sub">Rp {{ number_format($summary['pending_nominal'] ?? 0, 0, ',', '.') }}</div>
=======
                        <div class="summary-value">{{ $totalPending }}</div>
                        <div class="summary-sub">Menunggu konfirmasi</div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div class="summary-info">
<<<<<<< HEAD
                        <div class="summary-label">Transaksi Gagal</div>
                        <div class="summary-value">{{ number_format($summary['gagal'] ?? 0, 0, ',', '.') }}</div>
                        <div class="summary-sub">Rp {{ number_format($summary['gagal_nominal'] ?? 0, 0, ',', '.') }}</div>
=======
                        <div class="summary-label">Transaksi Batal</div>
                        <div class="summary-value">{{ $totalBatal }}</div>
                        <div class="summary-sub">Dibatalkan</div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                    </div>
                </div>
            </div>

            {{-- FILTERS & SEARCH — form GET --}}
            <form method="GET" action="{{ route('pantauTransaksi') }}" class="filter-section" id="filterForm">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" id="search-input"
                           value="{{ request('search') }}"
                           placeholder="Cari nama pasien..."
                           class="search-input">
                </div>
                <div class="filter-group">
                    <select class="filter-select" name="metode"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Metode</option>
                        <option value="bpjs"     {{ request('metode') === 'bpjs'     ? 'selected' : '' }}>BPJS</option>
                        <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Mandiri</option>
                        <option value="qris"     {{ request('metode') === 'qris'     ? 'selected' : '' }}>QRIS</option>
                    </select>
                    <select class="filter-select" name="status"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Status</option>
                        <option value="lunas"   {{ request('status') === 'lunas'   ? 'selected' : '' }}>Lunas</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="batal"   {{ request('status') === 'batal'   ? 'selected' : '' }}>Batal</option>
                    </select>
                    <input type="date" name="dari" class="filter-select"
                           value="{{ request('dari') }}" title="Dari tanggal">
                    <input type="date" name="sampai" class="filter-select"
                           value="{{ request('sampai') }}" title="Sampai tanggal">
                    <button type="submit" class="btn-tambah" style="background:linear-gradient(135deg,#475569,#334155);">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                    @if (request()->hasAny(['search','status','metode','dari','sampai']))
                        <a href="{{ route('pantauTransaksi') }}" class="btn-tambah" style="background:linear-gradient(135deg,#94a3b8,#64748b);text-decoration:none;">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- TABEL TRANSAKSI — data dari $transaksiList --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table transactions-table">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Nama Pasien</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
<<<<<<< HEAD
                            @forelse($transactions ?? [] as $transaction)
                            @php
                                $prescription = $transaction->prescription;
                                $pasien = optional(optional($prescription)->pasien);
                                $pasienUser = optional($pasien->user);
                                $kasirUser = optional(optional(optional($prescription)->apoteker)->user);
                                $statusClass = $transaction->Status === 'lunas' ? 'selesai' : $transaction->Status;
                                $statusLabel = $transaction->Status === 'lunas' ? 'Selesai' : ucfirst($transaction->Status);
                                $metode = $transaction->Metode ?: 'Mandiri';
                            @endphp
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td><span class="trx-id">TRX-{{ now()->year }}-{{ str_pad((string) $transaction->ID_Pembayaran, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">{{ $pasienUser->nama ?? 'Pasien tidak ditemukan' }}</div>
                                        <div class="patient-sub">{{ $pasien->No_BPJS ? 'Pasien BPJS' : 'Pasien Umum' }}</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-{{ str_pad((string) optional($prescription)->ID_Pasien, 5, '0', STR_PAD_LEFT) }}</span></td>
                                <td><span class="type-badge type-{{ strtolower($metode) === 'bpjs' ? 'bpjs' : 'mandiri' }}">{{ $metode }}</span></td>
                                <td class="amount-cell">Rp {{ number_format($transaction->Total_Bayar, 0, ',', '.') }}</td>
                                <td class="time-cell">
                                    <div>{{ optional($transaction->Tanggal_Bayar)->format('d M Y') ?? '-' }}</div>
                                    <div class="time-sub">{{ optional($transaction->created_at)->format('H:i') ?? '--:--' }} WIB</div>
                                </td>
                                <td>{{ $kasirUser->nama ?? '-' }}</td>
                                <td><span class="status-badge status-{{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            {{-- Transaction 1 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0847</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Andi Setiawan</div>
                                        <div class="patient-sub">Pasien Umum</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-02456</span></td>
                                <td><span class="type-badge type-bpjs">BPJS</span></td>
                                <td class="amount-cell">Rp 125.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">14:32 WIB</div>
                                </td>
                                <td>Siti Indriyani</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 2 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0846</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Dewi Kusuma</div>
                                        <div class="patient-sub">Pasien BPJS</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-01298</span></td>
                                <td><span class="type-badge type-mandiri">Mandiri</span></td>
                                <td class="amount-cell">Rp 85.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">13:15 WIB</div>
                                </td>
                                <td>Reza Pratama</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 3 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0845</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Bambang Sutrisno</div>
                                        <div class="patient-sub">Pasien Umum</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-03121</span></td>
                                <td><span class="type-badge type-bpjs">BPJS</span></td>
                                <td class="amount-cell">Rp 210.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">12:45 WIB</div>
                                </td>
                                <td>Aprina Santoso</td>
                                <td><span class="status-badge status-pending">⏳ Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 4 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0844</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Lina Maulida</div>
                                        <div class="patient-sub">Pasien BPJS</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-02897</span></td>
                                <td><span class="type-badge type-mandiri">Mandiri</span></td>
                                <td class="amount-cell">Rp 55.000</td>
                                <td class="time-cell">
                                    <div>16 Mei 2026</div>
                                    <div class="time-sub">11:20 WIB</div>
                                </td>
                                <td>Siti Indriyani</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 5 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0843</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Hendra Gunawan</div>
                                        <div class="patient-sub">Pasien Umum</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-01567</span></td>
                                <td><span class="type-badge type-bpjs">BPJS</span></td>
                                <td class="amount-cell">Rp 320.000</td>
                                <td class="time-cell">
                                    <div>15 Mei 2026</div>
                                    <div class="time-sub">16:05 WIB</div>
                                </td>
                                <td>Nurul Putri</td>
                                <td><span class="status-badge status-gagal">✗ Gagal</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Transaction 6 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <span class="trx-id">TRX-2026-0842</span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-name">Maya Safitri</div>
                                        <div class="patient-sub">Pasien BPJS</div>
                                    </div>
                                </td>
                                <td><span class="rm-number">RM-02345</span></td>
                                <td><span class="type-badge type-mandiri">Mandiri</span></td>
                                <td class="amount-cell">Rp 175.000</td>
                                <td class="time-cell">
                                    <div>15 Mei 2026</div>
                                    <div class="time-sub">15:30 WIB</div>
                                </td>
                                <td>Reza Pratama</td>
                                <td><span class="status-badge status-selesai">✓ Selesai</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Cetak">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
=======
                            @forelse ($transaksiList as $trx)
                                @php
                                    $noTrx = 'TRX-' . $trx->created_at->format('Y') . '-' . str_pad($trx->id_transaksi, 4, '0', STR_PAD_LEFT);
                                    $metode = match($trx->metode) {
                                        'bpjs'     => ['label' => 'BPJS',    'class' => 'type-bpjs'],
                                        'transfer' => ['label' => 'Mandiri', 'class' => 'type-mandiri'],
                                        'qris'     => ['label' => 'QRIS',    'class' => 'type-qris'],
                                        default    => ['label' => 'Belum dipilih', 'class' => 'type-mandiri'],
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
                                    <td>
                                        <span class="trx-name">{{ $trx->pasien->user->nama ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="trx-type {{ $metode['class'] }}">{{ $metode['label'] }}</span>
                                    </td>
                                    <td class="trx-amount">
                                        Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="trx-date">
                                        {{ $trx->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $status['class'] }}">
                                            <i class="fa-solid {{ $status['icon'] }}" style="font-size:10px;"></i>
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($trx->status === 'pending' && $trx->metode)
                                            <div style="display:flex;gap:6px;">
                                                <form method="POST"
                                                      action="{{ route('admin.pembayaran.konfirmasi', $trx->id_transaksi) }}"
                                                      onsubmit="return confirm('Konfirmasi pembayaran ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn-aksi btn-konfirmasi" title="Konfirmasi Lunas">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn-aksi btn-hapus" title="Batalkan"
                                                        onclick="bukaModalBatal({{ $trx->id_transaksi }})">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">
                                        <i class="fa-solid fa-receipt" style="font-size:2rem;"></i>
                                        <p style="margin-top:10px;">Tidak ada transaksi ditemukan.</p>
                                    </td>
                                </tr>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrap">
                <div class="pagination-info">
<<<<<<< HEAD
                    Menampilkan <strong>{{ method_exists($transactions ?? null, 'firstItem') ? ($transactions->firstItem() ?? 0) : 0 }}-{{ method_exists($transactions ?? null, 'lastItem') ? ($transactions->lastItem() ?? 0) : 0 }}</strong> dari <strong>{{ method_exists($transactions ?? null, 'total') ? $transactions->total() : 0 }}</strong> transaksi
=======
                    Menampilkan {{ $transaksiList->firstItem() ?? 0 }}–{{ $transaksiList->lastItem() ?? 0 }}
                    dari {{ $transaksiList->total() }} transaksi
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                </div>
                <div class="pagination">
                    {{ $transaksiList->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>

<<<<<<< HEAD
<script src="{{ asset('js/pantauTransaksi.js') }}"></script>
</div>
@endsection
=======
    {{-- MODAL BATALKAN PEMBAYARAN --}}
    <div class="modal-overlay" id="modalBatal" style="display:none;">
        <div class="modal-box" style="max-width:440px;">
            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Batalkan Pembayaran</div>
                    <div class="modal-subtitle">Masukkan alasan pembatalan</div>
                </div>
                <button class="modal-close" type="button" onclick="document.getElementById('modalBatal').style.display='none'">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" id="formBatal" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Keterangan <span style="color:#DC2626">*</span></label>
                        <textarea name="keterangan" rows="3" required
                                  placeholder="Contoh: Bukti transfer tidak valid..."
                                  style="width:100%;padding:10px;border:1px solid #e2e8f0;border-radius:8px;font-family:inherit;resize:vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button"
                            onclick="document.getElementById('modalBatal').style.display='none'">Tutup</button>
                    <button class="btn-modal-save" type="submit"
                            style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                        <i class="fa-solid fa-circle-xmark"></i> Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function bukaModalBatal(idTransaksi) {
        const base = "{{ url('/admin/konfirmasiPembayaran') }}";
        document.getElementById('formBatal').action = `${base}/${idTransaksi}/batal`;
        document.getElementById('modalBatal').style.display = 'flex';
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.style.display = 'none';
        });
    });
</script>

@endsection
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
