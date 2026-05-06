<?php

use Illuminate\Support\Facades\Route;

// Agar saat menjalankan website otomatis langsung ke halaman homepage terlebih dahulu
Route::get('/', function () {
    return view('homepage');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/app', function () {
    return view('app');
});

Route::get('/forgot', function () {
    return view('forgot');
});
