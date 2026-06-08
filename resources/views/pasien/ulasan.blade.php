@extends('layouts.app')

@section('title', 'Ulasan Dokter — Sick Safe ON')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
<style>
.ulasan-page { max-width: 640px; margin: 0 auto; padding: 8px 0 40px; }
.ulasan-page h1 { font-size: 1.4rem; font-weight: 800; margin-bottom: 4px; }
.ulasan-page .sub { font-size: .85rem; color: #7a8499; margin-bottom: 24px; }

.ulasan-card {
    background: #fff; border: 1px solid #e4e9f0;
    border-radius: 14px; padding: 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}

.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: .83rem; font-weight: 600; margin-bottom: 6px; }
.form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid #e4e9f0; border-radius: 8px;
    font-family: inherit; font-size: .85rem; outline: none;
    transition: border-color .2s; box-sizing: border-box;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: #FFB3CD;
}

/* Bintang */
.star-group { display: flex; gap: 8px; flex-direction: row-reverse; justify-content: flex-end; }
.star-group input { display: none; }
.star-group label {
    font-size: 2rem; color: #e4e9f0; cursor: pointer;
    transition: color .15s; padding: 0; border: none; background: none;
    width: auto;
}
.star-group input:checked ~ label,
.star-group label:hover,
.star-group label:hover ~ label { color: #FFB3CD; }

.btn-kirim {
    width: 100%; padding: 13px;
    background: #FFB3CD; color: #fff; border: none;
    border-radius: 8px; font-size: .9rem; font-weight: 700;
    font-family: inherit; cursor: pointer;
    transition: opacity .2s;
}
.btn-kirim:hover { opacity: .85; }

.alert-success {
    background: #DCFCE7; color: #15803d;
    border-radius: 8px; padding: 12px 16px;
    font-size: .85rem; font-weight: 600; margin-bottom: 18px;
}

.riwayat-ulasan { margin-top: 32px; }
.riwayat-ulasan h2 { font-size: 1rem; font-weight: 700; margin-bottom: 14px; }
.ulasan-item {
    background: #fff; border: 1px solid #e4e9f0;
    border-radius: 10px; padding: 16px 18px; margin-bottom: 12px;
}
.ulasan-item-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
.ulasan-dokter { font-weight: 700; font-size: .9rem; }
.ulasan-stars { color: #FFB3CD; font-size: 1rem; }
.ulasan-resep { font-size: .75rem; color: #7a8499; margin-bottom: 6px; }
.ulasan-komen { font-size: .83rem; color: #1a202c; }
</style>
@endpush

@section('content')
<div class="ulasan-page">
    <h1>Ulasan Dokter</h1>
    <p class="sub">Bagikan pengalaman Anda setelah konsultasi</p>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    <div class="ulasan-card">
        <form action="{{ route('pasien.ulasan.simpan') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Dokter</label>
                <input type="text" name="nama_dokter" placeholder="Contoh: Dr. Budi Santoso"
                       value="{{ old('nama_dokter') }}" required>
            </div>

            <div class="form-group">
                <label>Nomor Resep</label>
                <input type="text" name="nomor_resep" placeholder="Contoh: RSP-2026-0051"
                       value="{{ old('nomor_resep') }}" required>
            </div>

            <div class="form-group">
                <label>Rating</label>
                <div class="star-group">
                    <input type="radio" name="bintang" id="s5" value="5"><label for="s5">★</label>
                    <input type="radio" name="bintang" id="s4" value="4"><label for="s4">★</label>
                    <input type="radio" name="bintang" id="s3" value="3"><label for="s3">★</label>
                    <input type="radio" name="bintang" id="s2" value="2"><label for="s2">★</label>
                    <input type="radio" name="bintang" id="s1" value="1"><label for="s1">★</label>
                </div>
            </div>

            <div class="form-group">
                <label>Komentar <span style="color:#7a8499;font-weight:400;">(opsional)</span></label>
                <textarea name="komentar" rows="3"
                          placeholder="Ceritakan pengalaman Anda...">{{ old('komentar') }}</textarea>
            </div>

            <button type="submit" class="btn-kirim">Kirim Ulasan</button>
        </form>
    </div>

    {{-- Riwayat ulasan --}}
    @php
        $pasienId = \DB::table('pasien')->where('ID_User', Auth::id())->value('ID_Pasien');
        $riwayat  = \DB::table('ulasan')->where('ID_Pasien', $pasienId)->orderByDesc('created_at')->get();
    @endphp

    @if($riwayat->count())
    <div class="riwayat-ulasan">
        <h2>Ulasan Saya</h2>
        @foreach($riwayat as $u)
        <div class="ulasan-item">
            <div class="ulasan-item-top">
                <span class="ulasan-dokter">{{ $u->nama_dokter }}</span>
                <span class="ulasan-stars">{{ str_repeat('★', $u->bintang) }}{{ str_repeat('☆', 5 - $u->bintang) }}</span>
            </div>
            <div class="ulasan-resep">Resep: {{ $u->nomor_resep }} • {{ \Carbon\Carbon::parse($u->created_at)->format('d M Y') }}</div>
            @if($u->komentar)
                <div class="ulasan-komen">{{ $u->komentar }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection