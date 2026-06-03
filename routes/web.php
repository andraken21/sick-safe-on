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

Route::get('/forgot', function () {
    return view('auth.forgot');
});
Route::post('/forgot-password',       [LoginController::class, 'checkEmail']);
Route::get('/reset-password/{email}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',        [LoginController::class, 'updatePassword']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─────────────────────────────────────────────
// PROTECTED ROUTES — Admin
// ─────────────────────────────────────────────

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/kelolaAkunPengguna', function () {
        return view('admin.kelolaAkunPengguna');
    })->name('kelolaAkunPengguna');

    Route::get('/admin/kelolaDataObat', function () {
        return view('admin.kelolaDataObat');
    })->name('kelolaDataObat');

    Route::get('/admin/laporanAnalisisData', function () {
        return view('admin.laporanAnalisisData');
    })->name('laporanAnalisisData');

    Route::get('/admin/pantauTransaksi', function () {
        return view('admin.pantauTransaksi');
    })->name('pantauTransaksi');
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
// {status?} — opsional, default 'validasi'
// ─────────────────────────────────────────────

Route::middleware(['auth', 'role:Apoteker'])->group(function () {

    Route::get('/apoteker/dashboard/{status?}', function ($status = 'validasi') {
        $allowed = ['validasi', 'pembayaran', 'diproses'];
        if (!in_array($status, $allowed)) {
            $status = 'validasi';
        }
        return view('apoteker.dashboard', compact('status'));
    })->name('apoteker.dashboard');

    Route::get('/apoteker/melihatResep', function () {
        return view('apoteker.melihatResep');
    })->name('apoteker.melihatResep');

    Route::get('/apoteker/ValidasiResep', function () {
        return view('apoteker.ValidasiResep');
    })->name('validasiresep');

});