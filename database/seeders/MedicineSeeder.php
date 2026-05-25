<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medicines')->insert([
            ['Nama_Obat' => 'Paracetamol 500mg',  'Stok' => 200, 'Harga' => 5000,  'Tanggal_Produksi' => '2024-01-01', 'Tanggal_Kadaluarsa' => '2027-01-01'],
            ['Nama_Obat' => 'Amoxicillin 500mg',  'Stok' => 150, 'Harga' => 8000,  'Tanggal_Produksi' => '2024-02-01', 'Tanggal_Kadaluarsa' => '2027-02-01'],
            ['Nama_Obat' => 'Antasida Tablet',    'Stok' => 100, 'Harga' => 4000,  'Tanggal_Produksi' => '2024-03-01', 'Tanggal_Kadaluarsa' => '2027-03-01'],
            ['Nama_Obat' => 'Metformin 500mg',    'Stok' => 120, 'Harga' => 12000, 'Tanggal_Produksi' => '2024-04-01', 'Tanggal_Kadaluarsa' => '2027-04-01'],
            ['Nama_Obat' => 'Amlodipine 5mg',     'Stok' => 80,  'Harga' => 15000, 'Tanggal_Produksi' => '2024-05-01', 'Tanggal_Kadaluarsa' => '2027-05-01'],
            ['Nama_Obat' => 'Salbutamol Inhaler', 'Stok' => 50,  'Harga' => 35000, 'Tanggal_Produksi' => '2024-06-01', 'Tanggal_Kadaluarsa' => '2027-06-01'],
            ['Nama_Obat' => 'Simvastatin 20mg',   'Stok' => 90,  'Harga' => 10000, 'Tanggal_Produksi' => '2024-07-01', 'Tanggal_Kadaluarsa' => '2027-07-01'],
            ['Nama_Obat' => 'Allopurinol 100mg',  'Stok' => 70,  'Harga' => 7000,  'Tanggal_Produksi' => '2024-08-01', 'Tanggal_Kadaluarsa' => '2027-08-01'],
            ['Nama_Obat' => 'Vitamin C 500mg',    'Stok' => 300, 'Harga' => 3000,  'Tanggal_Produksi' => '2024-09-01', 'Tanggal_Kadaluarsa' => '2027-09-01'],
            ['Nama_Obat' => 'Ibuprofen 400mg',    'Stok' => 160, 'Harga' => 6000,  'Tanggal_Produksi' => '2024-10-01', 'Tanggal_Kadaluarsa' => '2027-10-01'],
            ['Nama_Obat' => 'Cetirizine 10mg',    'Stok' => 110, 'Harga' => 5500,  'Tanggal_Produksi' => '2024-11-01', 'Tanggal_Kadaluarsa' => '2027-11-01'],
            ['Nama_Obat' => 'Omeprazole 20mg',    'Stok' => 130, 'Harga' => 9000,  'Tanggal_Produksi' => '2024-12-01', 'Tanggal_Kadaluarsa' => '2027-12-01'],
        ]);
    }
}
