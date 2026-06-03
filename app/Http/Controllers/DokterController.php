<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Antrian;
use App\Models\Resep;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DokterController extends Controller
{
    /* ================================================================
       DASHBOARD
    ================================================================ */
    public function dashboard()
    {
        $today = Carbon::today();

        $antrians      = Antrian::with(['pasien.user'])
                            ->whereDate('created_at', $today)
                            ->orderBy('nomor_antrian')
                            ->limit(4)
                            ->get();

        $totalAntrian  = Antrian::whereDate('created_at', $today)->count();
        $totalMenunggu = Antrian::whereDate('created_at', $today)->where('status', 'menunggu')->count();
        $totalSelesai  = Antrian::whereDate('created_at', $today)->where('status', 'selesai')->count();
        $totalResep    = Resep::whereDate('created_at', $today)->count();

        $resepTerbaru  = Resep::with('pasien.user')->latest()->limit(5)->get();

        return view('dokter.dashboard', compact(
            'antrians', 'totalAntrian', 'totalMenunggu', 'totalSelesai',
            'totalResep', 'resepTerbaru'
        ));
    }

    public function antrianCount()
    {
        $today = Carbon::today();
        return response()->json([
            'total'    => Antrian::whereDate('created_at', $today)->count(),
            'menunggu' => Antrian::whereDate('created_at', $today)->where('status', 'menunggu')->count(),
            'selesai'  => Antrian::whereDate('created_at', $today)->where('status', 'selesai')->count(),
        ]);
    }

    /* ================================================================
       PILIH PASIEN
    ================================================================ */
    public function pilihPasien(Request $request)
    {
        $query = Pasien::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('nama', 'like', "%{$search}%"))
                  ->orWhere('No_BPJS',          'like', "%{$search}%")
                  ->orWhere('Riwayat_Penyakit', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('Jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('status')) {
            $query->whereHas('user', fn($u) => $u->where('status', $request->status));
        }

        $pasiens        = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $totalPasien    = Pasien::count();
        $totalAktif     = Pasien::whereHas('user', fn($u) => $u->where('status', 'aktif'))->count();
        $totalPerempuan = Pasien::where('Jenis_kelamin', 'Perempuan')->count();
        $totalLakiLaki  = Pasien::where('Jenis_kelamin', 'Laki-laki')->count();

        return view('dokter.pilih-pasien', compact(
            'pasiens', 'totalPasien', 'totalAktif', 'totalPerempuan', 'totalLakiLaki'
        ));
    }

    /* ================================================================
       BUAT RESEP — Form
       Route: GET /dokter/resep/buat/{pasien}
    ================================================================ */
    public function buatResep(Pasien $pasien)
    {
        // Load relasi user agar bisa dipakai di blade
        $pasien->load('user');

        // Generate kode resep otomatis: RSP-YYYY-XXXX
        $tahun      = Carbon::now()->format('Y');
        $lastResep  = Resep::whereYear('created_at', $tahun)->orderBy('id', 'desc')->first();
        $nextNumber = $lastResep ? ((int) substr($lastResep->kode_resep, -4)) + 1 : 1;
        $kodeResep  = 'RSP-' . $tahun . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('dokter.buat-resep', compact('pasien', 'kodeResep'));
    }

    /* ================================================================
       BUAT RESEP — Store
       Route: POST /dokter/resep/store
    ================================================================ */
    public function storeResep(Request $request)
    {
        $request->validate([
            'id_pasien'      => 'required|exists:pasiens,ID_Pasien',
            'kode_resep'     => 'required|string|unique:reseps,kode_resep',
            'keluhan'        => 'required|string|max:1000',
            'nama_diagnosa'  => 'required|string|max:255',
            'kode_diagnosa'  => 'nullable|string|max:50',
            'catatan'        => 'nullable|string|max:1000',
            'status'         => 'required|in:terkirim,draft',
            'obat'           => 'required|array|min:1',
            'obat.*.nama_obat'    => 'required|string|max:255',
            'obat.*.dosis'        => 'nullable|string|max:100',
            'obat.*.jumlah'       => 'nullable|integer|min:1',
            'obat.*.satuan'       => 'nullable|string|max:50',
            'obat.*.aturan_pakai' => 'nullable|string|max:100',
            'obat.*.keterangan'   => 'nullable|string|max:255',
        ], [
            'id_pasien.required'     => 'Pasien tidak ditemukan.',
            'keluhan.required'       => 'Keluhan utama wajib diisi.',
            'nama_diagnosa.required' => 'Nama diagnosa wajib diisi.',
            'obat.required'          => 'Tambahkan minimal 1 obat.',
            'obat.min'               => 'Tambahkan minimal 1 obat.',
            'obat.*.nama_obat.required' => 'Nama obat tidak boleh kosong.',
        ]);

        DB::beginTransaction();
        try {
            // Simpan header resep
            $resep = Resep::create([
                'kode_resep'    => $request->kode_resep,
                'id_pasien'     => $request->id_pasien,
                'id_dokter'     => auth()->id(),
                'keluhan'       => $request->keluhan,
                'kode_diagnosa' => $request->kode_diagnosa,
                'nama_diagnosa' => $request->nama_diagnosa,
                'catatan'       => $request->catatan,
                'status'        => $request->status,
                'tanggal_resep' => Carbon::today(),
            ]);

            // Simpan detail obat
            foreach ($request->obat as $item) {
                ResepObat::create([
                    'id_resep'    => $resep->id,
                    'nama_obat'   => $item['nama_obat'],
                    'dosis'       => $item['dosis']        ?? null,
                    'jumlah'      => $item['jumlah']       ?? null,
                    'satuan'      => $item['satuan']       ?? null,
                    'aturan_pakai'=> $item['aturan_pakai'] ?? null,
                    'keterangan'  => $item['keterangan']   ?? null,
                ]);
            }

            DB::commit();

            $pesan = $request->status === 'terkirim'
                ? 'Resep berhasil dikirim ke apoteker.'
                : 'Resep disimpan sebagai draft.';

            return redirect()->route('dokter.resep.index')
                             ->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                         ->withErrors(['error' => 'Gagal menyimpan resep: ' . $e->getMessage()]);
        }
    }

    /* ================================================================
       DAFTAR RESEP
       Route: GET /dokter/resep
    ================================================================ */
    public function daftarResep(Request $request)
    {
        $query = Resep::with(['pasien.user'])->where('id_dokter', auth()->id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_resep', 'like', "%{$search}%")
                  ->orWhereHas('pasien.user', fn($u) => $u->where('nama', 'like', "%{$search}%"))
                  ->orWhere('nama_diagnosa', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reseps = $query->latest()->paginate(10)->withQueryString();

        return view('dokter.daftar-resep', compact('reseps'));
    }

    /* ================================================================
       DETAIL RESEP
       Route: GET /dokter/resep/{resep}
    ================================================================ */
    public function detailResep(Resep $resep)
    {
        $resep->load(['pasien.user', 'obats']);
        return view('dokter.detail-resep', compact('resep'));
    }

    /* ================================================================
       EDIT RESEP — hanya resep berstatus draft
       Route: GET /dokter/resep/{resep}/edit
    ================================================================ */
    public function editResep(Resep $resep)
    {
        if ($resep->status !== 'draft') {
            return back()->with('error', 'Resep yang sudah terkirim tidak dapat diedit.');
        }
        $resep->load(['pasien.user', 'obats']);
        return view('dokter.edit-resep', compact('resep'));
    }

    /* ================================================================
       UPDATE RESEP
       Route: PUT /dokter/resep/{resep}
    ================================================================ */
    public function updateResep(Request $request, Resep $resep)
    {
        if ($resep->status !== 'draft') {
            return back()->with('error', 'Resep yang sudah terkirim tidak dapat diedit.');
        }

        $request->validate([
            'keluhan'       => 'required|string|max:1000',
            'nama_diagnosa' => 'required|string|max:255',
            'kode_diagnosa' => 'nullable|string|max:50',
            'catatan'       => 'nullable|string|max:1000',
            'status'        => 'required|in:terkirim,draft',
            'obat'          => 'required|array|min:1',
            'obat.*.nama_obat' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $resep->update([
                'keluhan'       => $request->keluhan,
                'kode_diagnosa' => $request->kode_diagnosa,
                'nama_diagnosa' => $request->nama_diagnosa,
                'catatan'       => $request->catatan,
                'status'        => $request->status,
            ]);

            // Hapus detail lama & tulis ulang
            $resep->obats()->delete();
            foreach ($request->obat as $item) {
                ResepObat::create([
                    'id_resep'     => $resep->id,
                    'nama_obat'    => $item['nama_obat'],
                    'dosis'        => $item['dosis']         ?? null,
                    'jumlah'       => $item['jumlah']        ?? null,
                    'satuan'       => $item['satuan']        ?? null,
                    'aturan_pakai' => $item['aturan_pakai']  ?? null,
                    'keterangan'   => $item['keterangan']    ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('dokter.resep.index')
                             ->with('success', 'Resep berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                         ->withErrors(['error' => 'Gagal memperbarui resep: ' . $e->getMessage()]);
        }
    }

    /* ================================================================
       HAPUS RESEP — hanya draft
       Route: DELETE /dokter/resep/{resep}
    ================================================================ */
    public function hapusResep(Resep $resep)
    {
        if ($resep->status !== 'draft') {
            return back()->with('error', 'Hanya resep draft yang bisa dihapus.');
        }

        DB::transaction(function () use ($resep) {
            $resep->obats()->delete();
            $resep->delete();
        });

        return redirect()->route('dokter.resep.index')
                         ->with('success', 'Resep berhasil dihapus.');
    }
}