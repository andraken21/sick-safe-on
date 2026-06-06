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
    // Menampilkan ringkasan statistik dokter:
    // total resep dibuat, antrian hari ini, dll.
    // ────────────────────────────────────────────────────

    public function dashboard()
    {
        $dokter = $this->getDokter();

        // Hitung total resep yang pernah dibuat dokter ini
        $totalResep = DetailResep::where('id_dokter', $dokter->id_dokter)->count();

        // Hitung resep per status
        $totalMenunggu  = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->where('status', 'menunggu')->count();
        $totalDiproses  = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->where('status', 'diproses')->count();
        $totalSelesai   = DetailResep::where('id_dokter', $dokter->id_dokter)
                            ->where('status', 'selesai')->count();

        // Antrian hari ini untuk dokter ini
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

        // 5 resep terbaru
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
    // Bisa dicari berdasarkan nama / NIK / no. BPJS.
    // ────────────────────────────────────────────────────

    public function pilihPasien(Request $request)
    {
        $search = $request->input('search');
        $jenisKelamin = $request->input('jenis_kelamin');

        $pasiens = Pasien::with('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                })->orWhere('no_bpjs', 'like', "%{$search}%");
            })
            ->when($jenisKelamin, function ($query, $jenisKelamin) {
                $query->whereHas('user', fn ($q) => $q->where('jenis_kelamin', $jenisKelamin));
            })
            ->paginate(10)
            ->withQueryString();
        $totalPasien = Pasien::count();
        $totalAktif = $totalPasien;
        $totalLakiLaki = Pasien::whereHas('user', fn ($q) => $q->where('jenis_kelamin', 'Laki-laki'))->count();
        $totalPerempuan = Pasien::whereHas('user', fn ($q) => $q->where('jenis_kelamin', 'Perempuan'))->count();

        return view('dokter.pilihPasien', compact('pasiens', 'search', 'totalPasien', 'totalAktif', 'totalLakiLaki', 'totalPerempuan'));
    }

    // ────────────────────────────────────────────────────
    // DAFTAR RESEP (Form buat resep baru)
    // Dokter memilih pasien dari query param ?id_pasien=,
    // lalu form ditampilkan dengan daftar obat yang tersedia.
    // ────────────────────────────────────────────────────

    public function daftarResep(Request $request)
    {
        // Validasi bahwa id_pasien dikirim (dari tombol "Pilih" di pilihPasien)
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
        ]);

        // Redirect ke route resep.create agar URL konsisten dan bookmark-able
        return redirect()->route('dokter.resep.create', ['id_pasien' => $request->id_pasien]);
    }

    /**
     * Form buat resep (GET).
     * Dipanggil dari route('dokter.resep.create', ['id_pasien' => ...])
     * atau langsung dari tombol "Pilih" di pilihPasien.blade.php.
     */
    public function createResep(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
        ]);

        $pasien  = Pasien::with('user')->findOrFail($request->id_pasien);
        $dokter  = $this->getDokter();

        // Ambil obat yang masih tersedia dan stok > 0
        $obatList = Obat::with('kategori')
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->orderBy('nama_obat')
            ->get();

        return view('dokter.resep', compact('pasien', 'dokter', 'obatList'));
    }

    // ────────────────────────────────────────────────────
    // STORE RESEP
    // Menyimpan resep baru beserta detail obat ke DB.
    //
    // Alur:
    //   resep (header) → resep_obat (item obat) → detail_resep (linking ke pasien & dokter)
    // ────────────────────────────────────────────────────

    public function storeResep(Request $request)
    {
        $request->validate([
            'id_pasien'           => 'required|exists:pasien,id_pasien',
            'keluhan'             => 'required|string|max:1000',
            'diagnosa'            => 'required|string|max:1000',
            'keterangan'          => 'nullable|string|max:500',
            // obat dikirim sebagai array: obat[0][id_obat], obat[0][jumlah], obat[0][dosis]
            'obat'                => 'required|array|min:1',
            'obat.*.id_obat'      => 'required|exists:obat,id_obat',
            'obat.*.jumlah'       => 'required|integer|min:1',
            'obat.*.dosis'        => 'required|string|max:255',
        ]);

        $dokter = $this->getDokter();

        // Cek stok semua obat sebelum menyimpan
        foreach ($request->obat as $index => $item) {
            $obat = Obat::find($item['id_obat']);
            if (! $obat || $obat->stok < $item['jumlah']) {
                $nama  = $obat->nama_obat ?? "Item #$index";
                $stok  = $obat->stok      ?? 0;
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
                    'id_resep' => $resep->id_resep,
                    'id_obat'  => $item['id_obat'],
                    'jumlah'   => $item['jumlah'],
                    'dosis'    => $item['dosis'],
                ]);
            }

            // 3. Buat detail_resep (menghubungkan resep, pasien, dan dokter)
            DetailResep::create([
                'id_pasien'   => $request->id_pasien,
                'id_dokter'   => $dokter->id_dokter,
                'id_resep'    => $resep->id_resep,
                'keluhan'     => $request->keluhan,
                'diagnosa'    => $request->diagnosa,
                'keterangan'  => $request->keterangan,
                'status'      => 'menunggu',   // langsung masuk antrian apoteker
                'total_obat'  => collect($request->obat)->sum('jumlah'),
                'tanggal'     => today(),
            ]);
        });

        return redirect()->route('dokter.resep')
            ->with('success', 'Resep berhasil dibuat dan dikirim ke apoteker.');
    }

    // ────────────────────────────────────────────────────
    // DETAIL RESEP
    // Dokter melihat isi lengkap satu resep:
    // info pasien, daftar obat + dosis, status terkini.
    // ────────────────────────────────────────────────────

    public function detailResep($id_detail_resep)
    {
        $dokter = $this->getDokter();

        // Pastikan resep ini memang milik dokter yang login
        $detail = DetailResep::with([
                'pasien.user',
                'resep.resepObat.obat.kategori',
            ])
            ->where('id_dokter', $dokter->id_dokter)
            ->findOrFail($id_detail_resep);

        return view('dokter.detailResep', compact('detail', 'dokter'));
    }

    // ────────────────────────────────────────────────────
    // DAFTAR RESEP YANG PERNAH DIBUAT DOKTER
    // Dokter bisa memfilter berdasarkan status & tanggal.
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

        $totalResep = DetailResep::where('id_dokter', $dokter->id_dokter)->count();
        $totalMenunggu = DetailResep::where('id_dokter', $dokter->id_dokter)->where('status', 'menunggu')->count();
        $totalDiproses = DetailResep::where('id_dokter', $dokter->id_dokter)->where('status', 'diproses')->count();
        $totalSelesai = DetailResep::where('id_dokter', $dokter->id_dokter)->where('status', 'selesai')->count();

        return view('dokter.daftarResep', compact('resepList', 'status', 'tanggal', 'totalResep', 'totalMenunggu', 'totalDiproses', 'totalSelesai'));
    }

    // ────────────────────────────────────────────────────
    // ANTRIAN
    // Dokter melihat daftar antrian pasien hari ini.
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