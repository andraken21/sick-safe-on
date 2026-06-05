<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriObatSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Kategori ────────────────────────────────────────────
        $kategoris = [
            ['kategori_obat' => 'Antibiotik',        'created_at' => now(), 'updated_at' => now()],
            ['kategori_obat' => 'Analgesik',         'created_at' => now(), 'updated_at' => now()],
            ['kategori_obat' => 'Antihipertensi',    'created_at' => now(), 'updated_at' => now()],
            ['kategori_obat' => 'Antidiabetes',      'created_at' => now(), 'updated_at' => now()],
            ['kategori_obat' => 'Vitamin & Suplemen','created_at' => now(), 'updated_at' => now()],
            ['kategori_obat' => 'Antihistamin',      'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kategori')->insert($kategoris);

        // Ambil ID kategori yang baru dibuat
        $antibiotik   = DB::table('kategori')->where('kategori_obat', 'Antibiotik')->value('id_kategori');
        $analgesik    = DB::table('kategori')->where('kategori_obat', 'Analgesik')->value('id_kategori');
        $antihipertensi = DB::table('kategori')->where('kategori_obat', 'Antihipertensi')->value('id_kategori');
        $antidiabetes = DB::table('kategori')->where('kategori_obat', 'Antidiabetes')->value('id_kategori');
        $vitamin      = DB::table('kategori')->where('kategori_obat', 'Vitamin & Suplemen')->value('id_kategori');
        $antihistamin = DB::table('kategori')->where('kategori_obat', 'Antihistamin')->value('id_kategori');

        // ─── Obat ────────────────────────────────────────────────
        $obats = [
            [
                'nama_obat'         => 'Amoxicillin 500mg',
                'id_kategori'       => $antibiotik,
                'stok'              => 200,
                'harga'             => 3500.00,
                'status'            => 'tersedia',
                'tanggal_kadaluarsa'=> '2026-12-31',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nama_obat'         => 'Ciprofloxacin 500mg',
                'id_kategori'       => $antibiotik,
                'stok'              => 15,
                'harga'             => 6500.00,
                'status'            => 'menipis',
                'tanggal_kadaluarsa'=> '2026-06-30',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nama_obat'         => 'Paracetamol 500mg',
                'id_kategori'       => $analgesik,
                'stok'              => 500,
                'harga'             => 1000.00,
                'status'            => 'tersedia',
                'tanggal_kadaluarsa'=> '2027-03-31',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nama_obat'         => 'Ibuprofen 400mg',
                'id_kategori'       => $analgesik,
                'stok'              => 0,
                'harga'             => 2500.00,
                'status'            => 'habis',
                'tanggal_kadaluarsa'=> '2025-09-30',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nama_obat'         => 'Amlodipine 5mg',
                'id_kategori'       => $antihipertensi,
                'stok'              => 150,
                'harga'             => 4000.00,
                'status'            => 'tersedia',
                'tanggal_kadaluarsa'=> '2027-01-31',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nama_obat'         => 'Metformin 500mg',
                'id_kategori'       => $antidiabetes,
                'stok'              => 300,
                'harga'             => 2000.00,
                'status'            => 'tersedia',
                'tanggal_kadaluarsa'=> '2026-11-30',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nama_obat'         => 'Vitamin C 500mg',
                'id_kategori'       => $vitamin,
                'stok'              => 400,
                'harga'             => 1500.00,
                'status'            => 'tersedia',
                'tanggal_kadaluarsa'=> '2027-06-30',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nama_obat'         => 'Cetirizine 10mg',
                'id_kategori'       => $antihistamin,
                'stok'              => 100,
                'harga'             => 3000.00,
                'status'            => 'tersedia',
                'tanggal_kadaluarsa'=> '2026-08-31',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        DB::table('obat')->insert($obats);
    }
}
