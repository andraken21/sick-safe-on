<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
<<<<<<< HEAD
use App\Http\Controllers\DokterController;

// ─── Homepage ───────────────────────────────────────────────
Route::get('/', function () {
    return view('homepage');
});

// ─── Auth ───────────────────────────────────────────────────
Route::get('/register', function () {
    return view('auth.registrasi');
});
Route::post('/register', [LoginController::class, 'register']);

Route::get('/login',  [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

Route::get('/forgot', function () { return view('auth.forgot'); });
Route::post('/forgot-password',           [LoginController::class, 'checkEmail']);
Route::get('/reset-password/{email}',     [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',            [LoginController::class, 'updatePassword']);

// ─── Admin ──────────────────────────────────────────────────
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard',               fn() => view('admin.dashboard'));
    Route::get('/admin/kelolaAkunPengguna',      fn() => view('admin.kelolaAkunPengguna'));
    Route::get('/admin/kelolaDataObat',          fn() => view('admin.kelolaDataObat'));
    Route::get('/admin/laporanAnalisisData',     fn() => view('admin.laporanAnalisisData'));
    Route::get('/admin/pantauTransaksi',         fn() => view('admin.pantauTransaksi'));
});

// ─── Dokter ─────────────────────────────────────────────────
Route::middleware(['auth', 'role:Dokter'])->prefix('dokter')->name('dokter.')->group(function () {

    // Dashboard
    Route::get('/dashboard',            [DokterController::class, 'dashboard'])    ->name('dashboard');
    Route::get('/api/antrian-count',    [DokterController::class, 'antrianCount']) ->name('api.antrian-count');

    // Pilih Pasien
    Route::get('/pilih-pasien',         [DokterController::class, 'pilihPasien'])  ->name('pilih-pasien');

    // Resep — CRUD
    Route::get('/resep',                [DokterController::class, 'daftarResep'])  ->name('resep.index');
    Route::get('/resep/buat/{pasien}',  [DokterController::class, 'buatResep'])    ->name('resep.buat');
    Route::post('/resep/store',         [DokterController::class, 'storeResep'])   ->name('resep.store');
    Route::get('/resep/{resep}',        [DokterController::class, 'detailResep'])  ->name('resep.show');
    Route::get('/resep/{resep}/edit',   [DokterController::class, 'editResep'])    ->name('resep.edit');
    Route::put('/resep/{resep}',        [DokterController::class, 'updateResep'])  ->name('resep.update');
    Route::delete('/resep/{resep}',     [DokterController::class, 'hapusResep'])   ->name('resep.destroy');
});

// ─── Pasien ─────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('pasien')->group(function () {
    Route::get('/dashboard',   [App\Http\Controllers\PasienDashboardController::class, 'dashboard'])  ->name('pasien.dashboard');
    Route::get('/resep',       [App\Http\Controllers\PasienDashboardController::class, 'resep'])       ->name('pasien.resep.index');
    Route::get('/pembayaran',  [App\Http\Controllers\PasienDashboardController::class, 'pembayaran'])  ->name('pasien.pembayaran.index');
});

// ─── Apoteker ───────────────────────────────────────────────
Route::middleware(['auth', 'role:Apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/dashboard',           fn() => view('apoteker.dashboard'));
    Route::get('/menunggu-validasi',   [App\Http\Controllers\ApotekerController::class, 'menungguValidasi'])  ->name('menunggu-validasi');
    Route::get('/menunggu-pembayaran', [App\Http\Controllers\ApotekerController::class, 'menungguPembayaran'])->name('menunggu-pembayaran');
    Route::get('/diproses',            [App\Http\Controllers\ApotekerController::class, 'diproses'])          ->name('diproses');
});

// ─── Misc ────────────────────────────────────────────────────
Route::get('/app', fn() => view('layouts.app'));
=======
use App\Http\Controllers\PasienController;

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
    Route::get('/admin/dashboard',           fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/admin/kelolaAkunPengguna',  fn() => view('admin.kelolaAkunPengguna'))->name('kelolaAkunPengguna');
    Route::get('/admin/kelolaDataObat',      fn() => view('admin.kelolaDataObat'))->name('kelolaDataObat');
    Route::get('/admin/laporanAnalisisData', fn() => view('admin.laporanAnalisisData'))->name('laporanAnalisisData');
    Route::get('/admin/pantauTransaksi',     fn() => view('admin.pantauTransaksi'))->name('pantauTransaksi');
});

// DOKTER
Route::middleware(['auth', 'role:Dokter'])->group(function () {
    Route::get('/dokter/dashboard', fn() => view('dokter.dashboard'))->name('dokter.dashboard');

    // Pilih pasien — nanti controller diganti ke DokterController@pilihPasien
    Route::get('/dokter/pilih-pasien', fn() => view('dokter.pilihPasien'))->name('dokter.pilih-pasien');

    // Buat resep — nanti controller diganti ke DokterController@createResep
    Route::get('/dokter/daftar-resep', fn($id_pasien = 1) => view('dokter.daftarResep'))->name('dokter.daftar-resep');

    // Simpan resep — nanti diproses oleh controller
    Route::post('/dokter/resep/store', fn() => redirect()->route('dokter.resep.index')->with('success', 'Resep berhasil disimpan'))->name('dokter.resep.store');
 
    // Daftar resep
    Route::get('/dokter/resep', fn() => view('dokter.resep'))->name('dokter.resep');
    
    // Antrian
    Route::get('/dokter/antrian', fn() => view('dokter.antrian'))->name('dokter.antrian');

});

// PASIEN
Route::middleware(['auth', 'role:Pasien'])->group(function () {
        Route::get('/pasien/dashboard', [App\Http\Controllers\PasienController::class, 'dashboard'])->name('pasien.dashboard');
        Route::get('/pasien/resep', [App\Http\Controllers\PasienController::class, 'resep'])->name('pasien.resep');
        Route::get('/pasien/pembayaran', [App\Http\Controllers\PasienController::class, 'pembayaran'])->name('pasien.pembayaran');
        Route::get('/pasien/pembayaran/bayar/{invoice}', [App\Http\Controllers\PasienController::class, 'halamanBayar'])->name('pasien.pembayaran.bayar');
        Route::post('/pasien/pembayaran/proses', [App\Http\Controllers\PasienController::class, 'prosesBayar'])->name('pasien.pembayaran.proses');
});

// APOTEKER
Route::middleware(['auth', 'role:Apoteker'])->group(function () {
    Route::get('/apoteker/dashboard/{status?}', function ($status = 'validasi') {
        $allowed = ['validasi', 'pembayaran', 'diproses'];
        $status  = in_array($status, $allowed) ? $status : 'validasi';
        return view('apoteker.dashboard', compact('status'));
    })->name('apoteker.dashboard');

    Route::get('/apoteker/melihatResep',  fn() => view('apoteker.melihatResep'))->name('apoteker.melihatResep');
    Route::get('/apoteker/ValidasiResep', fn() => view('apoteker.ValidasiResep'))->name('validasiresep');
});
>>>>>>> main
