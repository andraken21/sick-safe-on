<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use App\Models\Dokter;
use App\Models\Medicine;
use App\Models\Pasien;
use App\Models\Prescription;
use App\Models\Transaction;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'pasien' => Pasien::count(),
            'dokter' => Dokter::count(),
            'apoteker' => Apoteker::count(),
            'resep_bulan_ini' => Prescription::whereMonth('Tanggal', now()->month)
                ->whereYear('Tanggal', now()->year)
                ->count(),
        ];

        $lowStockMedicines = Medicine::orderBy('Stok')->limit(4)->get();
        $recentTransactions = $this->transactionQuery()->limit(4)->get();

        return view('admin.dashboard', compact('stats', 'lowStockMedicines', 'recentTransactions'));
    }

    public function kelolaAkunPengguna()
    {
        $users = User::latest('created_at')->paginate(10);

        return view('admin.kelolaAkunPengguna', compact('users'));
    }

    public function kelolaDataObat()
    {
        $medicines = Medicine::orderBy('Nama_Obat')->get()->map(function (Medicine $medicine) {
            $stock = (int) $medicine->Stok;
            $minimum = 10;

            return [
                'id' => $medicine->ID_Obat,
                'code' => 'OBT-' . str_pad((string) $medicine->ID_Obat, 3, '0', STR_PAD_LEFT),
                'name' => $medicine->Nama_Obat,
                'category' => 'umum',
                'stock' => $stock,
                'min' => $minimum,
                'price' => (float) $medicine->Harga,
                'supplier' => '-',
                'exp' => optional($medicine->Tanggal_Kadaluarsa)->format('Y-m-d') ?? now()->addYear()->format('Y-m-d'),
                'status' => $this->stockStatus($stock, $minimum),
            ];
        });

        return view('admin.kelolaDataObat', compact('medicines'));
    }

    public function laporanAnalisisData()
    {
        $monthlyRevenue = Transaction::where('Status', 'lunas')
            ->whereMonth('Tanggal_Bayar', now()->month)
            ->whereYear('Tanggal_Bayar', now()->year)
            ->sum('Total_Bayar');

        $averageTransaction = Transaction::where('Status', 'lunas')->avg('Total_Bayar') ?? 0;
        $transactionCountThisMonth = Transaction::whereMonth('Tanggal_Bayar', now()->month)
            ->whereYear('Tanggal_Bayar', now()->year)
            ->count();

        $reports = [
            [
                'name' => 'Laporan Transaksi ' . now()->translatedFormat('F Y'),
                'date' => now()->format('d M Y'),
                'meta' => $transactionCountThisMonth . ' transaksi',
                'icon' => 'fa-file-pdf',
            ],
            [
                'name' => 'Laporan Stok Obat',
                'date' => now()->format('d M Y'),
                'meta' => Medicine::count() . ' item obat',
                'icon' => 'fa-file-excel',
            ],
            [
                'name' => 'Analisis Pengguna Sistem',
                'date' => now()->format('d M Y'),
                'meta' => User::count() . ' pengguna',
                'icon' => 'fa-file-chart-column',
            ],
        ];

        return view('admin.laporanAnalisisData', compact('monthlyRevenue', 'averageTransaction', 'reports'));
    }

    public function pantauTransaksi()
    {
        $transactions = $this->transactionQuery()->paginate(10);

        $summary = [
            'total' => Transaction::whereMonth('Tanggal_Bayar', now()->month)
                ->whereYear('Tanggal_Bayar', now()->year)
                ->count(),
            'selesai' => Transaction::where('Status', 'lunas')->count(),
            'selesai_nominal' => Transaction::where('Status', 'lunas')->sum('Total_Bayar'),
            'pending' => Transaction::where('Status', 'pending')->count(),
            'pending_nominal' => Transaction::where('Status', 'pending')->sum('Total_Bayar'),
            'gagal' => Transaction::where('Status', 'gagal')->count(),
            'gagal_nominal' => Transaction::where('Status', 'gagal')->sum('Total_Bayar'),
        ];

        return view('admin.pantauTransaksi', compact('transactions', 'summary'));
    }

    private function transactionQuery()
    {
        return Transaction::with([
            'prescription.pasien.user',
            'prescription.dokter.user',
            'prescription.apoteker.user',
        ])->latest('created_at');
    }

    private function stockStatus(int $stock, int $minimum): string
    {
        if ($stock <= 0) {
            return 'habis';
        }

        if ($stock < $minimum) {
            return 'menipis';
        }

        return 'aman';
    }
}
