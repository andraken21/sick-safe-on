<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;

// PUBLIC ROUTES
Route::get('/', fn() => view('homepage'));
Route::get('/register', fn() => view('auth.registrasi'));
Route::post('/register', [LoginController::class, 'register']);
Route::get('/login',  [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/forgot', fn() => view('auth.forgot'));
Route::post('/forgot-password',       [LoginController::class, 'checkEmail']);
Route::get('/reset-password/{email}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',        [LoginController::class, 'updatePassword']);
Route::post('/logout',                [LoginController::class, 'logout'])->name('logout');



// ADMIN
Route::middleware(['auth', 'role:Admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Kelola Akun Pengguna
    Route::get('/admin/kelolaAkunPengguna',           [AdminController::class, 'kelolaAkun'])->name('kelolaAkunPengguna');
    Route::get('/admin/kelolaAkunPengguna/create',    [AdminController::class, 'createAkun'])->name('admin.akun.create');
    Route::post('/admin/kelolaAkunPengguna',          [AdminController::class, 'storeAkun'])->name('admin.akun.store');
    Route::get('/admin/kelolaAkunPengguna/{id}/edit', [AdminController::class, 'editAkun'])->name('admin.akun.edit');
    Route::post('/admin/kelolaAkunPengguna/{id}',     [AdminController::class, 'updateAkun'])->name('admin.akun.update');
    Route::delete('/admin/kelolaAkunPengguna/{id}',   [AdminController::class, 'destroyAkun'])->name('admin.akun.destroy');

    // Kelola Obat & Kategori
    Route::get('/admin/kelolaDataObat',         [AdminController::class, 'kelolaObat'])->name('kelolaDataObat');
    Route::post('/admin/kelolaDataObat',        [AdminController::class, 'storeObat'])->name('admin.obat.store');
    Route::post('/admin/kelolaDataObat/{id}',   [AdminController::class, 'updateObat'])->name('admin.obat.update');
    Route::delete('/admin/kelolaDataObat/{id}', [AdminController::class, 'destroyObat'])->name('admin.obat.destroy');
    Route::post('/admin/kategori',              [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::delete('/admin/kategori/{id}',       [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');

    // Konfirmasi Pembayaran
    Route::get('/admin/konfirmasiPembayaran',              [AdminController::class, 'pembayaranPending'])->name('admin.pembayaran');
    Route::post('/admin/konfirmasiPembayaran/{id}',        [AdminController::class, 'konfirmasiPembayaran'])->name('admin.pembayaran.konfirmasi');
    Route::post('/admin/konfirmasiPembayaran/{id}/batal',  [AdminController::class, 'batalkanPembayaran'])->name('admin.pembayaran.batal');

    // Pantau Transaksi
    Route::get('/admin/pantauTransaksi', [AdminController::class, 'pantauTransaksi'])->name('pantauTransaksi');

    // Laporan & Analisis
    Route::get('/admin/laporanAnalisisData', [AdminController::class, 'laporan'])->name('laporanAnalisisData');
});



// DOKTER
Route::middleware(['auth', 'role:Dokter'])->group(function () {

    // Dashboard
    Route::get('/dokter/dashboard', [DokterController::class, 'dashboard'])->name('dokter.dashboard');

    // Step 1 — Pilih pasien (search & pilih sebelum buat resep)
    Route::get('/dokter/pilih-pasien', [DokterController::class, 'pilihPasien'])->name('dokter.pilih.pasien');

    // Step 2 — Form buat resep (menerima ?id_pasien= dari halaman pilih pasien)
    // FIX: nama route diubah dari 'dokter.daftar-resep' → 'dokter.resep.create'
    //      agar konsisten dengan konvensi resource (create = form, store = simpan)
    Route::get('/dokter/resep/create', [DokterController::class, 'daftarResep'])->name('dokter.resep.create');

    // Step 3 — Simpan resep baru
    Route::post('/dokter/resep',       [DokterController::class, 'storeResep'])->name('dokter.resep.store');

    // Daftar semua resep milik dokter (+ filter status & tanggal)
    Route::get('/dokter/resep',        [DokterController::class, 'resep'])->name('dokter.resep');

    // FIX: Tambah route detail resep — dokter perlu lihat isi obat & status tiap resep
    Route::get('/dokter/resep/{id}',   [DokterController::class, 'detailResep'])->name('dokter.resep.detail');

    // Antrian pasien hari ini
    Route::get('/dokter/antrian',      [DokterController::class, 'antrian'])->name('dokter.antrian');
});



// PASIEN
Route::middleware(['auth', 'role:Pasien'])->group(function () {

    // Dashboard
    Route::get('/pasien/dashboard', [PasienController::class, 'dashboard'])->name('pasien.dashboard');

    // Resep
    Route::get('/pasien/resep',      [PasienController::class, 'resep'])->name('pasien.resep');
    Route::get('/pasien/resep/{id}', [PasienController::class, 'detailResep'])->name('pasien.resep.detail');

    // Pembayaran
    Route::get('/pasien/pembayaran',              [PasienController::class, 'pembayaran'])->name('pasien.pembayaran');
    Route::get('/pasien/pembayaran/riwayat',      [PasienController::class, 'riwayatPembayaran'])->name('pasien.pembayaran.riwayat');
    Route::get('/pasien/pembayaran/bayar/{id}',   [PasienController::class, 'halamanBayar'])->name('pasien.pembayaran.bayar');
    Route::post('/pasien/pembayaran/proses',      [PasienController::class, 'prosesBayar'])->name('pasien.pembayaran.proses');

    // Rating
    Route::get('/pasien/rating',  [PasienController::class, 'rating'])->name('pasien.rating');
    Route::post('/pasien/rating', [PasienController::class, 'simpanRating'])->name('pasien.rating.simpan');

    // Profil
    Route::get('/pasien/profil',             [PasienController::class, 'profil'])->name('pasien.profil');
    Route::post('/pasien/profil',            [PasienController::class, 'updateProfil'])->name('pasien.profil.update');
    Route::post('/pasien/profil/password',   [PasienController::class, 'updatePassword'])->name('pasien.profil.password');
});



// APOTEKER
Route::middleware(['auth', 'role:Apoteker'])->group(function () {

    Route::get('/apoteker/dashboard', [ApotekerController::class, 'dashboard'])->name('apoteker.dashboard');

    // Tahap 1 — Validasi
    Route::get('/apoteker/validasi',             [ApotekerController::class, 'menungguValidasi'])->name('apoteker.validasi');
    Route::get('/apoteker/validasi/{id}',        [ApotekerController::class, 'detailValidasi'])->name('apoteker.validasi.detail');
    Route::post('/apoteker/validasi/{id}',       [ApotekerController::class, 'validasi'])->name('apoteker.validasi.proses');
    Route::post('/apoteker/validasi/{id}/tolak', [ApotekerController::class, 'tolakValidasi'])->name('apoteker.validasi.tolak');

    // Tahap 2 — Konfirmasi Pembayaran
    Route::get('/apoteker/pembayaran',       [ApotekerController::class, 'menungguPembayaran'])->name('apoteker.pembayaran');
    Route::post('/apoteker/pembayaran/{id}', [ApotekerController::class, 'konfirmasiPembayaran'])->name('apoteker.pembayaran.konfirmasi');

    // Tahap 3 — Diproses & Selesai
    Route::get('/apoteker/diproses',               [ApotekerController::class, 'diproses'])->name('apoteker.diproses');
    Route::post('/apoteker/diproses/{id}/selesai', [ApotekerController::class, 'selesaikan'])->name('apoteker.diproses.selesai');
});