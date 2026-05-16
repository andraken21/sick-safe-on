<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        // ID_User 7 = Andra, ID_User 8 = Yeremia
        DB::table('pasien')->insert([
            [
                'ID_User'          => 7,
                'Jenis_kelamin'    => 'Laki-laki',
                'Tanggal_Lahir'    => '1999-02-01',
                'No_BPJS'          => '0001234560001',
                'Riwayat_Penyakit' => 'Diabetes',
                'Alamat'           => 'Jl. Jolam, England',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'ID_User'          => 8,
                'Jenis_kelamin'    => 'Laki-laki',
                'Tanggal_Lahir'    => '1999-01-01',
                'No_BPJS'          => '0001234560002',
                'Riwayat_Penyakit' => 'Hipertensi',
                'Alamat'           => 'Jl. Dekat rumah kevin, America',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }
}
