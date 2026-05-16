<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transactions')->insert([
            ['ID_Resep' => 1,  'Metode' => 'BPJS',     'Total_Bayar' => 0,      'Status' => 'lunas',   'Tanggal_Bayar' => '2026-01-10'],
            ['ID_Resep' => 2,  'Metode' => 'Cash',     'Total_Bayar' => 450000, 'Status' => 'lunas',   'Tanggal_Bayar' => '2026-01-20'],
            ['ID_Resep' => 3,  'Metode' => 'Transfer', 'Total_Bayar' => 300000, 'Status' => 'lunas',   'Tanggal_Bayar' => '2026-02-05'],
            ['ID_Resep' => 4,  'Metode' => 'Cash',     'Total_Bayar' => 80000,  'Status' => 'lunas',   'Tanggal_Bayar' => '2026-02-18'],
            ['ID_Resep' => 5,  'Metode' => 'BPJS',     'Total_Bayar' => 0,      'Status' => 'lunas',   'Tanggal_Bayar' => '2026-03-01'],
            ['ID_Resep' => 6,  'Metode' => 'Transfer', 'Total_Bayar' => 35000,  'Status' => 'lunas',   'Tanggal_Bayar' => '2026-03-15'],
            ['ID_Resep' => 7,  'Metode' => 'Cash',     'Total_Bayar' => 360000, 'Status' => 'pending', 'Tanggal_Bayar' => null],
            ['ID_Resep' => 8,  'Metode' => 'Transfer', 'Total_Bayar' => 120000, 'Status' => 'pending', 'Tanggal_Bayar' => null],
            ['ID_Resep' => 9,  'Metode' => null,       'Total_Bayar' => 0,      'Status' => 'pending', 'Tanggal_Bayar' => null],
            ['ID_Resep' => 10, 'Metode' => null,       'Total_Bayar' => 0,      'Status' => 'pending', 'Tanggal_Bayar' => null],
        ]);
    }
}
