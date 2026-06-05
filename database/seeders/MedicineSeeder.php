<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medicines')->insert([
            ['nama_obat' => 'Paracetamol 500mg',  'stok' => 200, 'harga' => 5000,  'tanggal_produksi' => '2024-01-01', 'tanggal_kadaluarsa' => '2027-01-01'],
            ['nama_obat' => 'Amoxicillin 500mg',  'stok' => 150, 'harga' => 8000,  'tanggal_produksi' => '2024-02-01', 'tanggal_kadaluarsa' => '2027-02-01'],
            ['nama_obat' => 'Antasida Tablet',    'stok' => 100, 'harga' => 4000,  'tanggal_produksi' => '2024-03-01', 'tanggal_kadaluarsa' => '2027-03-01'],
            ['nama_obat' => 'Metformin 500mg',    'stok' => 120, 'harga' => 12000, 'tanggal_produksi' => '2024-04-01', 'tanggal_kadaluarsa' => '2027-04-01'],
            ['nama_obat' => 'Amlodipine 5mg',     'stok' => 80,  'harga' => 15000, 'tanggal_produksi' => '2024-05-01', 'tanggal_kadaluarsa' => '2027-05-01'],
            ['nama_obat' => 'Salbutamol Inhaler', 'stok' => 50,  'harga' => 35000, 'tanggal_produksi' => '2024-06-01', 'tanggal_kadaluarsa' => '2027-06-01'],
            ['nama_obat' => 'Simvastatin 20mg',   'stok' => 90,  'harga' => 10000, 'tanggal_produksi' => '2024-07-01', 'tanggal_kadaluarsa' => '2027-07-01'],
            ['nama_obat' => 'Allopurinol 100mg',  'stok' => 70,  'harga' => 7000,  'tanggal_produksi' => '2024-08-01', 'tanggal_kadaluarsa' => '2027-08-01'],
            ['nama_obat' => 'Vitamin C 500mg',    'stok' => 300, 'harga' => 3000,  'tanggal_produksi' => '2024-09-01', 'tanggal_kadaluarsa' => '2027-09-01'],
            ['nama_obat' => 'Ibuprofen 400mg',    'stok' => 160, 'harga' => 6000,  'tanggal_produksi' => '2024-10-01', 'tanggal_kadaluarsa' => '2027-10-01'],
            ['nama_obat' => 'Cetirizine 10mg',    'stok' => 110, 'harga' => 5500,  'tanggal_produksi' => '2024-11-01', 'tanggal_kadaluarsa' => '2027-11-01'],
            ['nama_obat' => 'Omeprazole 20mg',    'stok' => 130, 'harga' => 9000,  'tanggal_produksi' => '2024-12-01', 'tanggal_kadaluarsa' => '2027-12-01'],
        ]);
    }
}