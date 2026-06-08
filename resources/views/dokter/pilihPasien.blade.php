@extends('layouts.app')

@section('title', 'Pilih Pasien - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/pilihPasien.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardDokter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pilihPasienPrioritas.css') }}">
@endpush

@section('content')
<div class="pilih-pasien-wrap">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <h2>Pilih Pasien</h2>
                <p>Pilih pasien untuk membuat resep &mdash;
                   {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- STATS STRIP (hanya 3 card: total, laki-laki, perempuan) --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon tosca"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-label">Total Pasien</div>
                <div class="stat-value">{{ $totalPasien ?? '—' }}</div>
                <div class="stat-sub">Terdaftar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon navy"><i class="bi bi-gender-male"></i></div>
            <div>
                <div class="stat-label">Laki-laki</div>
                <div class="stat-value">{{ $totalLakiLaki ?? '—' }}</div>
                <div class="stat-sub">Pasien</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pink"><i class="bi bi-gender-female"></i></div>
            <div>
                <div class="stat-label">Perempuan</div>
                <div class="stat-value">{{ $totalPerempuan ?? '—' }}</div>
                <div class="stat-sub">Pasien</div>
            </div>
        </div>
    </div>

    {{--
        KARTU PRIORITAS JENIS PASIEN
        Dokter memilih apakah akan mendahulukan pasien Mandiri atau BPJS.
        Pilihan ini hanya sebagai filter tampilan tabel di bawah,
        bukan mengubah data di database.
    --}}
    <div class="priority-section">
        <div class="priority-label">
            <i class="bi bi-funnel-fill"></i>
            Tampilkan Antrian Prioritas:
        </div>
        <div class="priority-cards">
            <a href="{{ route('dokter.pilih.pasien', array_merge(request()->except('prioritas'), ['prioritas' => 'mandiri'])) }}"
               class="priority-card {{ request('prioritas') === 'mandiri' ? 'active' : '' }}">
                <div class="pcard-icon mandiri">
                    <i class="bi bi-person-fill-check"></i>
                </div>
                <div class="pcard-body">
                    <div class="pcard-title">Pasien Mandiri</div>
                    <div class="pcard-sub">Tidak menggunakan BPJS</div>
                </div>
                <div class="pcard-check"><i class="bi bi-check-circle-fill"></i></div>
            </a>

            <a href="{{ route('dokter.pilih.pasien', array_merge(request()->except('prioritas'), ['prioritas' => 'bpjs'])) }}"
               class="priority-card {{ request('prioritas') === 'bpjs' ? 'active' : '' }}">
                <div class="pcard-icon bpjs">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
                <div class="pcard-body">
                    <div class="pcard-title">Pasien BPJS</div>
                    <div class="pcard-sub">Menggunakan kartu BPJS</div>
                </div>
                <div class="pcard-check"><i class="bi bi-check-circle-fill"></i></div>
            </a>

            @if(request('prioritas'))
            <a href="{{ route('dokter.pilih.pasien', request()->except('prioritas')) }}"
               class="priority-card reset-card">
                <div class="pcard-icon reset">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="pcard-body">
                    <div class="pcard-title">Tampilkan Semua</div>
                    <div class="pcard-sub">Reset prioritas</div>
                </div>
            </a>
            @endif
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-header">
            <h3>
                Daftar Pasien
                @if(request('prioritas') === 'mandiri')
                    <span class="header-badge mandiri-badge">Mandiri</span>
                @elseif(request('prioritas') === 'bpjs')
                    <span class="header-badge bpjs-badge">BPJS</span>
                @endif
            </h3>
            <span>
                Menampilkan
                {{ isset($pasiens) ? ($pasiens->firstItem() ?? 0) : 0 }}–{{ isset($pasiens) ? ($pasiens->lastItem() ?? 0) : 0 }}
                dari {{ isset($pasiens) ? $pasiens->total() : 0 }} pasien
            </span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>No. BPJS</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Riwayat Penyakit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($pasiens)
                        @forelse($pasiens as $index => $pasien)
                        @php
                            $avClass = ['av-1','av-2','av-3'][$index % 3];
                            $inisial = strtoupper(substr($pasien->user?->nama ?? '?', 0, 2));
                            $isBpjs  = !empty($pasien->no_bpjs);
                        @endphp
                        <tr>
                            <td>
                                <div class="patient-name-cell">
                                    <div class="patient-avatar {{ $avClass }}">{{ $inisial }}</div>
                                    <div>
                                        <div class="patient-fullname">{{ $pasien->user?->nama ?? '-' }}</div>
                                        <div class="patient-id">#PAT-{{ str_pad($pasien->id_pasien, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($isBpjs)
                                    <span class="badge badge-bpjs">
                                        <i class="bi bi-shield-fill-check"></i>
                                        {{ $pasien->no_bpjs }}
                                    </span>
                                @else
                                    <span class="badge badge-mandiri">
                                        <i class="bi bi-person-fill-check"></i>
                                        Mandiri
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($pasien->user?->jenis_kelamin == 'Laki-laki')
                                    <span class="badge badge-laki"><i class="bi bi-gender-male"></i> Laki-laki</span>
                                @else
                                    <span class="badge badge-perempuan"><i class="bi bi-gender-female"></i> Perempuan</span>
                                @endif
                            </td>
                            <td>{{ optional($pasien->user?->tanggal_lahir)->format('d M Y') ?? '-' }}</td>
                            <td>{{ $pasien->riwayat_penyakit ?? '-' }}</td>
                            <td>
                                <a href="{{ route('dokter.resep.create', ['id_pasien' => $pasien->id_pasien]) }}" class="btn-pilih">
                                    <i class="bi bi-cursor-fill"></i> Pilih
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-people"></i></div>
                                    <h4>Tidak Ada Pasien Ditemukan</h4>
                                    <p>Belum ada pasien yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-people"></i></div>
                                    <h4>Data Pasien Belum Tersedia</h4>
                                    <p>Hubungkan halaman ini dengan controller untuk menampilkan data.</p>
                                </div>
                            </td>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @isset($pasiens)
            @if($pasiens->hasPages())
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Halaman {{ $pasiens->currentPage() }} dari {{ $pasiens->lastPage() }}
                </div>
                <div class="pagination-links">
                    @if($pasiens->onFirstPage())
                        <span class="disabled"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $pasiens->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    @for($i = 1; $i <= $pasiens->lastPage(); $i++)
                        @if($i == $pasiens->currentPage())
                            <span class="active-page">{{ $i }}</span>
                        @else
                            <a href="{{ $pasiens->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($pasiens->hasMorePages())
                        <a href="{{ $pasiens->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                    @else
                        <span class="disabled"><i class="bi bi-chevron-right"></i></span>
                    @endif
                </div>
            </div>
            @endif
        @endisset

    </div>
    {{-- /table-card --}}

</div>
@endsection