@extends('layouts.app')

@section('title', 'Dashboard Admin - Sick Safe ON')

@section('content')
    <div class="container-fluid">
        <h1>Dashboard Admin</h1>
        <hr>
        <p>Selamat datang, <strong>{{ Auth::user()->nama }}</strong>. Anda login sebagai Administrator.</p>
    </div>
@endsection