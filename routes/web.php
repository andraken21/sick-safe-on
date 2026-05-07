<?php

use Illuminate\Support\Facades\Route;

    // Agar saat menjalankan website otomatis langsung ke halaman homepage terlebih dahulu
    Route::get('/', function () {
        return view('homepage');
    });

// Agar saat menekan button masuk di homepage akan pergi ke web login
    Route::get('/auth/login', function () {
        return view('auth.login');
    });

// Agar saat menekan button daftar di homepage akan pergi ke web registrasi
    Route::get('/auth/register', function () {
        return view('auth.registrasi');
    });

<<<<<<< HEAD
// Agar saat menekan button daftar di homepage akan pergi ke web forgot
    Route::get('/auth/forgot', function () {
        return view('auth.forgot');
    });

// Agar saat menekan button daftar di login akan pergi ke web registrasi
    Route::get('/register', function () {
        return view('auth.registrasi');
    });

// Agar saat menekan button forgot di login akan pergi ke web forgot
    Route::get('/forgot', function () {
        return view('auth.forgot');
    });

    

    Route::get('/app', function () {
        return view('app');
    });
=======
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
>>>>>>> 4f43fd0af43da923fc987c3e1f36ab6d570f19bc
