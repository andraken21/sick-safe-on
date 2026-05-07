<?php

use Illuminate\Support\Facades\Route;

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