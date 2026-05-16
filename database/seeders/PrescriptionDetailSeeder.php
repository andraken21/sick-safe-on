<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrescriptionDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prescription_details')->insert([
            ['ID_Resep' => 1,  'ID_Obat' => 4,  'Jumlah' => 30, 'Dosis' => '1x1 pagi sesudah makan'],
            ['ID_Resep' => 1,  'ID_Obat' => 9,  'Jumlah' => 10, 'Dosis' => '1x1'],
            ['ID_Resep' => 2,  'ID_Obat' => 5,  'Jumlah' => 30, 'Dosis' => '1x1 malam'],
            ['ID_Resep' => 2,  'ID_Obat' => 11, 'Jumlah' => 10, 'Dosis' => '1x1'],
            ['ID_Resep' => 3,  'ID_Obat' => 7,  'Jumlah' => 30, 'Dosis' => '1x1 malam'],
            ['ID_Resep' => 4,  'ID_Obat' => 3,  'Jumlah' => 20, 'Dosis' => '3x1 sebelum makan'],
            ['ID_Resep' => 5,  'ID_Obat' => 1,  'Jumlah' => 15, 'Dosis' => '3x1'],
            ['ID_Resep' => 6,  'ID_Obat' => 6,  'Jumlah' => 1,  'Dosis' => 'Jika sesak nafas'],
            ['ID_Resep' => 7,  'ID_Obat' => 4,  'Jumlah' => 30, 'Dosis' => '1x1 pagi'],
            ['ID_Resep' => 7,  'ID_Obat' => 9,  'Jumlah' => 10, 'Dosis' => '1x1'],
            ['ID_Resep' => 8,  'ID_Obat' => 2,  'Jumlah' => 15, 'Dosis' => '3x1 sesudah makan'],
            ['ID_Resep' => 8,  'ID_Obat' => 10, 'Jumlah' => 10, 'Dosis' => '2x1'],
            ['ID_Resep' => 9,  'ID_Obat' => 12, 'Jumlah' => 30, 'Dosis' => '1x1 pagi'],
            ['ID_Resep' => 9,  'ID_Obat' => 8,  'Jumlah' => 10, 'Dosis' => '1x1 malam'],
            ['ID_Resep' => 10, 'ID_Obat' => 1,  'Jumlah' => 10, 'Dosis' => '3x1'],
            ['ID_Resep' => 10, 'ID_Obat' => 3,  'Jumlah' => 15, 'Dosis' => '3x1 sebelum makan'],
        ]);
    }
}
