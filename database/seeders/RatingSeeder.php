<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $dokters = DB::table('dokter')->get();
        $pasiens = DB::table('pasien')->get();

        $ratings = [
            [
                'id_dokter'  => $dokters[0]->id_dokter,
                'id_pasien'  => $pasiens[0]->id_pasien,
                'rating'     => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dokter'  => $dokters[0]->id_dokter,
                'id_pasien'  => $pasiens[1]->id_pasien,
                'rating'     => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dokter'  => $dokters[0]->id_dokter,
                'id_pasien'  => $pasiens[2]->id_pasien,
                'rating'     => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dokter'  => $dokters[1]->id_dokter,
                'id_pasien'  => $pasiens[0]->id_pasien,
                'rating'     => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dokter'  => $dokters[1]->id_dokter,
                'id_pasien'  => $pasiens[2]->id_pasien,
                'rating'     => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('rating')->insert($ratings);
    }
}
