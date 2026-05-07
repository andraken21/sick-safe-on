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
