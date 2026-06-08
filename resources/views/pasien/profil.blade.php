@extends('layouts.app')

@section('title', 'Pembayaran — Sick Safe ON')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/profil.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboardPasien.css') }}">
@endpush

@section('content')
<div class="profil-page">

    <h1>Profil Saya</h1>
    <p class="sub">Kelola informasi akun Anda</p>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    {{-- Avatar card --}}
    <div class="profil-avatar-wrap">
        <div class="profil-avatar">
            {{ strtoupper(substr($User->nama ?? 'U', 0, 2)) }}
        </div>
        <div class="profil-avatar-info">
            <p>{{ auth()->user()->nama }}</p>
            <span>{{ auth()->user()->email }} • Pasien</span>
        </div>
    </div>

    {{-- Form update --}}
    <form action="{{ route('pasien.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="profil-card">
            <h2>Informasi Pribadi</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}" required>
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" value="{{ auth()->user()->nik }}" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', auth()->user()->no_telp) }}" placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" value="{{ auth()->user()->tanggal_lahir }}" readonly>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <input type="text" value="{{ auth()->user()->jenis_kelamin }}" readonly>
                </div>
                <div class="form-group full">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="2">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                </div>
            </div>
        </div>

        <div class="profil-card">
            <h2>BPJS Kesehatan</h2>
            <div class="form-group">
                <label>No. BPJS</label>
                <div class="bpjs-input-wrap">
                    <i class="fas fa-shield-alt bpjs-icon"></i>
                    <input type="text" name="no_bpjs" maxlength="13"
                           placeholder="Masukkan nomor BPJS"
                           value="{{ old('no_bpjs', auth()->user()->pasien->no_bpjs ?? '') }}">
                </div>
            </div>
        </div>

        <div class="profil-card">
            <h2>Ubah Password</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Password Baru <span style="color:#7a8499;font-weight:400;">(kosongkan jika tidak ingin ubah)</span></label>
                    <input type="password" name="password" placeholder="Min. 8 karakter">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                </div>
            </div>
        </div>

        <div class="btn-row">
            <button type="submit" class="btn-save">Simpan Perubahan</button>
        </div>
    <br></form>

    {{-- Danger zone --}}
    <div class="danger-zone">
        <h2>⚠️ Hapus Akun</h2>
        <p>Setelah akun dihapus, semua data Anda akan hilang permanen dan tidak dapat dipulihkan.</p>
        <button class="btn-delete" id="btnHapusAkun">Hapus Akun Saya</button>
    </div>

</div>

{{-- Modal konfirmasi hapus --}}
<div class="modal-hapus" id="modalHapus">
    <div class="modal-hapus-box">
        <div class="icon">🗑️</div>
        <h3>Hapus Akun?</h3>
        <p>Tindakan ini tidak dapat dibatalkan. Semua data resep dan riwayat pembayaran Anda akan hilang.</p>
        <div class="modal-hapus-btns">
            <button class="btn-batal-hapus" id="btnBatalHapus">Batal</button>
            <form action="{{ route('pasien.profil.delete') }}" method="POST" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-konfirm-hapus" style="width:100%;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnHapusAkun').addEventListener('click', () => {
        document.getElementById('modalHapus').classList.add('open');
    });
    document.getElementById('btnBatalHapus').addEventListener('click', () => {
        document.getElementById('modalHapus').classList.remove('open');
    });
</script>
@endsection