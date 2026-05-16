<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        // ID_User 2 = Dr. Tiara, ID_User 3 = Dr. Joel
        DB::table('dokter')->insert([
            [
                'ID_User'       => 2,
                'Jenis_kelamin' => 'Perempuan',
                'Spesialis'     => 'Penyakit Dalam',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'ID_User'       => 3,
                'Jenis_kelamin' => 'Laki-laki',
                'Spesialis'     => 'Umum',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
