@extends('layouts.app')

@section('title', 'Pilih Pasien - Sick Safe ON')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/pilihPasien.css') }}">
@endpush

@section('content')
<div class="pilih-pasien-wrap">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <h2>Pilih Pasien</h2>
                <p>Pilih pasien untuk membuat atau melanjutkan resep &mdash;
                   {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- STATS STRIP --}}
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
            <div class="stat-icon blue"><i class="bi bi-check2-circle"></i></div>
            <div>
                <div class="stat-label">Status Aktif</div>
                <div class="stat-value">{{ $totalAktif ?? '—' }}</div>
                <div class="stat-sub" style="color:var(--blue)">Pasien aktif</div>
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

    {{-- TOOLBAR: SEARCH & FILTER --}}
    <form method="GET" action="{{ route('dokter.pilih-pasien') }}">
        <div class="toolbar">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search"
                       placeholder="Cari nama, No. BPJS, atau riwayat penyakit..."
                       value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <select name="jenis_kelamin" class="filter-select">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="Laki-laki"  {{ request('jenis_kelamin') == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan"  {{ request('jenis_kelamin') == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                </select>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
            @if(request()->hasAny(['search','jenis_kelamin','status']))
                <a href="{{ route('dokter.pilih-pasien') }}" class="btn-reset">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            @endif
        </div>
    </form>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-header">
            <h3>Daftar Pasien</h3>
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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($pasiens)
                        @forelse($pasiens as $index => $pasien)
                        @php
                            $avClass = ['av-1','av-2','av-3'][$index % 3];
                            $inisial = strtoupper(substr($pasien->user?->nama ?? '?', 0, 2));
                        @endphp
                        <tr>
                            <td>
                                <div class="patient-name-cell">
                                    <div class="patient-avatar {{ $avClass }}">{{ $inisial }}</div>
                                    <div>
                                        <div class="patient-fullname">{{ $pasien->user?->nama ?? '-' }}</div>
                                        <div class="patient-id">#PAT-{{ str_pad($pasien->ID_Pasien, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $pasien->No_BPJS ?? '-' }}</td>
                            <td>
                                @if($pasien->Jenis_kelamin == 'Laki-laki')
                                    <span class="badge badge-laki"><i class="bi bi-gender-male"></i> Laki-laki</span>
                                @else
                                    <span class="badge badge-perempuan"><i class="bi bi-gender-female"></i> Perempuan</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pasien->Tanggal_Lahir)->format('d M Y') }}</td>
                            <td>{{ $pasien->Riwayat_Penyakit ?? '-' }}</td>
                            <td>
                                @if(($pasien->user?->status ?? '') == 'aktif')
                                    <span class="badge badge-aktif"><i class="bi bi-circle-fill"></i> Aktif</span>
                                @else
                                    <span class="badge badge-nonaktif"><i class="bi bi-circle"></i> Non-aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn-detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('dokter.resep.create', $pasien->ID_Pasien) }}" class="btn-pilih">
                                    <i class="bi bi-cursor-fill"></i> Pilih
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-people"></i></div>
                                    <h4>Tidak Ada Pasien Ditemukan</h4>
                                    <p>Coba ubah filter atau kata kunci pencarian.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="7">
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

@push('scripts')
<script src="{{ asset('js/pilihPasien.js') }}"></script>
@endpush