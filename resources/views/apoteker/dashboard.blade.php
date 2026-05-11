@extends('layouts.app')

@section('title', 'Dashboard Apoteker - Sick Safe ON')

@section('content')
    <div class="container-fluid">
        <h1>Dashboard Apoteker</h1>
        <hr>
        <p>Selamat datang, <strong>{{ Auth::user()->nama }}</strong>. Panel manajemen obat siap digunakan.</p>
    </div>
@endsection