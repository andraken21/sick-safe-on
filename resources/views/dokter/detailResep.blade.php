@extends('layouts.app')

@section('title', 'Detail Resep - Sick Safe ON')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/daftarResep.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="daftar-resep-wrap">
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <h2>Detail Resep</h2>
                <p>RSP-{{ str_pad($detail->id_resep, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <a href="{{ route('dokter.resep') }}" class="btn-new">Kembali</a>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3>{{ $detail->pasien->user->nama ?? 'Pasien' }}</h3>
            <span class="status-badge {{ $detail->status === 'selesai' ? 's-selesai' : ($detail->status === 'diproses' ? 's-diproses' : 's-validasi') }}">
                {{ ucfirst(str_replace('_', ' ', $detail->status)) }}
            </span>
        </div>

        <div style="padding:18px;">
            <p><strong>Tanggal:</strong> {{ optional($detail->tanggal)->format('d M Y') }}</p>
            <p><strong>Keluhan:</strong> {{ $detail->keluhan }}</p>
            <p><strong>Diagnosa:</strong> {{ $detail->diagnosa }}</p>
            <p><strong>Keterangan:</strong> {{ $detail->keterangan ?? '-' }}</p>
        </div>

        <div class="table-wrap">
            <table>
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
                            <td colspan="5" style="text-align:center;">Tidak ada obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
