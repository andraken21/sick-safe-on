<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\Resep;
use App\Models\ResepObat;
use App\Models\DetailResep;
use App\Models\Antrian;

class DokterController extends Controller
{
    // ────────────────────────────────────────────────────
    // HELPER — ambil record dokter milik user yang login
    // ────────────────────────────────────────────────────

    private function getDokter(): Dokter
    {
        return Dokter::where('id_user', Auth::id())->firstOrFail();
    }

    // ────────────────────────────────────────────────────
    // DASHBOARD
    // ────────────────────────────────────────────────────

    public function dashboard()
    {
        $dokter = $this->getDokter();

        $totalResep = DetailResep::where('id_dokter', $dokter->id_dokter)->count();

        $totalMenunggu  = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->where('status', 'menunggu')->count();
        $totalDiproses  = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->where('status', 'diproses')->count();
        $totalSelesai   = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->where('status', 'selesai')->count();

        $antrianHariIni = Antrian::where('id_dokter', $dokter->id_dokter)
                            ->where('tanggal', today())
                            ->count();
        $resepHariIni = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->whereDate('tanggal', today())
                            ->count();
        $pasienDilayaniBulanIni = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->whereMonth('tanggal', today()->month)
                            ->whereYear('tanggal', today()->year)
                            ->distinct('id_pasien')
                            ->count('id_pasien');
        $antrianTerbaru = Antrian::with('pasien.user')
                            ->where('id_dokter', $dokter->id_dokter)
                            ->whereDate('tanggal', today())
                            ->orderBy('nomor_antrian')
                            ->limit(5)
                            ->get();

        $resepTerbaru = DetailResep::with(['pasien.user', 'resep'])
                            ->where('id_dokter', $dokter->id_dokter)
                            ->latest('tanggal')
                            ->limit(5)
                            ->get();

        return view('dokter.dashboard', compact(
            'dokter',
            'totalResep',
            'totalMenunggu',
            'totalDiproses',
            'totalSelesai',
            'antrianHariIni',
            'resepHariIni',
            'pasienDilayaniBulanIni',
            'antrianTerbaru',
            'resepTerbaru'
        ));
    }

    // ────────────────────────────────────────────────────
    // PILIH PASIEN
    // Dokter memilih pasien sebelum membuat resep.
    //
    // Filter prioritas (query param ?prioritas=):
    //   'mandiri' → tampilkan pasien tanpa no_bpjs (null / kosong)
    //   'bpjs'    → tampilkan pasien dengan no_bpjs terisi
    //   (kosong)  → tampilkan semua pasien
    //
    // Search & filter jenis kelamin dihapus sesuai permintaan.
    // ────────────────────────────────────────────────────

    public function pilihPasien(Request $request)
    {
        $prioritas = $request->input('prioritas'); // 'mandiri' | 'bpjs' | null

        $pasiens = Pasien::with('user')
            ->when($prioritas === 'bpjs', function ($query) {
                // Pasien BPJS: no_bpjs tidak null dan tidak kosong
                $query->whereNotNull('no_bpjs')->where('no_bpjs', '!=', '');
            })
            ->when($prioritas === 'mandiri', function ($query) {
                // Pasien Mandiri: no_bpjs null atau kosong
                $query->where(function ($q) {
                    $q->whereNull('no_bpjs')->orWhere('no_bpjs', '');
                });
            })
            ->paginate(10)
            ->withQueryString();

        $totalPasien    = Pasien::count();
        $totalLakiLaki  = Pasien::whereHas('user', fn ($q) => $q->where('jenis_kelamin', 'Laki-laki'))->count();
        $totalPerempuan = Pasien::whereHas('user', fn ($q) => $q->where('jenis_kelamin', 'Perempuan'))->count();

        return view('dokter.pilihPasien', compact(
            'pasiens',
            'prioritas',
            'totalPasien',
            'totalLakiLaki',
            'totalPerempuan'
        ));
    }

    // ────────────────────────────────────────────────────
    // CREATE RESEP (GET)
    // ────────────────────────────────────────────────────

    public function daftarResep(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
        ]);

        return redirect()->route('dokter.resep.create', ['id_pasien' => $request->id_pasien]);
    }

    public function createResep(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
        ]);

        $pasien  = Pasien::with('user')->findOrFail($request->id_pasien);
        $dokter  = $this->getDokter();

        $obatList = Obat::with('kategori')
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->orderBy('nama_obat')
            ->get();

        return view('dokter.resep', compact('pasien', 'dokter', 'obatList'));
    }

    // ────────────────────────────────────────────────────
    // STORE RESEP
    // Field obat yang disimpan: id_obat, jumlah, dosis, satuan, aturan_pakai
    // Field keterangan_tambahan dihapus dari form (tidak divalidasi lagi).
    // ────────────────────────────────────────────────────

    public function storeResep(Request $request)
    {
        $request->validate([
            'id_pasien'            => 'required|exists:pasien,id_pasien',
            'keluhan'              => 'required|string|max:1000',
            'diagnosa'             => 'required|string|max:1000',
            'keterangan'           => 'nullable|string|max:500',
            'obat'                 => 'required|array|min:1',
            'obat.*.id_obat'       => 'required|exists:obat,id_obat',
            'obat.*.jumlah'        => 'required|integer|min:1',
            'obat.*.dosis'         => 'required|string|max:255',
            'obat.*.satuan'        => 'required|string|max:255',
            'obat.*.aturan_pakai'  => 'required|string|max:255',
        ]);

        $dokter = $this->getDokter();

        // Cek stok semua obat sebelum menyimpan
        foreach ($request->obat as $index => $item) {
            $obat = Obat::find($item['id_obat']);
            if (! $obat || $obat->stok < $item['jumlah']) {
                $nama = $obat->nama_obat ?? "Item #$index";
                $stok = $obat->stok      ?? 0;
                return back()
                    ->withInput()
                    ->with('error', "Stok obat \"{$nama}\" tidak mencukupi (stok: {$stok}, diminta: {$item['jumlah']}).");
            }
        }

        DB::transaction(function () use ($request, $dokter) {
            // 1. Buat header resep
            $resep = Resep::create([]);

            // 2. Simpan setiap item obat ke resep_obat
            foreach ($request->obat as $item) {
                ResepObat::create([
                    'id_resep'    => $resep->id_resep,
                    'id_obat'     => $item['id_obat'],
                    'jumlah'      => $item['jumlah'],
                    'dosis'       => $item['dosis'],
                    'satuan'      => $item['satuan'],
                    'aturan_pakai'=> $item['aturan_pakai'],
                ]);
            }

            // 3. Buat detail_resep
            DetailResep::create([
                'id_pasien'  => $request->id_pasien,
                'id_dokter'  => $dokter->id_dokter,
                'id_resep'   => $resep->id_resep,
                'keluhan'    => $request->keluhan,
                'diagnosa'   => $request->diagnosa,
                'keterangan' => $request->keterangan,
                'status'     => 'menunggu',
                'total_obat' => collect($request->obat)->sum('jumlah'),
                'tanggal'    => today(),
            ]);
        });

        return redirect()->route('dokter.antrian')->with('success', 'Resep berhasil dibuat dan dikirim ke apoteker.');
    }

    // ────────────────────────────────────────────────────
    // DETAIL RESEP
    // ────────────────────────────────────────────────────

    public function detailResep($id_detail_resep)
    {
        $dokter = $this->getDokter();

        $detail = DetailResep::with([
                'pasien.user',
                'resep.resepObat.obat.kategori',
            ])
            ->where('id_dokter', $dokter->id_dokter)
            ->findOrFail($id_detail_resep);

        return view('dokter.detailResep', compact('detail', 'dokter'));
    }

    // ────────────────────────────────────────────────────
    // DAFTAR RESEP
    // ────────────────────────────────────────────────────

    public function resep(Request $request)
    {
        $dokter  = $this->getDokter();
        $status  = $request->input('status');
        $tanggal = $request->input('tanggal');

        $resepList = DetailResep::with([
                'pasien.user',
                'resep.resepObat.obat',
            ])
            ->where('id_dokter', $dokter->id_dokter)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($tanggal, fn($q) => $q->whereDate('tanggal', $tanggal))
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        $totalResep    = DetailResep::where('id_dokter', $dokter->id_dokter)->count();
        $totalMenunggu = DetailResep::where('id_dokter', $dokter->id_dokter)->where('status', 'menunggu')->count();
        $totalDiproses = DetailResep::where('id_dokter', $dokter->id_dokter)->where('status', 'diproses')->count();
        $totalSelesai  = DetailResep::where('id_dokter', $dokter->id_dokter)->where('status', 'selesai')->count();

        return view('dokter.daftarResep', compact(
            'resepList', 'status', 'tanggal',
            'totalResep', 'totalMenunggu', 'totalDiproses', 'totalSelesai'
        ));
    }

    // ────────────────────────────────────────────────────
    // ANTRIAN
    // ────────────────────────────────────────────────────

    public function antrian(Request $request)
    {
        $dokter  = $this->getDokter();
        $tanggal = $request->input('tanggal', today()->toDateString());

        $antrianList = Antrian::with('pasien.user')
            ->where('id_dokter', $dokter->id_dokter)
            ->whereDate('tanggal', $tanggal)
            ->orderBy('nomor_antrian')
            ->paginate(10)
            ->withQueryString();

        return view('dokter.antrian', compact('antrianList', 'tanggal', 'dokter'));
    }
}