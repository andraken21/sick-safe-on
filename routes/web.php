<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// ─────────────────────────────────────────────
// PUBLIC ROUTES
// ─────────────────────────────────────────────

Route::get('/', function () {
    return view('homepage');
});

Route::get('/register', function () {
    return view('auth.registrasi');
});
Route::post('/register', [LoginController::class, 'register']);

Route::get('/login',  [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/forgot',             function () { return view('auth.forgot'); });
Route::post('/forgot-password',   [LoginController::class, 'checkEmail']);
Route::get('/reset-password/{email}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',    [LoginController::class, 'updatePassword']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─────────────────────────────────────────────
// PROTECTED ROUTES — Admin
// ─────────────────────────────────────────────

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// ─────────────────────────────────────────────
// PROTECTED ROUTES — Dokter
// ─────────────────────────────────────────────

Route::middleware(['auth', 'role:Dokter'])->group(function () {
    Route::get('/dokter/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');
});

// ─────────────────────────────────────────────
// PROTECTED ROUTES — Pasien
// PERBAIKAN: route resep & pembayaran dipindah ke sini (sebelumnya salah masuk grup Apoteker)
// ─────────────────────────────────────────────

Route::middleware(['auth', 'role:Pasien'])->group(function () {
    Route::get('/pasien/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::get('/pasien/resep', function () {
        return view('pasien.resep');
    })->name('pasien.resep.index');

    Route::get('/pasien/resep/{id}', function ($id) {
        return view('pasien.resep-detail', ['id' => $id]);
    })->name('pasien.resep.detail');

    Route::get('/pasien/pembayaran', function () {
        return view('pasien.pembayaran');
    })->name('pasien.pembayaran.index');
});

// ─────────────────────────────────────────────
// PROTECTED ROUTES — Apoteker
// ─────────────────────────────────────────────

Route::middleware(['auth', 'role:Apoteker'])->group(function () {
    Route::get('/apoteker/dashboard', function () {
        return view('apoteker.dashboard');
    })->name('apoteker.dashboard');
});