@extends('layouts.app')

@section('title', 'Dashboard Dokter - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">

    <div class="dash-main">
        <div class="dash-content">

            <h2>Selamat datang, {{ $user->nama }}</h2>
            <p>Spesialis: {{ $dokter->spesialis }}</p>

            {{-- Statistik --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <span>Total Resep</span>
                    <strong>{{ $statistik['total_resep'] }}</strong>
                </div>
                <div class="stat-card">
                    <span>Menunggu</span>
                    <strong>{{ $statistik['menunggu'] }}</strong>
                </div>
                <div class="stat-card">
                    <span>Diproses</span>
                    <strong>{{ $statistik['diproses'] }}</strong>
                </div>
                <div class="stat-card">
                    <span>Selesai</span>
                    <strong>{{ $statistik['selesai'] }}</strong>
                </div>
            </div>

            {{-- Resep Terbaru --}}
            <h3>Resep Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Resep</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Jumlah Obat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resepTerbaru as $resep)
                    <tr>
                        <td>{{ $resep->id_resep }}</td>
                        <td>{{ $resep->pasien->user->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($resep->tanggal)->isoFormat('D MMM Y') }}</td>
                        <td>{{ $resep->details->count() }} obat</td>
                        <td>{{ $resep->status }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Belum ada resep.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

<script src="{{ asset('js/dashboardDokter.js') }}"></script>
</div>
@endsection