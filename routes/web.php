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
