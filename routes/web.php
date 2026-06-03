<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
    Route::get('/admin/dashboard',          fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/admin/kelolaAkunPengguna', fn() => view('admin.kelolaAkunPengguna'))->name('kelolaAkunPengguna');
    Route::get('/admin/kelolaDataObat',     fn() => view('admin.kelolaDataObat'))->name('kelolaDataObat');
    Route::get('/admin/laporanAnalisisData',fn() => view('admin.laporanAnalisisData'))->name('laporanAnalisisData');
    Route::get('/admin/pantauTransaksi',    fn() => view('admin.pantauTransaksi'))->name('pantauTransaksi');
});

// DOKTER
Route::middleware(['auth', 'role:Dokter'])->group(function () {
    Route::get('/dokter/dashboard', fn() => view('dokter.dashboard'))->name('dokter.dashboard');
});

// PASIEN
Route::middleware(['auth', 'role:Pasien'])->group(function () {
    Route::get('/pasien/dashboard',    fn() => view('pasien.dashboard'))->name('pasien.dashboard');
    Route::get('/pasien/resep/index',        fn() => view('pasien.resep.index'))->name('pasien.resep.index');
    Route::get('/pasien/resep/index/{id}',   fn($id) => view('pasien.resep-detail.index', ['id' => $id]))->name('pasien.resep.detail.index');
    Route::get('/pasien/pembayaran/index',   fn() => view('pasien.pembayaran.index'))->name('pasien.pembayaran.index');
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