<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

    // Agar saat menjalankan website otomatis langsung ke halaman homepage terlebih dahulu
    Route::get('/', function () {
        return view('homepage');    
    });

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

    Route::view('/admin/resep-digital', 'admin.resepDigital');

    Route::view('/admin/stok-obat', 'admin.stokObat');

    Route::view('/admin/validasi-apoteker', 'admin.validasiApoteker');

    Route::view('/admin/pembelian', 'admin.pembelian');

    Route::view('/admin/pembayaran', 'admin.pembayaran');

    Route::view('/admin/distribusi-obat', 'admin.distribusiObat');

    Route::view('/admin/pengaturan', 'admin.pengaturan');

});
    

    // Kalau Role Dokter
    Route::middleware(['auth', 'role:Dokter'])->group(function () {
        Route::get('/dokter/dashboard', function () {
            return view('dokter.dashboard');
        });
    });

    // Kalau Role Pasien
    Route::middleware(['auth', 'role:Pasien'])->group(function () {
        Route::get('/pasien/dashboard', function () {
            return view('pasien.dashboard');
        });
    });

    // Kalau Role Apoteker
    Route::middleware(['auth', 'role:Apoteker'])->group (function () {
        Route::get('/apoteker/dashboard', function(){
        return view('apoteker.dashboard');
        });
    });

    // Agar saat menekan button forgot akan pergi ke web forgot
    Route::get('/forgot', function () {
        return view('auth.forgot');
    });
        
    // Halaman Input Email (Gambar 1)
    Route::post('/forgot-password', [LoginController::class, 'checkEmail']);

    // Halaman Buat Password Baru (Gambar 2)
    Route::get('/reset-password/{email}', [LoginController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [LoginController::class, 'updatePassword']);

    // Memproses logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');




    // Agar saat menekan button app akan pergi ke web app
    Route::get('/app', function () {
        return view('layouts.app');
    });

