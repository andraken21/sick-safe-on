<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Halaman Pilih Pasien untuk Dokter
     */
    public function pilihPasien(Request $request)
    {
        // Query pasien beserta data user (nama, no_telp, status)
        $query = Pasien::with('user');

        // Filter pencarian: nama (dari tabel users) atau No_BPJS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('No_BPJS',          'like', "%{$search}%")
                ->orWhere('Riwayat_Penyakit', 'like', "%{$search}%");
            });
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('Jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter status (dari tabel users)
        if ($request->filled('status')) {
            $query->whereHas('user', function ($u) use ($request) {
                $u->where('status', $request->status);
            });
        }

        // Urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');

        // Paginate 10 per halaman
        $pasiens = $query->paginate(10)->withQueryString();

        // Hitung stats untuk card atas
        $totalPasien    = Pasien::count();
        $totalAktif     = Pasien::whereHas('user', fn($u) => $u->where('status', 'aktif'))->count();
        $totalPerempuan = Pasien::where('Jenis_kelamin', 'Perempuan')->count();
        $totalLakiLaki  = Pasien::where('Jenis_kelamin', 'Laki-laki')->count();

        return view('dokter.pilih-pasien', compact(
            'pasiens',
            'totalPasien',
            'totalAktif',
            'totalPerempuan',
            'totalLakiLaki'
        ));
    }
}