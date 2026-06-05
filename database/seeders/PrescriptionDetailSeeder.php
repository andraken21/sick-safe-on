<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrescriptionDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prescription_details')->insert([
            ['id_resep' => 1,  'id_obat' => 4,  'jumlah' => 30, 'dosis' => '1x1 pagi sesudah makan'],
            ['id_resep' => 1,  'id_obat' => 9,  'jumlah' => 10, 'dosis' => '1x1'],
            ['id_resep' => 2,  'id_obat' => 5,  'jumlah' => 30, 'dosis' => '1x1 malam'],
            ['id_resep' => 2,  'id_obat' => 11, 'jumlah' => 10, 'dosis' => '1x1'],
            ['id_resep' => 3,  'id_obat' => 7,  'jumlah' => 30, 'dosis' => '1x1 malam'],
            ['id_resep' => 4,  'id_obat' => 3,  'jumlah' => 20, 'dosis' => '3x1 sebelum makan'],
            ['id_resep' => 5,  'id_obat' => 1,  'jumlah' => 15, 'dosis' => '3x1'],
            ['id_resep' => 6,  'id_obat' => 6,  'jumlah' => 1,  'dosis' => 'Jika sesak nafas'],
            ['id_resep' => 7,  'id_obat' => 4,  'jumlah' => 30, 'dosis' => '1x1 pagi'],
            ['id_resep' => 7,  'id_obat' => 9,  'jumlah' => 10, 'dosis' => '1x1'],
            ['id_resep' => 8,  'id_obat' => 2,  'jumlah' => 15, 'dosis' => '3x1 sesudah makan'],
            ['id_resep' => 8,  'id_obat' => 10, 'jumlah' => 10, 'dosis' => '2x1'],
            ['id_resep' => 9,  'id_obat' => 12, 'jumlah' => 30, 'dosis' => '1x1 pagi'],
            ['id_resep' => 9,  'id_obat' => 8,  'jumlah' => 10, 'dosis' => '1x1 malam'],
            ['id_resep' => 10, 'id_obat' => 1,  'jumlah' => 10, 'dosis' => '3x1'],
            ['id_resep' => 10, 'id_obat' => 3,  'jumlah' => 15, 'dosis' => '3x1 sebelum makan'],
        ]);
    }
}