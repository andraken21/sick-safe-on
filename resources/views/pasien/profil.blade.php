@extends('layouts.app')

@section('title', 'Profil Pasien - Sick Safe ON')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
<div class="pasien-dashboard">
    <div class="dash-topbar">
        <div class="dash-greeting">
            <h1 class="greeting-title">Profil Pasien</h1>
            <p class="greeting-sub">Perbarui data akun dan informasi kesehatan Anda.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="section-card" style="border-color:#86efac;color:#15803d;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="section-card" style="border-color:#fca5a5;color:#b91c1c;">{{ session('error') }}</div>
    @endif

    <div class="main-grid">
        <div class="section-card">
            <div class="section-head">
                <h2 class="section-title">Data Diri</h2>
            </div>
            <form method="POST" action="{{ route('pasien.profil.update') }}">
                @csrf
                <div class="detail-item"><span class="detail-label">Nama</span><input class="filter-select" name="nama" value="{{ old('nama', $pasien->user->nama) }}"></div>
                <div class="detail-item"><span class="detail-label">No. Telepon</span><input class="filter-select" name="no_telp" value="{{ old('no_telp', $pasien->user->no_telp) }}"></div>
                <div class="detail-item"><span class="detail-label">Tanggal Lahir</span><input class="filter-select" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($pasien->user->tanggal_lahir)->format('Y-m-d')) }}"></div>
                <div class="detail-item">
                    <span class="detail-label">Jenis Kelamin</span>
                    <select class="filter-select" name="jenis_kelamin">
                        <option value="">Pilih</option>
                        <option value="Laki-laki" @selected(old('jenis_kelamin', $pasien->user->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                        <option value="Perempuan" @selected(old('jenis_kelamin', $pasien->user->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                    </select>
                </div>
                <div class="detail-item"><span class="detail-label">Alamat</span><textarea class="filter-select" name="alamat">{{ old('alamat', $pasien->user->alamat) }}</textarea></div>
                <div class="detail-item"><span class="detail-label">No. BPJS</span><input class="filter-select" name="no_bpjs" value="{{ old('no_bpjs', $pasien->no_bpjs) }}"></div>
                <div class="detail-item"><span class="detail-label">Riwayat Penyakit</span><textarea class="filter-select" name="riwayat_penyakit">{{ old('riwayat_penyakit', $pasien->riwayat_penyakit) }}</textarea></div>
                <button type="submit" class="btn-outline-full">Simpan Profil</button>
            </form>
        </div>

        <div class="section-card">
            <div class="section-head">
                <h2 class="section-title">Ubah Password</h2>
            </div>
            <form method="POST" action="{{ route('pasien.profil.password') }}">
                @csrf
                <div class="detail-item"><span class="detail-label">Password Lama</span><input class="filter-select" type="password" name="password_lama"></div>
                <div class="detail-item"><span class="detail-label">Password Baru</span><input class="filter-select" type="password" name="password_baru"></div>
                <div class="detail-item"><span class="detail-label">Konfirmasi Password</span><input class="filter-select" type="password" name="password_baru_confirmation"></div>
                <button type="submit" class="btn-outline-full">Ubah Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
