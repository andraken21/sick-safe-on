@extends('layouts.app')

@section('title', 'Rating Dokter - Sick Safe ON')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
<div class="pasien-dashboard">
    <div class="dash-topbar">
        <div class="dash-greeting">
            <h1 class="greeting-title">Rating Dokter</h1>
            <p class="greeting-sub">Beri penilaian untuk dokter yang pernah menangani Anda.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="section-card" style="border-color:#86efac;color:#15803d;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="section-card" style="border-color:#fca5a5;color:#b91c1c;">{{ session('error') }}</div>
    @endif

    <div class="section-card">
        <div class="section-head">
            <h2 class="section-title">Dokter Selesai Menangani</h2>
        </div>

        @forelse($dokterDitangani as $dokter)
            <form method="POST" action="{{ route('pasien.rating.simpan') }}" class="payment-item" style="justify-content:space-between;margin-bottom:10px;">
                @csrf
                <input type="hidden" name="id_dokter" value="{{ $dokter->id_dokter }}">
                <span class="payment-label">{{ $dokter->user->nama ?? 'Dokter' }}</span>
                @if(in_array($dokter->id_dokter, $sudahDirating ?? []))
                    <span class="status-badge status-selesai">Sudah dirating</span>
                @else
                    <select name="rating" class="filter-select" style="width:110px;">
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                    <button type="submit" class="btn-outline-full" style="width:auto;padding:8px 14px;">Kirim</button>
                @endif
            </form>
        @empty
            <p>Belum ada dokter yang dapat dirating.</p>
        @endforelse
    </div>
</div>
@endsection
