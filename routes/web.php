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
    return view('layout/app');
<<<<<<< HEAD
=======
});

Route::get('/forgot', function () {
    return view('forgot');
>>>>>>> 44306c0210b4a89fb7fd07498def95f1a9e2dd65
});

Route::get('/navigation', function () {
    return view('layout/navigation');
});

Route::get('/navpasien', function () {
    return view('layout/navPasien');
});

Route::get('/navadmin', function () {
    return view('layout/navAdmin');
});

Route::get('/navdokter', function () {
    return view('layout/navDokter');
});

Route::get('/navapoteker', function () {
    return view('layout/navApoteker');
});