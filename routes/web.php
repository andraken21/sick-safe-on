<?php

use Illuminate\Support\Facades\Route;

    // Agar saat menjalankan website otomatis langsung ke halaman homepage terlebih dahulu
    Route::get('/', function () {
        return view('homepage');
    });

<<<<<<< HEAD
// Agar saat menekan button masuk akan pergi ke web login
=======
// Agar saat menekan button masuk di homepage akan pergi ke web login
>>>>>>> 6efbb85607e476b1ecfee4d472dba63adf762253
    Route::get('/auth/login', function () {
        return view('auth.login');
    });

<<<<<<< HEAD
// Agar saat menekan button daftar akan pergi ke web registrasi
=======
// Agar saat menekan button daftar di homepage akan pergi ke web registrasi
>>>>>>> 6efbb85607e476b1ecfee4d472dba63adf762253
    Route::get('/auth/register', function () {
        return view('auth.registrasi');
    });

<<<<<<< HEAD
// Agar saat menekan button forgot akan pergi ke web forgot
=======
// Agar saat menekan button daftar di homepage akan pergi ke web forgot
>>>>>>> 6efbb85607e476b1ecfee4d472dba63adf762253
    Route::get('/auth/forgot', function () {
        return view('auth.forgot');
    });

<<<<<<< HEAD

    
=======
// Agar saat menekan button daftar di login akan pergi ke web registrasi
    Route::get('/register', function () {
        return view('auth.registrasi');
    });

// Agar saat menekan button forgot di login akan pergi ke web forgot
    Route::get('/forgot', function () {
        return view('auth.forgot');
    });

    Route::get('/header', function () {
    return view('layout/header');
    });
    

>>>>>>> 6efbb85607e476b1ecfee4d472dba63adf762253
    Route::get('/app', function () {
        return view('layout/app');
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
