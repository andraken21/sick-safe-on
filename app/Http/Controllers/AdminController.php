<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Apoteker;
use App\Models\Admin;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailResep;

class AdminController extends Controller
{
    // ────────────────────────────────────────────────────
    // DASHBOARD
    // ────────────────────────────────────────────────────

    public function dashboard()
    {
        // Statistik user
        $totalPasien   = Pasien::count();
        $totalDokter   = Dokter::count();
        $totalApoteker = Apoteker::count();

        // Statistik transaksi
        $totalPendapatan  = Transaksi::where('status', 'lunas')->sum('total_bayar');
        $transaksiPending = Transaksi::where('status', 'pending')->count();
        $transaksiHariIni = Transaksi::where('status', 'lunas')
                                ->whereDate('created_at', today())->count();

        // Statistik resep
        $resepMenunggu = DetailResep::where('status', 'menunggu')->count();
        $resepDiproses = DetailResep::where('status', 'diproses')->count();
        $resepSelesai  = DetailResep::where('status', 'selesai')->count();

        // Obat hampir habis (stok < 10, bukan kadaluarsa)
        $obatHampirHabis = Obat::with('kategori')
                            ->where('stok', '<', 10)
                            ->where('status', '!=', 'kadaluarsa')
                            ->orderBy('stok')
                            ->take(5)
                            ->get();

        // Transaksi terbaru (5 terakhir)
        $transaksiTerbaru = Transaksi::with('pasien.user')
                            ->latest()
                            ->take(5)
                            ->get();

        // Grafik pendapatan 7 hari terakhir
        // subDays(6) agar rentang = hari ini + 6 hari ke belakang = 7 hari total
        $grafikPendapatan = Transaksi::where('status', 'lunas')
            ->whereDate('created_at', '>=', now()->subDays(6)->toDateString())
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_bayar) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien', 'totalDokter', 'totalApoteker',
            'totalPendapatan', 'transaksiPending', 'transaksiHariIni',
            'resepMenunggu', 'resepDiproses', 'resepSelesai',
            'obatHampirHabis', 'transaksiTerbaru', 'grafikPendapatan'
        ));
    }

    // ────────────────────────────────────────────────────
    // KELOLA AKUN PENGGUNA
    // ────────────────────────────────────────────────────

    public function kelolaAkun(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Eager load relasi role agar tidak N+1 di view
        $users = $query->with(['pasien', 'dokter', 'apoteker', 'admin'])
                       ->latest()
                       ->paginate(15)
                       ->withQueryString();

        return view('admin.kelolaAkunPengguna', compact('users'));
    }

    // createAkun tidak dipakai oleh route — route POST /create langsung ke storeAkun
    // Method ini bisa dihapus, tapi dibiarkan aman
    public function createAkun()
    {
        return view('admin.createAkun');
    }

    public function storeAkun(Request $request)
    {
        $request->validate([
            'nama'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:8|confirmed',
            'role'             => 'required|in:Pasien,Dokter,Apoteker,Admin',
            'nik'              => 'nullable|string|size:16|unique:users,nik',
            'no_telp'          => 'nullable|string|max:15',
            'tanggal_lahir'    => 'nullable|date',
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'alamat'           => 'nullable|string',
            'no_bpjs'          => 'nullable|string|max:13',
            'riwayat_penyakit' => 'nullable|string',
            'spesialis'        => 'required_if:role,Dokter|nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'role'          => $request->role,
                'nik'           => $request->nik,
                'no_telp'       => $request->no_telp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
            ]);

            match ($request->role) {
                'Pasien'   => Pasien::create([
                                'id_user'          => $user->id_user,
                                'no_bpjs'          => $request->no_bpjs,
                                'riwayat_penyakit' => $request->riwayat_penyakit,
                              ]),
                'Dokter'   => Dokter::create([
                                'id_user'   => $user->id_user,
                                'spesialis' => $request->spesialis,
                              ]),
                'Apoteker' => Apoteker::create(['id_user' => $user->id_user]),
                'Admin'    => Admin::create(['id_user'    => $user->id_user]),
            };
        });

        return redirect()->route('kelolaAkunPengguna')
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function editAkun($id_user)
    {
        // Method ini tidak dipakai — edit dilakukan via modal JS di kelolaAkunPengguna
        // Dibiarkan sebagai fallback jika suatu saat dibutuhkan
        $user = User::with(['pasien', 'dokter'])->findOrFail($id_user);
        return view('admin.editAkun', compact('user'));
    }

    public function updateAkun(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);

        $request->validate([
            'nama'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email,' . $id_user . ',id_user',
            'nik'              => 'nullable|string|size:16|unique:users,nik,' . $id_user . ',id_user',
            'no_telp'          => 'nullable|string|max:15',
            'tanggal_lahir'    => 'nullable|date',
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'alamat'           => 'nullable|string',
            'spesialis'        => 'required_if:role,Dokter|nullable|string',
            'no_bpjs'          => 'nullable|string|max:13|unique:pasien,no_bpjs,' . optional($user->pasien)->id_pasien . ',id_pasien',
            'riwayat_penyakit' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'nik'           => $request->nik,
                'no_telp'       => $request->no_telp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
            ]);

            if ($user->role === 'Dokter' && $user->dokter) {
                $user->dokter->update(['spesialis' => $request->spesialis]);
            }

            if ($user->role === 'Pasien' && $user->pasien) {
                $user->pasien->update([
                    'no_bpjs'          => $request->no_bpjs,
                    'riwayat_penyakit' => $request->riwayat_penyakit,
                ]);
            }
        });

        return redirect()->route('kelolaAkunPengguna')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroyAkun($id_user)
    {
        $user = User::findOrFail($id_user);

        if ($user->id_user === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('kelolaAkunPengguna')
            ->with('success', 'Akun berhasil dihapus.');
    }

    // ────────────────────────────────────────────────────
    // KELOLA OBAT
    // ────────────────────────────────────────────────────

    public function kelolaObat(Request $request)
    {
        $query = Obat::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_obat', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $obatList = $query->latest()->paginate(15)->withQueryString();
        $kategori = Kategori::orderBy('kategori_obat')->get();

        return view('admin.kelolaDataObat', compact('obatList', 'kategori'));
    }

    public function storeObat(Request $request)
    {
        $request->validate([
            'nama_obat'          => 'required|string|max:100',
            'id_kategori'        => 'required|exists:kategori,id_kategori',
            'stok'               => 'required|integer|min:0',
            'harga'              => 'required|numeric|min:0',
            'status'             => 'required|in:tersedia,habis,kadaluarsa',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        Obat::create($request->only([
            'nama_obat', 'id_kategori', 'stok',
            'harga', 'status', 'tanggal_kadaluarsa',
        ]));

        return redirect()->route('kelolaDataObat')
            ->with('success', 'Obat berhasil ditambahkan.');
    }

    public function updateObat(Request $request, $id_obat)
    {
        $obat = Obat::findOrFail($id_obat);

        $request->validate([
            'nama_obat'          => 'required|string|max:100',
            'id_kategori'        => 'required|exists:kategori,id_kategori',
            'stok'               => 'required|integer|min:0',
            'harga'              => 'required|numeric|min:0',
            'status'             => 'required|in:tersedia,habis,kadaluarsa',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        $obat->update($request->only([
            'nama_obat', 'id_kategori', 'stok',
            'harga', 'status', 'tanggal_kadaluarsa',
        ]));

        // Sinkronisasi otomatis: stok 0 → status habis
        if ((int) $request->stok === 0 && $request->status === 'tersedia') {
            $obat->update(['status' => 'habis']);
        }

        return redirect()->route('kelolaDataObat')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroyObat($id_obat)
    {
        Obat::findOrFail($id_obat)->delete();

        return redirect()->route('kelolaDataObat')
            ->with('success', 'Obat berhasil dihapus.');
    }

    // ── Kategori Obat ────────────────────────────────────

    public function storeKategori(Request $request)
    {
        $request->validate([
            'kategori_obat' => 'required|string|max:100|unique:kategori,kategori_obat',
        ]);

        Kategori::create(['kategori_obat' => $request->kategori_obat]);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroyKategori($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);

        if ($kategori->obat()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh data obat.');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // ────────────────────────────────────────────────────
    // KONFIRMASI PEMBAYARAN
    // ────────────────────────────────────────────────────

    public function pembayaranPending(Request $request)
    {
        $transaksiList = Transaksi::with([
                'pasien.user',
                'detailTransaksi.resep.detailResep.dokter.user',
            ])
            ->where('status', 'pending')
            ->whereNotNull('metode')
            ->latest()
            ->paginate(15);

        return view('admin.konfirmasiPembayaran', compact('transaksiList'));
    }

    public function konfirmasiPembayaran($id_transaksi)
    {
        $transaksi = Transaksi::where('status', 'pending')->findOrFail($id_transaksi);

        DB::transaction(function () use ($transaksi) {
            $transaksi->update(['status' => 'lunas']);

            $idResepList = DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)
                            ->pluck('id_resep');

            DetailResep::whereIn('id_resep', $idResepList)
                ->where('status', 'menunggu_pembayaran')
                ->update(['status' => 'diproses']);
        });

        return redirect()->route('pantauTransaksi')
            ->with('success', 'Pembayaran dikonfirmasi, resep diteruskan ke apoteker.');
    }

    public function batalkanPembayaran(Request $request, $id_transaksi)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $transaksi = Transaksi::where('status', 'pending')->findOrFail($id_transaksi);

        DB::transaction(function () use ($transaksi, $request) {
            $transaksi->update(['status' => 'batal']);

            $idResepList = DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)
                            ->pluck('id_resep');

            // Status resep dikembalikan ke menunggu_pembayaran agar pasien bisa bayar ulang
            DetailResep::whereIn('id_resep', $idResepList)
                ->where('status', 'menunggu_pembayaran')
                ->update([
                    'status'     => 'menunggu_pembayaran',
                    'keterangan' => $request->keterangan,
                ]);
        });

        return back()->with('success', 'Pembayaran dibatalkan.');
    }

    // ────────────────────────────────────────────────────
    // PANTAU SEMUA TRANSAKSI
    // ────────────────────────────────────────────────────

    public function pantauTransaksi(Request $request)
    {
        $query = Transaksi::with('pasien.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        if ($request->filled('search')) {
            $query->whereHas('pasien.user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $transaksiList = $query->latest()->paginate(15)->withQueryString();

        // Angka summary selalu dihitung dari SEMUA data (bukan hanya hasil filter)
        $totalLunas   = Transaksi::where('status', 'lunas')->sum('total_bayar');
        $totalPending = Transaksi::where('status', 'pending')->count();

        return view('admin.pantauTransaksi', compact(
            'transaksiList', 'totalLunas', 'totalPending'
        ));
    }

    // ────────────────────────────────────────────────────
    // LAPORAN & ANALISIS DATA
    // ────────────────────────────────────────────────────

    public function laporan(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        // Grafik pendapatan per bulan sepanjang tahun yang dipilih
        $pendapatanBulanan = Transaksi::where('status', 'lunas')
            ->whereYear('created_at', $tahun)
            ->selectRaw('MONTH(created_at) as bulan, SUM(total_bayar) as total, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Obat paling banyak diresepkan bulan ini (resep status selesai)
        $obatTerlaris = DB::table('resep_obat')
            ->join('obat', 'resep_obat.id_obat', '=', 'obat.id_obat')
            ->join('resep', 'resep_obat.id_resep', '=', 'resep.id_resep')
            ->join('detail_resep', 'resep.id_resep', '=', 'detail_resep.id_resep')
            ->whereMonth('detail_resep.tanggal', $bulan)
            ->whereYear('detail_resep.tanggal', $tahun)
            ->where('detail_resep.status', 'selesai')
            ->selectRaw('obat.nama_obat, SUM(resep_obat.jumlah) as total_terjual')
            ->groupBy('obat.id_obat', 'obat.nama_obat')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        // Dokter paling aktif bulan ini
        $dokterAktif = DetailResep::with('dokter.user')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereNotNull('id_dokter')
            ->selectRaw('id_dokter, COUNT(*) as total_pasien')
            ->groupBy('id_dokter')
            ->orderByDesc('total_pasien')
            ->take(5)
            ->get();

        $totalPendapatanBulanIni = Transaksi::where('status', 'lunas')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->sum('total_bayar');

        $totalResepBulanIni = DetailResep::where('status', 'selesai')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->count();

        $totalPasienBaru = Pasien::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        return view('admin.laporanAnalisisData', compact(
            'pendapatanBulanan',
            'obatTerlaris',
            'dokterAktif',
            'totalPendapatanBulanIni',
            'totalResepBulanIni',
            'totalPasienBaru',
            'bulan',
            'tahun'
        ));
    }
}