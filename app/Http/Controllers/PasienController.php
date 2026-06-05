<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pasien;
use App\Models\DetailResep;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Antrian;
use App\Models\Rating;
use App\Models\Dokter;
use App\Models\Resep;

class PasienController extends Controller
{
    // ── Helper: ambil data pasien yang sedang login ──────
    private function getPasien()
    {
        return Pasien::where('id_user', Auth::id())->firstOrFail();
    }

    // ────────────────────────────────────────────────────
    // DASHBOARD
    // ────────────────────────────────────────────────────

    public function dashboard()
    {
        $pasien = $this->getPasien();

        $antrianAktif = Antrian::with('dokter.user')
            ->where('id_pasien', $pasien->id_pasien)
            ->whereDate('tanggal', today())
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->first();

        $resepTerbaru = DetailResep::with(['dokter.user', 'resep.resepObat.obat'])
            ->where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal')
            ->take(3)
            ->get();

        $tagihanPending = Transaksi::where('id_pasien', $pasien->id_pasien)
            ->where('status', 'pending')
            ->count();

        $totalResep     = DetailResep::where('id_pasien', $pasien->id_pasien)->count();
        $totalTransaksi = Transaksi::where('id_pasien', $pasien->id_pasien)
                            ->where('status', 'lunas')->count();

        return view('pasien.dashboard', compact(
            'pasien',
            'antrianAktif',
            'resepTerbaru',
            'tagihanPending',
            'totalResep',
            'totalTransaksi'
        ));
    }

    // ────────────────────────────────────────────────────
    // RESEP
    // ────────────────────────────────────────────────────

    public function resep()
    {
        $pasien = $this->getPasien();

        $totalResep = Resep::whereHas('detailResep', function ($query) use ($pasien) {
            $query->where('id_pasien', $pasien->id_pasien);
        })->count();

        $totalResepDiproses = DetailResep::where('id_pasien', $pasien->id_pasien)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->count();

        $totalResepMenungguDibayar = DetailResep::where('id_pasien', $pasien->id_pasien)
            ->where('status', 'menunggu_bayar')
            ->count();
        
        $totalResepSelesai = DetailResep::where('id_pasien', $pasien->id_pasien)
            ->where('status', 'selesai')
            ->count();

        $resepList = DetailResep::with(['dokter.user', 'resep.resepObat.obat'])
            ->where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal')
            ->paginate(10);

        return view('pasien.resep', compact('resepList', 'totalResep', 'totalResepDiproses', 'totalResepMenungguDibayar', 'totalResepSelesai'));
    }

    public function detailResep($id_detail_resep)
    {
        $pasien = $this->getPasien();

        $detail = DetailResep::with([
                'dokter.user',
                'resep.resepObat.obat.kategori',
            ])
            ->where('id_pasien', $pasien->id_pasien)
            ->findOrFail($id_detail_resep);

        return view('pasien.detailResep', compact('detail'));
    }

    // ────────────────────────────────────────────────────
    // PEMBAYARAN
    // ────────────────────────────────────────────────────

    public function pembayaran()
    {
        $pasien = $this->getPasien();

        $tagihan = Transaksi::with(['detailTransaksi.resep.detailResep.dokter.user'])
            ->where('id_pasien', $pasien->id_pasien)
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('pasien.pembayaran', compact('tagihan'));
    }

    public function riwayatPembayaran()
    {
        $pasien = $this->getPasien();

        $riwayat = Transaksi::with(['detailTransaksi.resep.detailResep.dokter.user'])
            ->where('id_pasien', $pasien->id_pasien)
            ->where('status', 'lunas')
            ->latest()
            ->paginate(10);

        return view('pasien.riwayatPembayaran', compact('riwayat'));
    }

    public function halamanBayar($id_transaksi)
    {
        $pasien = $this->getPasien();

        $transaksi = Transaksi::with([
                'detailTransaksi.resep.resepObat.obat',
                'detailTransaksi.resep.detailResep.dokter.user',
            ])
            ->where('id_pasien', $pasien->id_pasien)
            ->where('status', 'pending')
            ->findOrFail($id_transaksi);

        return view('pasien.halamanBayar', compact('transaksi'));
    }

    public function prosesBayar(Request $request)
    {
        $request->validate([
            'id_transaksi' => 'required|integer',
            'metode'       => 'required|in:tunai,bpjs,transfer,qris',
        ]);

        $pasien = $this->getPasien();

        $transaksi = Transaksi::where('id_pasien', $pasien->id_pasien)
            ->where('status', 'pending')
            ->findOrFail($request->id_transaksi);

        // Pasien memilih metode — status tetap pending sampai dikonfirmasi admin
        $transaksi->update(['metode' => $request->metode]);

        return redirect()->route('pasien.pembayaran')
            ->with('success', 'Pembayaran berhasil diajukan, menunggu konfirmasi admin.');
    }

    // ────────────────────────────────────────────────────
    // RATING DOKTER
    // ────────────────────────────────────────────────────

    public function rating()
    {
        $pasien = $this->getPasien();

        // FIX #3: filter null sebelum unique agar tidak crash
        // jika ada detail_resep dengan id_dokter null (resep ditolak dll.)
        $dokterDitangani = DetailResep::with('dokter.user')
            ->where('id_pasien', $pasien->id_pasien)
            ->where('status', 'selesai')
            ->whereNotNull('id_dokter')
            ->get()
            ->pluck('dokter')
            ->filter()               // buang null
            ->unique('id_dokter')    // unique berdasarkan key model
            ->values();              // reset index

        $sudahDirating = Rating::where('id_pasien', $pasien->id_pasien)
            ->pluck('id_dokter')
            ->toArray();

        return view('pasien.rating', compact('dokterDitangani', 'sudahDirating'));
    }

    public function simpanRating(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|exists:dokter,id_dokter',
            'rating'    => 'required|integer|min:1|max:5',
        ]);

        $pasien = $this->getPasien();

        $pernahDitangani = DetailResep::where('id_pasien', $pasien->id_pasien)
            ->where('id_dokter', $request->id_dokter)
            ->where('status', 'selesai')
            ->exists();

        if (! $pernahDitangani) {
            return back()->with('error', 'Anda hanya bisa memberi rating untuk dokter yang pernah menangani Anda.');
        }

        $sudahAda = Rating::where('id_dokter', $request->id_dokter)
            ->where('id_pasien', $pasien->id_pasien)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Anda sudah memberi rating untuk dokter ini.');
        }

        Rating::create([
            'id_dokter' => $request->id_dokter,
            'id_pasien' => $pasien->id_pasien,
            'rating'    => $request->rating,
        ]);

        return back()->with('success', 'Rating berhasil dikirim, terima kasih!');
    }

    // ────────────────────────────────────────────────────
    // PROFIL
    // ────────────────────────────────────────────────────

    public function profil()
    {
        $pasien = $this->getPasien()->load('user');

        return view('pasien.profil', compact('pasien'));
    }

    public function updateProfil(Request $request)
    {
        $pasien = $this->getPasien()->load('user');
        $user   = $pasien->user;

        $request->validate([
            'nama'             => 'required|string|max:100',
            'no_telp'          => 'nullable|string|max:15',
            'tanggal_lahir'    => 'nullable|date',
            // FIX #1: konsisten dengan enum DB ('Laki-laki','Perempuan')
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'alamat'           => 'nullable|string',
            'no_bpjs'          => 'nullable|string|max:13|unique:pasien,no_bpjs,' . $pasien->id_pasien . ',id_pasien',
            'riwayat_penyakit' => 'nullable|string',
        ]);

        $user->update([
            'nama'          => $request->nama,
            'no_telp'       => $request->no_telp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
        ]);

        $pasien->update([
            'no_bpjs'          => $request->no_bpjs,
            'riwayat_penyakit' => $request->riwayat_penyakit,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}