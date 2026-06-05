@extends('layouts.app')

@section('title', 'Antrian Dokter - Sick Safe ON')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/antrian.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">
    <div class="page-header">
        <h1>Antrian Pasien</h1>
        <p>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</p>
    </div>

    <div class="dash-card">
        <div class="dash-card-header">
            <div>
                <div class="dash-card-title">Daftar Antrian</div>
                <div class="dash-card-sub">{{ $dokter->user->nama ?? Auth::user()->nama }}</div>
            </div>
            <form method="GET" action="{{ route('dokter.antrian') }}">
                <input type="date" name="tanggal" value="{{ $tanggal }}">
                <button type="submit" class="btn-link">Filter</button>
            </form>
        </div>

        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrianList as $antrian)
                        <tr>
                            <td>#{{ $antrian->nomor_antrian }}</td>
                            <td>{{ $antrian->pasien->user->nama ?? '-' }}</td>
                            <td>{{ optional($antrian->tanggal)->format('d M Y') }}</td>
                            <td><span class="status-badge status-success">{{ ucfirst($antrian->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;">Tidak ada antrian pada tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($antrianList->hasPages())
            <div style="padding:16px;">
                {{ $antrianList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
