<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AntrianSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = DB::table('pasien')->get();
        $dokters = DB::table('dokter')->get();

        $antrians = [
            [
                'id_pasien'      => $pasiens[0]->id_pasien,
                'id_dokter'      => $dokters[0]->id_dokter,
                'nomor_antrian'  => 1,
                'tanggal'        => '2025-01-10',
                'status'         => 'selesai',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasien'      => $pasiens[1]->id_pasien,
                'id_dokter'      => $dokters[0]->id_dokter,
                'nomor_antrian'  => 2,
                'tanggal'        => '2025-01-10',
                'status'         => 'selesai',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasien'      => $pasiens[2]->id_pasien,
                'id_dokter'      => $dokters[1]->id_dokter,
                'nomor_antrian'  => 1,
                'tanggal'        => '2025-01-11',
                'status'         => 'selesai',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasien'      => $pasiens[0]->id_pasien,
                'id_dokter'      => $dokters[1]->id_dokter,
                'nomor_antrian'  => 1,
                'tanggal'        => now()->toDateString(),
                'status'         => 'diproses',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasien'      => $pasiens[1]->id_pasien,
                'id_dokter'      => $dokters[0]->id_dokter,
                'nomor_antrian'  => 2,
                'tanggal'        => now()->toDateString(),
                'status'         => 'menunggu',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        DB::table('antrian')->insert($antrians);
    }
}
