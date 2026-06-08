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
        $stats = [
            'total_resep' => DetailResep::where('id_pasien', $pasien->id_pasien)
                ->count(),
            'menunggu_bayar' => DetailResep::where('id_pasien', $pasien->id_pasien)
                ->where('status', 'menunggu_pembayaran')
                ->count(),
            'sedang_diproses' => DetailResep::where('id_pasien', $pasien->id_pasien)
                ->where('status', 'diproses')
                ->count(),
            'siap_diambil' => DetailResep::where('id_pasien', $pasien->id_pasien)
                ->where('status', 'selesai')
                ->count(),
        ];
        $resepList = $resepTerbaru
            ->map(fn ($detail) => (object) $this->formatResep($detail))
            ->values();

        return view('pasien.dashboard', compact(
            'pasien',
            'antrianAktif',
            'resepTerbaru',
            'resepList',
            'stats',
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
            ->where('status', 'menunggu_pembayaran')
            ->count();
        
        $totalResepSelesai = DetailResep::where('id_pasien', $pasien->id_pasien)
            ->where('status', 'selesai')
            ->count();

        $resepList = DetailResep::with(['dokter.user', 'resep.resepObat.obat'])
            ->where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal')
            ->paginate(10);
        $resepData = $resepList->getCollection()
            ->map(fn ($detail) => $this->formatResep($detail))
            ->values();

        return view('pasien.resep', compact('resepList', 'resepData', 'totalResep', 'totalResepDiproses', 'totalResepMenungguDibayar', 'totalResepSelesai'));
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

        $transaksiList = Transaksi::with([
                'detailTransaksi.resep.resepObat.obat',
                'detailTransaksi.resep.detailResep.dokter.user',
            ])
            ->where('id_pasien', $pasien->id_pasien)
            ->latest()
            ->get();

        $pembayaranList = $transaksiList
            ->map(fn ($transaksi) => $this->formatPembayaran($transaksi))
            ->values();

        $detailPembayaran = $pembayaranList
            ->first(fn ($item) => strtolower($item['status']) === 'menunggu');

        $totalDibayar = $transaksiList->where('status', 'lunas')->sum('total_bayar');
        $menungguBayar = $transaksiList->where('status', 'pending')->count();
        $totalLunas = $transaksiList->where('status', 'lunas')->count();

        return view('pasien.pembayaran', compact(
            'pembayaranList',
            'detailPembayaran',
            'totalDibayar',
            'menungguBayar',
            'totalLunas'
        ));
    }

    public function riwayatPembayaran()
    {
        $pasien = $this->getPasien();

        $riwayat = Transaksi::with(['detailTransaksi.resep.detailResep.dokter.user'])
            ->where('id_pasien', $pasien->id_pasien)
            ->where('status', 'lunas')
            ->latest()
            ->paginate(10);

        return redirect()->route('pasien.pembayaran');
    }

    public function halamanBayar($id_transaksi)
    {
        $pasien = $this->getPasien()->load('user');

        $transaksi = Transaksi::with([
                'detailTransaksi.resep.resepObat.obat',
                'detailTransaksi.resep.detailResep.dokter.user',
            ])
            ->where('id_pasien', $pasien->id_pasien)
            ->where('status', 'pending')
            ->findOrFail($id_transaksi);

        $detail = $this->formatPembayaran($transaksi);

        return view('pasien.bayar', compact('pasien', 'detail'));
    }

    public function prosesBayar(Request $request)
    {
        $request->validate([
            'invoice_id'  => 'required|string',
            'metode'      => 'required|in:BPJS,Mandiri,bpjs,transfer,qris',
            'total_bayar' => 'nullable|numeric|min:0',
        ]);

        $pasien = $this->getPasien();
        $idTransaksi = $this->parseInvoiceId($request->invoice_id);

        $transaksi = Transaksi::where('id_pasien', $pasien->id_pasien)
            ->where('status', 'pending')
            ->findOrFail($idTransaksi);

        // Pasien memilih metode — status tetap pending sampai dikonfirmasi admin
        $metode = $this->normalizeMetode($request->metode);

        $transaksi->update([
            'metode' => $metode,
            'total_bayar' => $request->filled('total_bayar')
                ? $request->total_bayar
                : $transaksi->total_bayar,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diajukan.',
                'kode_ref' => strtoupper($metode) . '-' . now()->format('His') . '-' . $transaksi->id_transaksi,
                'waktu' => now()->format('d M Y H:i'),
            ]);
        }

        return redirect()->route('pasien.pembayaran')
            ->with('success', 'Pembayaran berhasil diajukan, menunggu konfirmasi admin.');
    }

    // ────────────────────────────────────────────────────
    // RATING DOKTER
    // ────────────────────────────────────────────────────

    private function formatResep(DetailResep $detail): array
    {
        $total = (int) ($detail->resep?->resepObat?->sum(function ($resepObat) {
            return ((int) $resepObat->jumlah) * ((int) ($resepObat->obat->harga ?? 0));
        }) ?? 0);

        return [
            'nomor' => $this->makeResepId($detail->id_resep),
            'tanggal' => optional($detail->tanggal)->format('Y-m-d') ?? optional($detail->created_at)->format('Y-m-d') ?? now()->format('Y-m-d'),
            'dokter' => $detail->dokter?->user?->nama ?? 'Dokter belum tersedia',
            'jumlah_obat' => (int) ($detail->resep?->resepObat?->count() ?? $detail->total_obat ?? 0),
            'obat' => (int) ($detail->resep?->resepObat?->count() ?? $detail->total_obat ?? 0),
            'total' => $total,
            'status' => $this->displayResepStatus($detail->status),
            'status_key' => $this->resepStatusKey($detail->status),
            'icon' => $detail->status === 'selesai' ? 'fa-check' : 'fa-file-prescription',
            'iconClass' => $detail->status === 'selesai'
                ? 'resep-icon-sm resep-icon-sm--done'
                : 'resep-icon-sm resep-icon-sm--warn',
        ];
    }

    private function formatPembayaran(Transaksi $transaksi): array
    {
        $detailTransaksi = $transaksi->detailTransaksi->first();
        $resep = $detailTransaksi?->resep;
        $detailResep = $resep?->detailResep;
        $dokter = $detailResep?->dokter?->user?->nama ?? 'Dokter belum tersedia';
        $subtotalObat = (int) ($resep?->resepObat?->sum(function ($resepObat) {
            return ((int) $resepObat->jumlah) * ((int) ($resepObat->obat->harga ?? 0));
        }) ?? $transaksi->total_bayar);
        $biayaLayanan = 12500;
        $metode = $this->displayMetode($transaksi->metode);
        $isBpjs = $metode === 'BPJS';
        $totalNormal = $subtotalObat + $biayaLayanan;
        $diskon = $isBpjs ? $totalNormal : 0;

        return [
            'id_transaksi' => $transaksi->id_transaksi,
            'nomor_invoice' => $this->makeInvoiceId($transaksi->id_transaksi),
            'resep_id' => $resep ? $this->makeResepId($resep->id_resep) : '-',
            'tanggal' => optional($transaksi->created_at)->format('d M Y') ?? '-',
            'dokter' => $dokter,
            'jumlah_obat' => (int) ($resep?->resepObat?->count() ?? 0),
            'subtotal_obat' => $subtotalObat,
            'biaya_layanan' => $biayaLayanan,
            'total' => $totalNormal,
            'diskon' => $diskon,
            'total_bayar' => $isBpjs ? 0 : (int) $transaksi->total_bayar,
            'metode' => $metode,
            'status' => $this->displayStatus($transaksi->status),
        ];
    }

    private function makeInvoiceId(int $id): string
    {
        return 'INV-' . now()->year . '-' . str_pad((string) $id, 4, '0', STR_PAD_LEFT);
    }

    private function makeResepId(int $id): string
    {
        return 'RSP-' . str_pad((string) $id, 4, '0', STR_PAD_LEFT);
    }

    private function parseInvoiceId(string $invoiceId): int
    {
        if (is_numeric($invoiceId)) {
            return (int) $invoiceId;
        }

        return (int) preg_replace('/\D+/', '', substr($invoiceId, strrpos($invoiceId, '-') + 1));
    }

    private function normalizeMetode(string $metode): string
    {
        return match (strtolower($metode)) {
            'bpjs' => 'bpjs',
            'mandiri', 'transfer' => 'transfer',
            default => 'qris',
        };
    }

    private function displayMetode(?string $metode): string
    {
        return match ($metode) {
            'bpjs' => 'BPJS',
            'transfer' => 'Mandiri',
            'qris' => 'QRIS',
            default => 'Mandiri',
        };
    }

    private function displayStatus(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'lunas' => 'Lunas',
            'batal' => 'Gagal',
            default => ucfirst($status),
        };
    }

    private function displayResepStatus(string $status): string
    {
        return match ($status) {
            'menunggu' => 'Menunggu Validasi',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }

    private function resepStatusKey(string $status): string
    {
        return match ($status) {
            'menunggu_pembayaran' => 'tunggu',
            'diproses' => 'proses',
            'selesai' => 'selesai',
            'ditolak' => 'batal',
            default => 'proses',
        };
    }

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
