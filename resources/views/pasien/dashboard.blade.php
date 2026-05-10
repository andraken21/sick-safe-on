@extends('layouts.app')

@section('title', 'Dashboard Pasien - Sick Safe ON')

@section('content')
    <div class="container-fluid">
        <h1>Dashboard Pasien</h1>
        <hr>
        <p>Halo, <strong>{{ Auth::user()->nama }}</strong>. Semoga sehat selalu bersama Sick Safe ON.</p>
    </div>
@endsection