<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResepSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = DB::table('pasien')->get();
        $dokters = DB::table('dokter')->get();
        $obats   = DB::table('obat')->get()->keyBy('nama_obat');

        // ─── Resep 1 ─────────────────────────────────────────────
        $resep1 = DB::table('resep')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('resep_obat')->insert([
            [
                'id_resep'   => $resep1,
                'id_obat'    => $obats['Amoxicillin 500mg']->id_obat,
                'jumlah'     => 10,
                'dosis'      => '3x1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_resep'   => $resep1,
                'id_obat'    => $obats['Paracetamol 500mg']->id_obat,
                'jumlah'     => 6,
                'dosis'      => '3x1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('detail_resep')->insert([
            'id_pasien'   => $pasiens[0]->id_pasien,
            'id_dokter'   => $dokters[0]->id_dokter,
            'id_resep'    => $resep1,
            'keluhan'     => 'Batuk, pilek, dan demam selama 3 hari',
            'diagnosa'    => 'Infeksi Saluran Pernapasan Atas (ISPA)',
            'keterangan'  => 'Istirahat cukup dan minum air putih yang banyak',
            'status'      => 'selesai',
            'total_obat'  => 2,
            'tanggal'     => '2025-01-10',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // ─── Resep 2 ─────────────────────────────────────────────
        $resep2 = DB::table('resep')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('resep_obat')->insert([
            [
                'id_resep'   => $resep2,
                'id_obat'    => $obats['Amlodipine 5mg']->id_obat,
                'jumlah'     => 30,
                'dosis'      => '1x1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_resep'   => $resep2,
                'id_obat'    => $obats['Metformin 500mg']->id_obat,
                'jumlah'     => 60,
                'dosis'      => '2x1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_resep'   => $resep2,
                'id_obat'    => $obats['Vitamin C 500mg']->id_obat,
                'jumlah'     => 30,
                'dosis'      => '1x1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('detail_resep')->insert([
            'id_pasien'   => $pasiens[1]->id_pasien,
            'id_dokter'   => $dokters[0]->id_dokter,
            'id_resep'    => $resep2,
            'keluhan'     => 'Sering pusing, mudah lelah, dan sering haus',
            'diagnosa'    => 'Hipertensi + Diabetes Mellitus Tipe 2',
            'keterangan'  => 'Kontrol rutin setiap bulan. Kurangi konsumsi gula dan garam',
            'status'      => 'selesai',
            'total_obat'  => 3,
            'tanggal'     => '2025-01-10',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // ─── Resep 3 ─────────────────────────────────────────────
        $resep3 = DB::table('resep')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('resep_obat')->insert([
            [
                'id_resep'   => $resep3,
                'id_obat'    => $obats['Cetirizine 10mg']->id_obat,
                'jumlah'     => 7,
                'dosis'      => '1x1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('detail_resep')->insert([
            'id_pasien'   => $pasiens[2]->id_pasien,
            'id_dokter'   => $dokters[1]->id_dokter,
            'id_resep'    => $resep3,
            'keluhan'     => 'Gatal-gatal dan bersin-bersin setelah makan udang',
            'diagnosa'    => 'Alergi Makanan',
            'keterangan'  => 'Hindari makanan pemicu alergi',
            'status'      => 'selesai',
            'total_obat'  => 1,
            'tanggal'     => '2025-01-11',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // ─── Resep 4 (sedang diproses) ────────────────────────────
        $resep4 = DB::table('resep')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('resep_obat')->insert([
            [
                'id_resep'   => $resep4,
                'id_obat'    => $obats['Paracetamol 500mg']->id_obat,
                'jumlah'     => 9,
                'dosis'      => '3x1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('detail_resep')->insert([
            'id_pasien'   => $pasiens[0]->id_pasien,
            'id_dokter'   => $dokters[1]->id_dokter,
            'id_resep'    => $resep4,
            'keluhan'     => 'Demam tinggi dan sakit kepala',
            'diagnosa'    => null,
            'keterangan'  => null,
            'status'      => 'diproses',
            'total_obat'  => 1,
            'tanggal'     => now()->toDateString(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
