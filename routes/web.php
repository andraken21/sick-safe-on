<?php

use Illuminate\Support\Facades\Route;

    // Agar saat menjalankan website otomatis langsung ke halaman homepage terlebih dahulu
    Route::get('/', function () {
        return view('homepage');
    });

// Agar saat menekan button masuk akan pergi ke web login
    Route::get('/auth/login', function () {
        return view('auth.login');
    });

// Agar saat menekan button daftar akan pergi ke web registrasi
    Route::get('/auth/register', function () {
        return view('auth.registrasi');
    });

// Agar saat menekan button forgot akan pergi ke web forgot
    Route::get('/auth/forgot', function () {
        return view('auth.forgot');
    });

// Agar saat menekan buton konifirmasi forgot akan pergi ke web forgot reset
    Route::get('/auth/forgotReset', function () {
        return view('auth.forgot-reset');
    });
// Agar saat menekan button daftar di login akan pergi ke web registrasi
    Route::get('/register', function () {
        return view('auth.registrasi');
    });

// Agar saat menekan button forgot di login akan pergi ke web forgot
    Route::get('/forgot', function () {
        return view('auth.forgot');
    });

    Route::get('/header', function () {
    return view('layouts/header');
    });
    
// Agar saat menekan button app akan pergi ke web app
    Route::get('/app', function () {
        return view('layouts/app');
    });

    Route::get('/navpasien', function () {
        return view('layouts/navPasien');
    });

    Route::get('/navadmin', function () {
        return view('layouts/navAdmin');
    });

    Route::get('/navdokter', function () {
        return view('layouts/navDokter');
    });

    Route::get('/navapoteker', function () {
        return view('layouts/navApoteker');
    });
    Route::get('/footer', function () {
    return view('layouts/footer'); 
});
