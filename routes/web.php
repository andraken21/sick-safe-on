<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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

<<<<<<< HEAD
    // Agar saat menekan button daftar akan pergi ke web registrasi
    Route::get('/register', function () {
        return view('auth.registrasi');
    });

    // Membuat akun pasien baru dengan role Pasien secara otomatis, dan menyimpan data ke database
    Route::post('/register', [LoginController::class, 'register']);

    // Agar saat menekan button masuk akan pergi ke web login
    Route::get('/login', [LoginController::class, 'index'])->name('login');

    // Memproses data login
    Route::post('/login', [LoginController::class, 'login']);

    // Kalau Role Admin
    Route::middleware(['auth','role:Admin'])->group(function () {
     Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        });
    });

    // Kalau Role Dokter
    Route::middleware(['auth', 'role:Dokter'])->group(function () {
        Route::get('/dokter/dashboard', function () {
            return view('dokter.dashboard');
        });
    });

    // Kalau Role Pasien
Route::middleware(['auth'])->group(function () {
    Route::prefix('pasien')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\PasienDashboardController::class, 'dashboard'])->name('pasien.dashboard');
        Route::get('/resep', [App\Http\Controllers\PasienDashboardController::class, 'resep'])->name('pasien.resep.index');
        Route::get('/pembayaran', [App\Http\Controllers\PasienDashboardController::class, 'pembayaran'])->name('pasien.pembayaran.index');
        Route::get('/pembayaran/bayar/{invoice}', [App\Http\Controllers\PasienDashboardController::class, 'halamanBayar'])->name('pasien.pembayaran.bayar');
        Route::post('/pembayaran/proses', [App\Http\Controllers\PasienDashboardController::class, 'prosesBayar'])->name('pasien.pembayaran.proses');
    });
=======
// ADMIN
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard',           fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/admin/kelolaAkunPengguna',  fn() => view('admin.kelolaAkunPengguna'))->name('kelolaAkunPengguna');
    Route::get('/admin/kelolaDataObat',      fn() => view('admin.kelolaDataObat'))->name('kelolaDataObat');
    Route::get('/admin/laporanAnalisisData', fn() => view('admin.laporanAnalisisData'))->name('laporanAnalisisData');
    Route::get('/admin/pantauTransaksi',     fn() => view('admin.pantauTransaksi'))->name('pantauTransaksi');
>>>>>>> main
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