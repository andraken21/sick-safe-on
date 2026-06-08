<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DetailResep;
use App\Models\ResepObat;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Obat;

class ApotekerController extends Controller
{
    // ────────────────────────────────────────────────────
    // DASHBOARD
    // ────────────────────────────────────────────────────

    public function dashboard()
    {
        return view('apoteker.dashboard');
    }

    // ────────────────────────────────────────────────────
    // TAHAP 1 — MENUNGGU VALIDASI
    // Apoteker melihat resep baru dari dokter,
    // lalu memvalidasi (mengecek stok obat tersedia).
    // ────────────────────────────────────────────────────

    public function menungguValidasi()
    {
        $resepList = DetailResep::with([
                'pasien.user',
                'dokter.user',
                'resep.resepObat.obat',
            ])
            ->where('status', 'menunggu')
            ->latest('tanggal')
            ->paginate(10);

        return view('apoteker.menungguValidasi', compact('resepList'));
    }

    public function detailValidasi($id_detail_resep)
    {
        $detail = DetailResep::with([
                'pasien.user',
                'dokter.user',
                'resep.resepObat.obat.kategori',
            ])
            ->where('status', 'menunggu')
            ->findOrFail($id_detail_resep);

        return redirect()->route('apoteker.validasi');
    }

    public function validasi(Request $request, $id_detail_resep)
    {
        $detail = DetailResep::where('status', 'menunggu')
            ->findOrFail($id_detail_resep);

        // Ambil semua obat dalam resep
        $resepObatList = ResepObat::with('obat')
            ->where('id_resep', $detail->id_resep)
            ->get();

        // FIX #1: Cek stok menggunakan relasi eager-loaded (hindari N+1)
        foreach ($resepObatList as $item) {
            $obat = $item->obat;
            if (! $obat || $obat->stok < $item->jumlah) {
                $namaObat  = $obat->nama_obat ?? 'tidak diketahui';
                $stokAda   = $obat->stok      ?? 0;
                return back()->with(
                    'error',
                    "Stok obat \"{$namaObat}\" tidak mencukupi (stok: {$stokAda}, dibutuhkan: {$item->jumlah})."
                );
            }
        }

        // FIX #2: Hitung total bayar & jumlah item obat
        $totalBayar  = $resepObatList->sum(fn($item) => $item->obat->harga * $item->jumlah);
        $totalObjek  = $resepObatList->sum('jumlah'); // untuk field total_obat di detail_resep

        DB::transaction(function () use ($detail, $totalBayar, $totalObjek) {
            // FIX #3: Set total_obat sekaligus update status
            $detail->update([
                'status'     => 'menunggu_pembayaran',
                'total_obat' => $totalObjek,
            ]);

            // Buat record transaksi baru
            $transaksi = Transaksi::create([
                'id_pasien'   => $detail->id_pasien,
                'total_bayar' => $totalBayar,
                'status'      => 'pending',
                'metode'      => null,
            ]);

            // Hubungkan transaksi dengan resep
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_resep'     => $detail->id_resep,
            ]);
        });

        return redirect()->route('apoteker.validasi')
            ->with('success', 'Resep berhasil divalidasi, menunggu pembayaran pasien.');
    }

    public function tolakValidasi(Request $request, $id_detail_resep)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $detail = DetailResep::where('status', 'menunggu')
            ->findOrFail($id_detail_resep);

        $detail->update([
            'status'     => 'ditolak',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('apoteker.validasi')
            ->with('success', 'Resep berhasil ditolak.');
    }

    // ────────────────────────────────────────────────────
    // TAHAP 2 — MENUNGGU PEMBAYARAN
    // Apoteker melihat daftar resep yang sudah divalidasi.
    // Pasien sudah melakukan pembayaran (upload bukti).
    // Apoteker mengkonfirmasi bahwa pembayaran valid.
    // ────────────────────────────────────────────────────

    public function menungguPembayaran()
    {
        // FIX #4: Eager load yang benar — transaksi diakses melalui
        // resep → detailTransaksi → transaksi
        $resepList = DetailResep::with([
                'pasien.user',
                'dokter.user',
                'resep.detailTransaksi.transaksi',
            ])
            ->where('status', 'menunggu_pembayaran')
            ->latest('tanggal')
            ->paginate(10);

        return view('apoteker.menungguPembayaran', compact('resepList'));
    }

    public function konfirmasiPembayaran(Request $request, $id_detail_resep)
    {
        // FIX #5: Apoteker TIDAK menentukan metode pembayaran —
        // metode sudah diisi oleh pasien saat proses bayar.
        // Apoteker hanya mengkonfirmasi bahwa pembayaran valid.
        $detail = DetailResep::where('status', 'menunggu_pembayaran')
            ->findOrFail($id_detail_resep);

        // Ambil transaksi terkait melalui detail_transaksi
        $detailTransaksi = DetailTransaksi::where('id_resep', $detail->id_resep)
            ->firstOrFail();
        $transaksi = Transaksi::findOrFail($detailTransaksi->id_transaksi);

        // Pastikan pasien sudah upload / proses bayar (status harus 'pending')
        if ($transaksi->status !== 'pending') {
            return back()->with('error', 'Transaksi ini tidak dalam status pending.');
        }

        DB::transaction(function () use ($detail, $transaksi) {
            // Tandai transaksi lunas (metode tetap seperti yang dipilih pasien)
            $transaksi->update(['status' => 'lunas']);

            // Update status resep → diproses
            $detail->update(['status' => 'diproses']);
        });

        return redirect()->route('apoteker.pembayaran')
            ->with('success', 'Pembayaran dikonfirmasi, resep sedang diproses.');
    }

    // ────────────────────────────────────────────────────
    // TAHAP 3 — DIPROSES
    // Apoteker menyiapkan obat, mengurangi stok,
    // lalu menandai resep sebagai selesai.
    // ────────────────────────────────────────────────────

    public function diproses()
    {
        $resepList = DetailResep::with([
                'pasien.user',
                'dokter.user',
                'resep.resepObat.obat',
            ])
            ->where('status', 'diproses')
            ->latest('tanggal')
            ->paginate(10);

        return view('apoteker.diproses', compact('resepList'));
    }

    public function selesaikan($id_detail_resep)
    {
        $detail = DetailResep::where('status', 'diproses')
            ->findOrFail($id_detail_resep);

        // FIX #6: Eager load obat agar tidak N+1 query saat decrement
        $resepObatList = ResepObat::with('obat')
            ->where('id_resep', $detail->id_resep)
            ->get();

        DB::transaction(function () use ($detail, $resepObatList) {
            // Kurangi stok obat
            foreach ($resepObatList as $item) {
                Obat::where('id_obat', $item->id_obat)
                    ->decrement('stok', $item->jumlah);
            }

            // Update status obat yang stoknya habis
            Obat::where('stok', '<=', 0)->update(['status' => 'habis']);

            // Update status resep → selesai
            $detail->update(['status' => 'selesai']);
        });

        return redirect()->route('apoteker.diproses')
            ->with('success', 'Resep selesai, stok obat telah diperbarui.');
    }
}
