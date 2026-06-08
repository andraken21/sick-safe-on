@extends('layouts.app')

@section('title', 'Dashboard Pasien — Sick Safe ON')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')

<div class="pasien-dashboard">

    {{-- ===== TOP BAR ===== --}}
    <div class="dash-topbar">
        <div class="dash-greeting">
            <h1 class="greeting-title">Halo, {{ Auth::user()->nama ?? 'Pasien' }} </h1>
            <p class="greeting-sub">Berikut ringkasan akun Anda</p>
        </div>
        <div class="topbar-actions">
           
            </button>
            
        </div>
    </div>

    <div class="stat-grid">

        <div class="stat-card">
            <span class="stat-number">{{ $stats['total_resep'] ?? 2 }}</span>
            <span class="stat-label">Resep</span>
        </div>

        <div class="stat-card stat-card--warning">
            <span class="stat-number">{{ $stats['menunggu_bayar'] ?? 1 }}</span>
            <span class="stat-label">Menunggu Pembayaran</span>
        </div>

        <div class="stat-card stat-card--info">
            <span class="stat-number">{{ $stats['sedang_diproses'] ?? 1 }}</span>
            <span class="stat-label">Sedang Diproses</span>
        </div>

    </div>

    {{-- ===== MAIN GRID ===== --}}
    <div class="main-grid">

        {{-- ─── KIRI: Resep Terbaru ─── --}}
        <div class="grid-col">
            <div class="section-card">
                <div class="section-head">
                    <h2 class="section-title">Resep Terbaru</h2>
                </div>

                <div class="resep-list">

                    @forelse($resepList ?? [] as $resep)
                    <div class="resep-item">
                        <div class="resep-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                            </svg>
                        </div>
                        <div class="resep-info">
                            <div class="resep-row">
                                <span class="resep-no">{{ $resep->nomor }}</span>
                                <span class="resep-date">{{ \Carbon\Carbon::parse($resep->tanggal)->format('d M Y') }}</span>
                            </div>
                            <div class="resep-row">
                                <span class="resep-dokter">{{ $resep->dokter }}</span>
                                <span class="status-badge status-{{ Str::slug($resep->status) }}">{{ $resep->status }}</span>
                            </div>
                            <div class="resep-detail">
                                {{ $resep->jumlah_obat }} Obat • Total: Rp {{ number_format($resep->total, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Data statis jika tidak ada data dari controller --}}
                    <div class="resep-item">
                        <div class="resep-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                            </svg>
                        </div>
                        <div class="resep-info">
                            <div class="resep-row">
                                <span class="resep-no">Resep #RSP-2026-0051</span>
                                <span class="resep-date">08 Desember 2026</span>
                            </div>
                            <div class="resep-row">
                                <span class="resep-dokter">Dr. Budi Santoso</span>
                                <span class="status-badge status-sedang-diproses">Sedang Diproses</span>
                            </div>
                            <div class="resep-detail">3 Obat • Total: Rp 125.000</div>
                        </div>
                    </div>

                    <div class="resep-item">
                        <div class="resep-icon resep-icon--done">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2m-6 9 2 2 4-4"/>
                            </svg>
                        </div>
                        <div class="resep-info">
                            <div class="resep-row">
                                <span class="resep-no">Resep #RSP-2026-0048</span>
                                <span class="resep-date">08 Desember 2026</span>
                            </div>
                            <div class="resep-row">
                                <span class="resep-dokter">Dr. Budi Santoso</span>
                                <span class="status-badge status-selesai">Selesai</span>
                            </div>
                            <div class="resep-detail">2 Obat • Total: Rp 85.000</div>
                        </div>
                    </div>
                    @endforelse

                </div>

                <a href="{{ route('pasien.resep') }}" class="btn-outline-full">
                    Lihat Semua Resep
                </a>
            </div>
        </div>

        {{-- ─── KANAN: Status Pesanan + Metode Pembayaran ─── --}}
        <div class="grid-col">

            {{-- Status Pesanan --}}
            <div class="section-card">
                <div class="section-head">
                    <h2 class="section-title">Status Pesanan</h2>
                </div>

                <div class="order-status-block">
                    <p class="order-no">Pesanan #ORD-2026-0077</p>
                    <span class="status-badge status-sedang-diproses" style="display:inline-flex;margin-bottom:20px;">Sedang Diproses</span>

                    {{-- Progress tracker --}}
                    <div class="progress-track">
                        <div class="track-line">
                            <div class="track-fill" style="width: 66%"></div>
                        </div>
                        <div class="track-steps">
                            <div class="track-step done">
                                <div class="step-dot"></div>
                                <span class="step-label">Dibuat</span>
                            </div>
                            <div class="track-step done">
                                <div class="step-dot"></div>
                                <span class="step-label">Dibayar</span>
                            </div>
                            <div class="track-step active">
                                <div class="step-dot"></div>
                                <span class="step-label">Diproses</span>
                            </div>
                            <div class="track-step">
                                <div class="step-dot"></div>
                                <span class="step-label">Siap</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="section-card" style="margin-top: 16px;">
                <div class="section-head">
                    <h2 class="section-title">Metode Pembayaran</h2>
                </div>

                <div class="payment-list">
                    <div class="payment-item">
                        <div class="payment-icon payment-icon--bpjs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span class="payment-label">BPJS Kesehatan</span>
                    </div>

                    <div class="payment-item">
                        <div class="payment-icon payment-icon--mandiri">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 0 0 1.946-.806 3.42 3.42 0 0 1 4.438 0 3.42 3.42 0 0 0 1.946.806 3.42 3.42 0 0 1 3.138 3.138 3.42 3.42 0 0 0 .806 1.946 3.42 3.42 0 0 1 0 4.438 3.42 3.42 0 0 0-.806 1.946 3.42 3.42 0 0 1-3.138 3.138 3.42 3.42 0 0 0-1.946.806 3.42 3.42 0 0 1-4.438 0 3.42 3.42 0 0 0-1.946-.806 3.42 3.42 0 0 1-3.138-3.138 3.42 3.42 0 0 0-.806-1.946 3.42 3.42 0 0 1 0-4.438 3.42 3.42 0 0 0 .806-1.946 3.42 3.42 0 0 1 3.138-3.138z"/>
                            </svg>
                        </div>
                        <span class="payment-label">Mandiri</span>
                    </div>
                </div>

                <a href="{{ route('pasien.pembayaran') }}" class="btn-outline-full" style="margin-top:12px;">
                    Kelola Pembayaran
                </a>
            </div>

        </div>
        {{-- /.grid-col kanan --}}

    </div>
    {{-- /.main-grid --}}
</div>
{{-- /.pasien-dashboard --}}

@endsection

@push('scripts')
<script src="{{ asset('js/dashboardPasien.js') }}"></script>
@endpush
    
