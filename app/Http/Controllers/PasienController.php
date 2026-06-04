<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function dashboard()
    {
        $pasien = Auth::user();

        $statistik = [
            'resep_aktif'         => 2,
            'menunggu_pembayaran' => 1,
            'sedang_diproses'     => 1,
            'siap_diambil'        => 0,
        ];

        $resepTerbaru = [
            [
                'id'          => 'RSP-2024-0051',
                'doctor'      => 'Dr. Budi Santoso',
                'tanggal'     => '20 Mei 2024',
                'status'      => 'Sedang Diproses',
                'jumlah_obat' => 3,
                'total'       => 'Rp 125.000',
            ],
            [
                'id'          => 'RSP-2024-0048',
                'doctor'      => 'Dr. Budi Santoso',
                'tanggal'     => '15 Mei 2024',
                'status'      => 'Selesai',
                'jumlah_obat' => 2,
                'total'       => 'Rp 85.000',
            ],
        ];

        $statusPesanan = [
            'nomor_order'    => 'PD-2024-0077',
            'status_current' => 'Dibayar',
            'timeline'       => [
                ['label' => 'Dibuat',   'completed' => true],
                ['label' => 'Dibayar',  'completed' => true, 'current' => true],
                ['label' => 'Diproses', 'completed' => false],
                ['label' => 'Siap',     'completed' => false],
            ],
        ];

        $metodePembayaran = [
            ['nama' => 'BPJS Kesehatan', 'status' => 'Aktif'],
            ['nama' => 'Mandiri',        'status' => 'Aktif'],
        ];

        return view('pasien.dashboard', compact(
            'pasien', 'statistik', 'resepTerbaru', 'statusPesanan', 'metodePembayaran'
        ));
    }

    public function resep()
    {
        $pasien = Auth::user();

        $resepList = [
            [
                'id'           => 'RSP-2024-0051',
                'doctor'       => 'Dr. Budi Santoso',
                'tanggal'      => '20 Mei 2024',
                'status'       => 'Sedang Diproses',
                'status_badge' => 'warning',
                'total'        => 'Rp 125.000',
                'obat'         => [
                    ['nama' => 'Paracetamol 500mg', 'dosis' => '3x sehari', 'jumlah' => '30 Tablet', 'harga' => 'Rp 45.000'],
                    ['nama' => 'Amoxicillin 500mg',  'dosis' => '2x sehari', 'jumlah' => '20 Kapsul', 'harga' => 'Rp 60.000'],
                    ['nama' => 'CTM 4mg',            'dosis' => '1x malam',  'jumlah' => '10 Tablet', 'harga' => 'Rp 20.000'],
                ],
            ],
            [
                'id'           => 'RSP-2024-0048',
                'doctor'       => 'Dr. Budi Santoso',
                'tanggal'      => '15 Mei 2024',
                'status'       => 'Selesai',
                'status_badge' => 'success',
                'total'        => 'Rp 85.000',
                'obat'         => [
                    ['nama' => 'Vitamin D 1000IU', 'dosis' => '1x sehari', 'jumlah' => '60 Kapsul', 'harga' => 'Rp 85.000'],
                ],
            ],
        ];

        return view('pasien.resep', compact('pasien', 'resepList'));
    }

    public function pembayaran()
    {
        $pasien = Auth::user();

        $pembayaranList = [
            [
                'nomor_invoice' => 'INV-2026-0077',
                'tanggal'       => '20 Mei 2026',
                'resep_id'      => 'RSP-2026-0051',
                'dokter'        => 'Dr. Budi Santoso',
                'metode'        => 'BPJS',
                'metode_badge'  => 'primary',
                'total'         => 87500,
                'status'        => 'Menunggu',
                'status_badge'  => 'warning',
                'subtotal_obat' => 75000,
                'biaya_layanan' => 12500,
                'diskon'        => 87500,
                'total_bayar'   => 0,
            ],
            [
                'nomor_invoice' => 'INV-2024-0070',
                'tanggal'       => '15 Mei 2024',
                'resep_id'      => 'RSP-2024-0048',
                'dokter'        => 'Dr. Budi Santoso',
                'metode'        => 'BPJS',
                'metode_badge'  => 'primary',
                'total'         => 85000,
                'status'        => 'Lunas',
                'status_badge'  => 'success',
                'subtotal_obat' => 85000,
                'biaya_layanan' => 8500,
                'diskon'        => 93500,
                'total_bayar'   => 0,
            ],
            [
                'nomor_invoice' => 'INV-2024-0065',
                'tanggal'       => '10 Mei 2024',
                'resep_id'      => 'RSP-2024-0045',
                'dokter'        => 'Dr. Rina Sari',
                'metode'        => 'Mandiri',
                'metode_badge'  => 'info',
                'total'         => 210000,
                'status'        => 'Lunas',
                'status_badge'  => 'success',
                'subtotal_obat' => 210000,
                'biaya_layanan' => 21000,
                'diskon'        => 0,
                'total_bayar'   => 231000,
            ],
        ];

        $detailPembayaran = $pembayaranList[0];

        return view('pasien.pembayaran', compact('pasien', 'pembayaranList', 'detailPembayaran'));
    }

    /**
     * Halaman pembayaran penuh.
     * GET /pasien/pembayaran/bayar/{invoice}?metode=BPJS
     */
    public function halamanBayar(Request $request, string $invoice)
    {
        $pasien = Auth::user();

        // Ambil & validasi metode dari query string
        $metode = $request->query('metode', 'Mandiri');
        $metode = in_array($metode, ['BPJS', 'Mandiri']) ? $metode : 'Mandiri';

        $subtotal_obat = 75000;
        $biaya_layanan = 12500;
        $total_normal  = $subtotal_obat + $biaya_layanan;

        $diskon      = $metode === 'BPJS' ? $total_normal : 0;
        $total_bayar = $total_normal - $diskon;

        $detail = [
            'nomor_invoice' => $invoice,
            'resep_id'      => 'RSP-2026-0051',
            'tanggal'       => Carbon::now()->translatedFormat('d F Y'),
            'dokter'        => 'Dr. Budi Santoso',
            'jumlah_obat'   => 3,
            'status'        => 'Menunggu Pembayaran',
            'metode'        => $metode,
            'subtotal_obat' => $subtotal_obat,
            'biaya_layanan' => $biaya_layanan,
            'diskon'        => $diskon,
            'total_bayar'   => $total_bayar,
        ];

        return view('pasien.bayar', compact('pasien', 'detail'));
    }

    /**
     * Proses pembayaran via AJAX POST.
     * POST /pasien/pembayaran/proses
     */
    public function prosesBayar(Request $request)
    {
        // TODO: Simpan ke database, update status invoice, kirim notifikasi apoteker, dll.
        return response()->json([
            'success'  => true,
            'message'  => 'Pembayaran berhasil dikirim ke apoteker.',
            'kode_ref' => 'REF-' . strtoupper(uniqid()),
            'waktu'    => now()->format('d M Y, H:i'),
        ]);
    }
}