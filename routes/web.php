<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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