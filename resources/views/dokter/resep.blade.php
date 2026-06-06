@extends('layouts.app')

@section('title', 'Buat Resep - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/resepDokter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
@endpush

@section('content')
<div class="resep-wrap">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <h2>Buat Resep</h2>
                <p>Isi formulir resep untuk pasien yang dipilih</p>
            </div>
            <a href="{{ route('dokter.pilih.pasien') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Ganti Pasien
            </a>
        </div>
    </div>

    {{-- Flash error dari controller (misal stok kurang) --}}
    @if(session('error'))
    <div style="padding:12px 16px;background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;color:#b91c1c;font-size:.85rem;font-weight:600;margin-bottom:16px;">
        ❌ {{ session('error') }}
    </div>
    @endif
    @if($errors->any())
    <div style="padding:12px 16px;background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;color:#b91c1c;font-size:.85rem;margin-bottom:16px;">
        <strong>Kesalahan validasi:</strong>
        <ul style="margin:4px 0 0 16px;">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    @php
        $namaPasien    = $pasien->user->nama ?? 'Pasien';
        $inisialPasien = strtoupper(substr($namaPasien, 0, 2));
        $tanggalLahir  = $pasien->user?->tanggal_lahir;
        $umur          = $tanggalLahir ? \Carbon\Carbon::parse($tanggalLahir)->age . ' thn' : '-';
    @endphp

    {{-- KARTU INFO PASIEN --}}
    <div class="patient-info-card">
        <div class="patient-big-avatar">{{ $inisialPasien }}</div>
        <div class="patient-info-text">
            <div class="pat-name">{{ $namaPasien }}</div>
            <div class="pat-meta">
                <div class="pat-meta-item"><i class="bi bi-credit-card-2-front"></i> BPJS: {{ $pasien->no_bpjs ?? '-' }}</div>
                <div class="pat-meta-item"><i class="bi bi-gender-male"></i> {{ $pasien->user->jenis_kelamin ?? '-' }}</div>
                <div class="pat-meta-item"><i class="bi bi-calendar3"></i> {{ optional($tanggalLahir)->format('d M Y') ?? '-' }} ({{ $umur }})</div>
                <div class="pat-meta-item"><i class="bi bi-telephone"></i> {{ $pasien->user->no_telp ?? '-' }}</div>
            </div>
        </div>
        <div class="patient-info-right">
            <span class="info-badge">#PAT-{{ str_pad($pasien->id_pasien, 4, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    {{--
        FORM RESEP
        POST → route('dokter.resep.store')
        Controller: storeResep()
        Field yang divalidasi:
          id_pasien, keluhan, diagnosa, keterangan (optional)
          obat[*][id_obat], obat[*][jumlah], obat[*][dosis]
    --}}
    <form id="formResep" method="POST" action="{{ route('dokter.resep.store') }}">
        @csrf
        <input type="hidden" name="id_pasien" value="{{ $pasien->id_pasien }}">

        <div class="form-grid">

            {{-- ─── KOLOM KIRI ─── --}}
            <div>

                {{-- Keluhan & Diagnosa --}}
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="icon icon-tosca"><i class="bi bi-clipboard2-pulse-fill"></i></div>
                        <h3>Keluhan &amp; Diagnosa</h3>
                    </div>
                    <div class="section-card-body">
                        <div class="form-group" style="margin-bottom:14px">
                            <label>Keluhan Utama <span class="req">*</span></label>
                            <textarea name="keluhan" placeholder="Tuliskan keluhan yang disampaikan pasien..." required>{{ old('keluhan') }}</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Diagnosa <span class="req">*</span></label>
                                <input type="text" name="diagnosa" id="inputDiagnosa"
                                       placeholder="Cth: Infeksi Saluran Napas"
                                       value="{{ old('diagnosa') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan Tambahan</label>
                            <textarea name="keterangan" placeholder="Catatan untuk apoteker atau pasien..." style="min-height:64px">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Daftar Obat --}}
                {{--
                    Setiap baris obat dikirim sebagai array:
                      obat[0][id_obat], obat[0][jumlah], obat[0][dosis]
                      obat[1][id_obat], obat[1][jumlah], obat[1][dosis]  dst.
                    Sesuai validasi controller: 'obat.*.id_obat', 'obat.*.jumlah', 'obat.*.dosis'
                --}}
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="icon icon-blue"><i class="bi bi-capsule-pill"></i></div>
                        <h3>Daftar Obat</h3>
                    </div>
                    <div class="obat-table-wrap">
                        <table class="obat-table">
                            <thead>
                                <tr>
                                    <th class="col-no">#</th>
                                    <th class="col-nama">Nama Obat</th>
                                    <th class="col-dosis">Dosis / Aturan Pakai</th>
                                    <th class="col-jml">Jumlah</th>
                                    <th class="col-stok">Stok</th>
                                    <th class="col-harga">Harga Sat.</th>
                                    <th class="col-del"></th>
                                </tr>
                            </thead>
                            <tbody id="obatTableBody">
                                {{-- Diisi oleh resepDokter.js --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="obat-footer">
                        <button type="button" class="btn-add-obat" id="btnAddObat">
                            <i class="bi bi-plus-circle"></i> Tambah Obat
                        </button>
                        <span class="obat-count-badge">Total: <span id="obatCountDisplay">0</span> item</span>
                    </div>
                </div>

            </div>
            {{-- /KOLOM KIRI --}}

            {{-- ─── KOLOM KANAN ─── --}}
            <div class="side-panel">

                {{-- Ringkasan Resep --}}
                <div class="ringkasan-card">
                    <div class="ringkasan-header">
                        <i class="bi bi-receipt"></i>
                        <h3>Ringkasan Resep</h3>
                    </div>
                    <div class="ringkasan-body">
                        <div class="ringkasan-row">
                            <span class="rk-label">Pasien</span>
                            <span class="rk-value">{{ $namaPasien }}</span>
                        </div>
                        <div class="ringkasan-row">
                            <span class="rk-label">Dokter</span>
                            <span class="rk-value">{{ Auth::user()->nama }}</span>
                        </div>
                        <div class="ringkasan-row">
                            <span class="rk-label">Tanggal</span>
                            <span class="rk-value">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
                        </div>
                        <div class="ringkasan-row">
                            <span class="rk-label">Diagnosa</span>
                            <span class="rk-value" id="rkDiagnosa" style="color:#6a8fa5;font-style:italic">Belum diisi</span>
                        </div>
                        <div class="ringkasan-obat-count">
                            <span class="label"><i class="bi bi-capsule-pill"></i> Jenis Obat</span>
                            <span class="count" id="rkObatCount">0</span>
                        </div>
                        <div class="ringkasan-row" style="margin-top:8px;font-weight:700;">
                            <span class="rk-label">Est. Total</span>
                            <span class="rk-value" id="rkTotal" style="color:#0e7490;">Rp 0</span>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Penyakit --}}
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="icon icon-navy"><i class="bi bi-clock-history"></i></div>
                        <h3>Riwayat Penyakit</h3>
                    </div>
                    <div class="section-card-body" style="padding:14px;">
                        <div class="riwayat-box">
                            <div class="rw-title"><i class="bi bi-exclamation-triangle-fill"></i> Perhatian</div>
                            <div class="rw-text">{{ $pasien->riwayat_penyakit ?? 'Tidak ada riwayat penyakit tercatat.' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="action-card">
                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <i class="bi bi-send-fill"></i> Kirim ke Apoteker
                    </button>
                    <a href="{{ route('dokter.pilih.pasien') }}" class="btn-batal">
                        <i class="bi bi-x-circle"></i> Batalkan
                    </a>
                </div>

            </div>
            {{-- /KOLOM KANAN --}}

        </div>
    </form>

    <div id="toast"><i class="bi bi-check-circle-fill"></i> <span id="toastMsg"></span></div>

</div>
@endsection

@push('scripts')
<script>
@php
    $obatJson = $obatList->map(function ($o) {
        return [
            'id'    => $o->id_obat,
            'nama'  => $o->nama_obat,
            'stok'  => $o->stok,
            'harga' => (int) $o->harga,
        ];
    })->values();
@endphp
window.obatOptions = {!! json_encode($obatJson) !!};
</script>
<script src="{{ asset('js/resepDokter.js') }}"></script>
@endpush