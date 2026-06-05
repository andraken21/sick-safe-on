<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApotekerController extends Controller
{
    public function dashboard()
{
    $menungguValidasi = Resep::where('status', 'menunggu_validasi')->count();

    $menungguPembayaran = Resep::where('status', 'menunggu_pembayaran')->count();

    $diproses = Resep::where('status', 'diproses')->count();

    $totalResepHariIni = Resep::whereDate('created_at', today())->count();

    return view('apoteker.dashboard', compact(
        'menungguValidasi',
        'menungguPembayaran',
        'diproses',
        'totalResepHariIni'
    ));
}

}