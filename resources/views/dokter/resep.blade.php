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

    @php
        $namaPasien = $pasien->user->nama ?? 'Pasien';
        $inisialPasien = strtoupper(substr($namaPasien, 0, 2));
        $tanggalLahir = $pasien->user?->tanggal_lahir;
        $umur = $tanggalLahir ? $tanggalLahir->age . ' thn' : '-';
    @endphp

    <div class="patient-info-card">
        <div class="patient-big-avatar">{{ $inisialPasien }}</div>
        <div class="patient-info-text">
            <div class="pat-name">{{ $namaPasien }}</div>
            <div class="pat-meta">
                <div class="pat-meta-item">
                    <i class="bi bi-credit-card-2-front"></i> BPJS: {{ $pasien->no_bpjs ?? '-' }}
                </div>
                <div class="pat-meta-item">
                    <i class="bi bi-gender-male"></i> {{ $pasien->user->jenis_kelamin ?? '-' }}
                </div>
                <div class="pat-meta-item">
                    <i class="bi bi-calendar3"></i> {{ optional($tanggalLahir)->format('d M Y') ?? '-' }} ({{ $umur }})
                </div>
                <div class="pat-meta-item">
                    <i class="bi bi-telephone"></i> {{ $pasien->user->no_telp ?? '-' }}
                </div>
            </div>
        </div>
        <div class="patient-info-right">
            <span class="info-badge">#PAT-{{ str_pad($pasien->id_pasien, 4, '0', STR_PAD_LEFT) }}</span>
            <div class="kode-resep-badge">
                <div class="label">Kode Resep</div>
                <div class="kode">RSP-{{ date('Y') }}-{{ str_pad(rand(1,9999), 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <form id="formResep" method="POST" action="{{ route('dokter.resep.store') }}">
        @csrf
        <input type="hidden" name="id_pasien"  value="{{ $pasien->id_pasien }}">
        <input type="hidden" name="kode_resep" value="RSP-{{ date('Y') }}-0001">
        <input type="hidden" name="status"     value="terkirim" id="inputStatus">

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
                                <label>Kode Diagnosa (ICD-10)</label>
                                <input type="text" name="kode_diagnosa" placeholder="Cth: J00, A09" value="{{ old('kode_diagnosa') }}">
                                <span class="field-hint">Opsional</span>
                            </div>
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
                                    <th class="col-dosis">Dosis</th>
                                    <th class="col-jml">Jumlah</th>
                                    <th class="col-sat">Satuan</th>
                                    <th class="col-aturan">Aturan Pakai</th>
                                    <th class="col-ket">Keterangan</th>
                                    <th class="col-del"></th>
                                </tr>
                            </thead>
                            <tbody id="obatTableBody"></tbody>
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
                            <span class="rk-value" id="rkDiagnosa"
                                  style="color:#6a8fa5;font-weight:400;font-style:italic">Belum diisi</span>
                        </div>
                        <div class="ringkasan-obat-count">
                            <span class="label"><i class="bi bi-capsule-pill"></i> Jenis Obat</span>
                            <span class="count" id="rkObatCount">0</span>
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

                {{-- Alergi --}}
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="icon" style="background:#FFEBEA;color:#D93025">
                            <i class="bi bi-shield-exclamation"></i>
                        </div>
                        <h3>Alergi Obat</h3>
                    </div>
                    <div class="section-card-body" style="padding:14px;">
                        <div class="alergi-box">
                            <div class="al-title"><i class="bi bi-exclamation-octagon-fill"></i> Perhatian</div>
                            <div class="al-empty">Tidak ada riwayat alergi tercatat.</div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="action-card">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-send-fill"></i> Kirim ke Apoteker
                    </button>
                    <button type="button" class="btn-draft" id="btnDraft">
                        <i class="bi bi-floppy-fill"></i> Simpan sebagai Draft
                    </button>
                    <a href="{{ route('dokter.pilih.pasien') }}" class="btn-batal">
                        <i class="bi bi-x-circle"></i> Batalkan
                    </a>
                </div>

            </div>
            {{-- /KOLOM KANAN --}}

        </div>
    </form>

</div>

<div id="toast"><i class="bi bi-check-circle-fill"></i> <span id="toastMsg"></span></div>

@endsection

@push('scripts')
<script>
window.obatOptions = @json($obatList->map(fn ($obat) => [
    'id' => $obat->id_obat,
    'nama' => $obat->nama_obat,
    'stok' => $obat->stok,
    'harga' => (int) $obat->harga,
])->values());
</script>
<script src="{{ asset('js/resepDokter.js') }}"></script>
@endpush
