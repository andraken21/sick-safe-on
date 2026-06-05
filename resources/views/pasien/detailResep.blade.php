@extends('layouts.app')

@section('title', 'Detail Resep - Sick Safe ON')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/resep.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
<div class="resep-page">
    <div class="page-header">
        <div class="page-title-wrap">
            <h1>Detail Resep</h1>
            <p>RSP-{{ str_pad($detail->id_resep, 4, '0', STR_PAD_LEFT) }}</p>
        </div>
        <a href="{{ route('pasien.resep') }}" class="btn-outline-full" style="width:auto;padding:10px 16px;">Kembali</a>
    </div>

    <div class="table-card">
        <div class="table-head-row">
            <h2>{{ $detail->dokter->user->nama ?? 'Dokter belum tersedia' }}</h2>
            <span class="badge badge--{{ $detail->status === 'selesai' ? 'selesai' : ($detail->status === 'menunggu_pembayaran' ? 'tunggu' : 'proses') }}">
                {{ ucfirst(str_replace('_', ' ', $detail->status)) }}
            </span>
        </div>

        <p><strong>Tanggal:</strong> {{ optional($detail->tanggal)->format('d M Y') }}</p>
        <p><strong>Keluhan:</strong> {{ $detail->keluhan }}</p>
        <p><strong>Diagnosa:</strong> {{ $detail->diagnosa ?? '-' }}</p>
        <p><strong>Keterangan:</strong> {{ $detail->keterangan ?? '-' }}</p>

        <table class="resep-table" style="margin-top:16px;">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Kategori</th>
                    <th>Dosis</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detail->resep->resepObat ?? [] as $item)
                <tr>
                    <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                    <td>{{ $item->obat->kategori->kategori_obat ?? '-' }}</td>
                    <td>{{ $item->dosis }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format(($item->obat->harga ?? 0) * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada obat pada resep ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
