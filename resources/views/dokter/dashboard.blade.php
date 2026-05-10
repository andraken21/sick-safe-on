@extends('layouts.app')

@section('title', 'Dashboard Dokter - Sick Safe ON')

@section('content')
    <div class="container-fluid">
        <h1>Dashboard Dokter</h1>
        <hr>
        <p>Selamat datang, dr. <strong>{{ Auth::user()->nama }}</strong>. Semangat melayani pasien hari ini!</p>
    </div>
@endsection