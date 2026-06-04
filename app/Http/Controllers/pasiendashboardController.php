<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasienDashboardController extends Controller
{
    public function dashboard()
    {
        $pasien = Auth::user();
        
        // Statistik Dashboard
        $statistik = [
            'resep_aktif' => 2,
            'menunggu_pembayaran' => 1,
            'sedang_diproses' => 1,
            'siap_diambil' => 0,
        ];
        
        // Resep Terbaru
        $resepTerbaru = [
            [
                'id' => 'RSP-2024-0051',
                'doctor' => 'Dr. Budi Santoso',
                'tanggal' => '20 Mei 2024',
                'status' => 'Sedang Diproses',
                'jumlah_obat' => 3,
                'total' => 'Rp 125.000'
            ],
            [
                'id' => 'RSP-2024-0048',
                'doctor' => 'Dr. Budi Santoso',
                'tanggal' => '15 Mei 2024',
                'status' => 'Selesai',
                'jumlah_obat' => 2,
                'total' => 'Rp 85.000'
            ]
        ];
        
        // Status Pesanan (Progress Timeline)
        $statusPesanan = [
            'nomor_order' => 'PD-2024-0077',
            'status_current' => 'Dibayar',
            'timeline' => [
                ['label' => 'Dibuat', 'completed' => true],
                ['label' => 'Dibayar', 'completed' => true, 'current' => true],
                ['label' => 'Diproses', 'completed' => false],
                ['label' => 'Siap', 'completed' => false]
            ]
        ];
        
        // Metode Pembayaran Aktif
        $metodePembayaran = [
            ['nama' => 'BPJS Kesehatan', 'status' => 'Aktif'],
            ['nama' => 'Mandiri', 'status' => 'Aktif']
        ];
        
        return view('pasien.dashboard', compact('pasien', 'statistik', 'resepTerbaru', 'statusPesanan', 'metodePembayaran'));
    }
    
    public function resep()
    {
        $pasien = Auth::user();
        
        // Daftar Resep dengan Detail
        $resepList = [
            [
                'id' => 'RSP-2024-0051',
                'doctor' => 'Dr. Budi Santoso',
                'tanggal' => '20 Mei 2024',
                'status' => 'Sedang Diproses',
                'status_badge' => 'warning',
                'total' => 'Rp 125.000',
                'obat' => [
                    ['nama' => 'Paracetamol 500mg', 'dosis' => '3x sehari', 'jumlah' => '30 Tablet', 'harga' => 'Rp 45.000'],
                    ['nama' => 'Amoxicillin 500mg', 'dosis' => '2x sehari', 'jumlah' => '20 Kapul', 'harga' => 'Rp 60.000'],
                    ['nama' => 'CTM 4mg', 'dosis' => '1x malam', 'jumlah' => '10 Tablet', 'harga' => 'Rp 20.000']
                ]
            ],
            [
                'id' => 'RSP-2024-0048',
                'doctor' => 'Dr. Budi Santoso',
                'tanggal' => '15 Mei 2024',
                'status' => 'Selesai',
                'status_badge' => 'success',
                'total' => 'Rp 85.000',
                'obat' => [
                    ['nama' => 'Vitamin D 1000IU', 'dosis' => '1x sehari', 'jumlah' => '60 Kapsul', 'harga' => 'Rp 85.000']
                ]
            ],
            [
                'id' => 'RSP-2024-0045',
                'doctor' => 'Dr. Rina Sari',
                'tanggal' => '10 Mei 2024',
                'status' => 'Selesai',
                'status_badge' => 'success',
                'total' => 'Rp 210.000',
                'obat' => [
                    ['nama' => 'Omeprazole 20mg', 'dosis' => '2x sehari', 'jumlah' => '60 Tablet', 'harga' => 'Rp 150.000'],
                    ['nama' => 'Antasida 500mg', 'dosis' => 'Sesuai kebutuhan', 'jumlah' => '20 Tablet', 'harga' => 'Rp 60.000']
                ]
            ],
            [
                'id' => 'RSP-2024-0040',
                'doctor' => 'Dr. Ahmad Wijaya',
                'tanggal' => '05 Mei 2024',
                'status' => 'Dibatalkan',
                'status_badge' => 'danger',
                'total' => 'Rp 95.000',
                'obat' => [
                    ['nama' => 'Ibuprofen 400mg', 'dosis' => '3x sehari', 'jumlah' => '20 Tablet', 'harga' => 'Rp 95.000']
                ]
            ],
            [
                'id' => 'RSP-2024-0035',
                'doctor' => 'Dr. Siti Nurhaliza',
                'tanggal' => '01 Mei 2024',
                'status' => 'Selesai',
                'status_badge' => 'success',
                'total' => 'Rp 175.000',
                'obat' => [
                    ['nama' => 'Antibiotik Azitromicin', 'dosis' => '1x sehari', 'jumlah' => '10 Kapsul', 'harga' => 'Rp 175.000']
                ]
            ]
        ];
        
        return view('pasien.resep', compact('pasien', 'resepList'));
    }
    
    public function pembayaran()
    {
        $pasien = Auth::user();
        
        // Daftar Pembayaran dengan Detail
        $pembayaranList = [
            [
                'nomor_invoice' => 'INV-2024-0077',
                'tanggal' => '20 Mei 2024',
                'resep_id' => 'RSP-2024-0051',
                'dokter' => 'Dr. Budi Santoso',
                'metode' => 'BPJS',
                'metode_badge' => 'primary',
                'total' => 'Rp 125.000',
                'status' => 'Menunggu',
                'status_badge' => 'warning',
                'subtotal_obat' => 'Rp 125.000',
                'biaya_layanan' => 'Rp 12.500',
                'diskon' => 'Rp 12.500',
                'total_bayar' => 'Rp 125.000'
            ],
            [
                'nomor_invoice' => 'INV-2024-0070',
                'tanggal' => '15 Mei 2024',
                'resep_id' => 'RSP-2024-0048',
                'dokter' => 'Dr. Budi Santoso',
                'metode' => 'BPJS',
                'metode_badge' => 'primary',
                'total' => 'Rp 85.000',
                'status' => 'Lunas',
                'status_badge' => 'success',
                'subtotal_obat' => 'Rp 85.000',
                'biaya_layanan' => 'Rp 8.500',
                'diskon' => 'Rp 8.500',
                'total_bayar' => 'Rp 85.000'
            ],
            [
                'nomor_invoice' => 'INV-2024-0065',
                'tanggal' => '10 Mei 2024',
                'resep_id' => 'RSP-2024-0045',
                'dokter' => 'Dr. Rina Sari',
                'metode' => 'Mandiri',
                'metode_badge' => 'info',
                'total' => 'Rp 210.000',
                'status' => 'Lunas',
                'status_badge' => 'success',
                'subtotal_obat' => 'Rp 210.000',
                'biaya_layanan' => 'Rp 21.000',
                'diskon' => 'Rp 0',
                'total_bayar' => 'Rp 231.000'
            ],
            [
                'nomor_invoice' => 'INV-2024-0058',
                'tanggal' => '05 Mei 2024',
                'resep_id' => 'RSP-2024-0040',
                'dokter' => 'Dr. Ahmad Wijaya',
                'metode' => 'Tunai',
                'metode_badge' => 'secondary',
                'total' => 'Rp 95.000',
                'status' => 'Gagal',
                'status_badge' => 'danger',
                'subtotal_obat' => 'Rp 95.000',
                'biaya_layanan' => 'Rp 9.500',
                'diskon' => 'Rp 0',
                'total_bayar' => 'Rp 104.500'
            ],
            [
                'nomor_invoice' => 'INV-2024-0050',
                'tanggal' => '01 Mei 2024',
                'resep_id' => 'RSP-2024-0035',
                'dokter' => 'Dr. Siti Nurhaliza',
                'metode' => 'BPJS',
                'metode_badge' => 'primary',
                'total' => 'Rp 175.000',
                'status' => 'Lunas',
                'status_badge' => 'success',
                'subtotal_obat' => 'Rp 175.000',
                'biaya_layanan' => 'Rp 17.500',
                'diskon' => 'Rp 17.500',
                'total_bayar' => 'Rp 175.000'
            ]
        ];
        
        // Detail pembayaran terbaru (untuk sidebar)
        $detailPembayaran = $pembayaranList[0];
        
        return view('pasien.pembayaran', compact('pasien', 'pembayaranList', 'detailPembayaran'));
    }

    /**
     * Halaman pembayaran barcode
     * GET /pasien/pembayaran/bayar/{invoice}
     */
    public function halamanBayar(Request $request, $invoice)
    {
        $pasien = Auth::user();

        // Baca metode dari query string (dikirim dari halaman pembayaran)
        $metode = $request->query('metode', 'Mandiri'); // default Mandiri
        $totalDariUrl = (int) $request->query('total', 0);

        // Kalau BPJS, total bayar = 0 (ditanggung pemerintah)
        $subtotal_obat  = 75000;
        $biaya_layanan  = 12500;
        $total_normal   = $subtotal_obat + $biaya_layanan; // 87500
        $total_bayar    = $metode === 'BPJS' ? 0 : $total_normal;

        // Data dummy — nanti diganti query dari database
        $detail = [
            'nomor_invoice' => $invoice,
            'resep_id'      => 'RSP-2026-0051',
            'tanggal'       => '08 Des 2026',
            'dokter'        => 'Dr. Budi Santoso',
            'jumlah_obat'   => 3,
            'subtotal_obat' => $subtotal_obat,
            'biaya_layanan' => $biaya_layanan,
            'diskon'        => $metode === 'BPJS' ? $total_normal : 0,
            'total_bayar'   => $total_bayar,
            'status'        => 'Menunggu',
            'metode'        => $metode,
        ];

        return view('pasien.bayar', compact('pasien', 'detail'));
    }


    public function prosesBayar(Request $request)
    {
        $request->validate([
            'invoice_id'  => 'required|string',
            'metode'      => 'required|in:BPJS,Mandiri',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        $pasien  = Auth::user();
        $metode  = $request->metode;
        $invoice = $request->invoice_id;
        $total   = $request->total_bayar;

        // Generate referensi unik
        $refCode = strtoupper(substr($metode, 0, 3))
                 . '-' . Carbon::now()->format('ymdHi')
                 . '-' . strtoupper(substr(uniqid(), -6));

        // -------------------------------------------------------
        // Di sini nanti disambungkan ke tabel pembayaran / transaksi
        // Contoh:
        // Pembayaran::create([
        //     'pasien_id'  => $pasien->id,
        //     'invoice_id' => $invoice,
        //     'metode'     => $metode,
        //     'total'      => $total,
        //     'kode_ref'   => $refCode,
        //     'status'     => 'menunggu_konfirmasi',
        // ]);
        // -------------------------------------------------------

        $responseData = [
            'success'    => true,
            'invoice_id' => $invoice,
            'metode'     => $metode,
            'total'      => $total,
            'kode_ref'   => $refCode,
            'waktu'      => Carbon::now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm'),
        ];

        // Jika request AJAX (dari fetch JS), kembalikan JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($responseData);
        }

        // Jika request biasa, redirect balik dengan flash data
        return redirect()
            ->route('pasien.pembayaran.index')
            ->with('bayar_sukses', $responseData);
    }
}