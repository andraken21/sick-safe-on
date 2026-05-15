@extends('layouts.app')

@section('title', 'Dashboard Pasien — Sick Safe ON')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/pasien-dashboard.css') }}">
@endpush

@section('content')

<div class="pasien-dashboard">

    {{-- ===== TOP BAR ===== --}}
    <div class="dash-topbar">
        <div class="dash-greeting">
            <h1 class="greeting-title">Halo, {{ Auth::user()->name ?? 'Joel Jawak' }} 👋</h1>
            <p class="greeting-sub">Berikut ringkasan akun Anda</p>
        </div>
        <div class="topbar-actions">
           
            </button>
            
        </div>
    </div>

    <div class="stat-grid">

        <div class="stat-card">
            <span class="stat-number">{{ $stats['resep_aktif'] ?? 2 }}</span>
            <span class="stat-label">Resep Aktif</span>
        </div>

        <div class="stat-card stat-card--warning">
            <span class="stat-number">{{ $stats['menunggu_bayar'] ?? 1 }}</span>
            <span class="stat-label">Menunggu Pembayaran</span>
        </div>

        <div class="stat-card stat-card--info">
            <span class="stat-number">{{ $stats['sedang_diproses'] ?? 1 }}</span>
            <span class="stat-label">Sedang Diproses</span>
        </div>

        <div class="stat-card stat-card--success">
            <span class="stat-number">{{ $stats['siap_diambil'] ?? 0 }}</span>
            <span class="stat-label">Siap Diambil/Dikirim</span>
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

                <a href="{{ route('pasien.resep.index') }}" class="btn-outline-full">
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

                <a href="{{ route('pasien.pembayaran.index') ?? '#' }}" class="btn-outline-full" style="margin-top:12px;">
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
<script src="{{ asset('js/pasien-dashboard.js') }}"></script>
@endpush
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
 
:root {
    --ss-primary:      #2bbf8e;  
    --ss-primary-light:#e6f9f4;
    --ss-primary-mid:  #d0f5ea;
    --ss-warning:      #e05e2e;
    --ss-info:         #1d6fd8;
    --ss-success:      #1fa85c;
    --ss-bg:           #eef2f7;
    --ss-card:         #ffffff;
    --ss-border:       #e4e9f0;
    --ss-text:         #1a202c;
    --ss-muted:        #7a8499;
    --ss-font:         'Plus Jakarta Sans', sans-serif;
    --ss-radius:       14px;
    --ss-radius-sm:    8px;
    --ss-shadow:       0 2px 12px rgba(0,0,0,.07);
    --ss-transition:   0.2s ease;
}

.pasien-dashboard {
    font-family: var(--ss-font);
    color: var(--ss-text);
    padding: 20px 24px;  
    max-width: 100%;      
    width: 100%;
    box-sizing: border-box;
    animation: fadeIn .4s ease both;
}
@keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
 
/* ── Top bar ── */
.dash-topbar {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 40px;
}
.greeting-title {
    font-size: 1.45rem;
    font-weight: 800;
    line-height: 1.25;
    margin: 0;
}
.greeting-sub {
    font-size: .85rem;
    color: var(--ss-muted);
    margin: 4px 0 0;
}
.topbar-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.icon-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--ss-card);
    border: 1px solid var(--ss-border);
    color: var(--ss-muted);
    cursor: pointer;
    transition: background var(--ss-transition), color var(--ss-transition);
}
.icon-btn:hover { background: var(--ss-primary-light); color: var(--ss-primary); }
.dash-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--ss-primary);
}
 

.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
 
.stat-card {
    background: var(--ss-card);
    border-radius: var(--ss-radius);
    padding: 20px 20px 18px;
    box-shadow: var(--ss-shadow);
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid var(--ss-border);
    transition: transform var(--ss-transition), box-shadow var(--ss-transition);
    animation: fadeIn .5s ease both;
}
.stat-card:nth-child(1) { animation-delay: .05s; }
.stat-card:nth-child(2) { animation-delay: .10s; }
.stat-card:nth-child(3) { animation-delay: .15s; }
.stat-card:nth-child(4) { animation-delay: .20s; }
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.10); }
 
.stat-number {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    color: var(--ss-text);
}
.stat-card--warning .stat-number { color: var(--ss-warning); }
.stat-card--info    .stat-number { color: var(--ss-info); }
.stat-card--success .stat-number { color: var(--ss-success); }
 
.stat-label {
    font-size: .78rem;
    color: var(--ss-muted);
    font-weight: 500;
    line-height: 1.3;
}
.main-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 16px;
    align-items: start;
}
 
.section-card {
    background: var(--ss-card);
    border-radius: var(--ss-radius);
    padding: 22px;
    box-shadow: var(--ss-shadow);
    border: 1px solid var(--ss-border);
    animation: fadeIn .5s ease .25s both;
}
.section-head { margin-bottom: 16px; }
.section-title {
    font-size: .95rem;
    font-weight: 700;
    margin: 0;
}

.resep-list { display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; }
 
.resep-item {
    display: flex;
    gap: 12px;
    padding: 14px;
    border: 1px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    transition: background var(--ss-transition), border-color var(--ss-transition);
}
.resep-item:hover { background: var(--ss-primary-light); border-color: var(--ss-primary-mid); }
 
.resep-icon {
    width: 38px;
    height: 38px;
    border-radius: var(--ss-radius-sm);
    background: var(--ss-primary-light);
    color: var(--ss-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.resep-icon--done { background: #f0fdf4; color: var(--ss-success); }
 
.resep-info { flex: 1; display: flex; flex-direction: column; gap: 5px; }
.resep-row { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.resep-no { font-size: .875rem; font-weight: 700; }
.resep-date { font-size: .75rem; color: var(--ss-muted); }
.resep-dokter { font-size: .8rem; color: var(--ss-muted); }
.resep-detail { font-size: .75rem; color: var(--ss-muted); margin-top: 2px; }

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 600;
    line-height: 1.5;
}
.status-sedang-diproses { background: #dbeafe; color: #1d4ed8; }
.status-selesai         { background: #dcfce7; color: #15803d; }
.status-menunggu-pembayaran { background: #fef9c3; color: #a16207; }
.status-siap            { background: #f0fdf4; color: #15803d; }
.status-dibatalkan      { background: #fee2e2; color: #b91c1c; }
 
.btn-outline-full {
    display: block;
    width: 100%;
    padding: 11px 16px;
    border: 1.5px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    background: transparent;
    font-size: .85rem;
    font-weight: 600;
    color: var(--ss-text);
    text-align: center;
    cursor: pointer;
    transition: background var(--ss-transition), border-color var(--ss-transition), color var(--ss-transition);
    font-family: var(--ss-font);
    text-decoration: none;
}
.btn-outline-full:hover {
    background: var(--ss-primary-light);
    border-color: var(--ss-primary);
    color: var(--ss-primary);
}

.order-status-block { display: flex; flex-direction: column; }
.order-no { font-size: .88rem; font-weight: 700; margin-bottom: 6px; }

.progress-track { position: relative; }
.track-line {
    position: absolute;
    top: 11px;
    left: 11px;
    right: 11px;
    height: 3px;
    background: var(--ss-border);
    border-radius: 2px;
    z-index: 0;
}
.track-fill {
    height: 100%;
    background: var(--ss-primary);
    border-radius: 2px;
    transition: width .6s ease;
}
.track-steps {
    position: relative;
    display: flex;
    justify-content: space-between;
    z-index: 1;
}
.track-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}
.step-dot {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--ss-card);
    border: 3px solid var(--ss-border);
    transition: border-color var(--ss-transition), background var(--ss-transition);
}
.track-step.done .step-dot {
    border-color: var(--ss-primary);
    background: var(--ss-primary);
}
.track-step.active .step-dot {
    border-color: var(--ss-primary);
    background: var(--ss-card);
    box-shadow: 0 0 0 3px var(--ss-primary-mid);
}
.step-label {
    font-size: .7rem;
    color: var(--ss-muted);
    font-weight: 500;
    white-space: nowrap;
}
.track-step.done .step-label, .track-step.active .step-label { color: var(--ss-primary); font-weight: 600; }

.payment-list { display: flex; flex-direction: column; gap: 10px; }
.payment-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border: 1px solid var(--ss-border);
    border-radius: var(--ss-radius-sm);
    transition: background var(--ss-transition);
}
.payment-item:hover { background: var(--ss-primary-light); }
 
.payment-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.payment-icon--bpjs    { background: #dcfce7; color: #15803d; }
.payment-icon--mandiri { background: #dbeafe; color: #1d4ed8; }
 
.payment-label { font-size: .875rem; font-weight: 600; }
 

@media (max-width: 900px) {
    .main-grid { grid-template-columns: 1fr; }
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 500px) {
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
    .greeting-title { font-size: 1.2rem; }
    .dash-topbar { flex-direction: column; gap: 12px; }
}
</style>
    