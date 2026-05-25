<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        // ID_Dokter  : 1 = Dr. Tiara, 2 = Dr. Joel
        // ID_Apoteker: 1 = Faridhah, 2 = Cindy, 3 = Joice
        // ID_Pasien  : 1 = Andra, 2 = Yeremia
        DB::table('prescriptions')->insert([
            ['ID_Dokter' => 1, 'ID_Apoteker' => 1,    'ID_Pasien' => 1, 'Tanggal' => '2026-01-10', 'Status' => 'selesai',  'Catatan' => 'Minum setelah makan'],
            ['ID_Dokter' => 1, 'ID_Apoteker' => 2,    'ID_Pasien' => 2, 'Tanggal' => '2026-01-20', 'Status' => 'selesai',  'Catatan' => 'Kontrol 2 minggu lagi'],
            ['ID_Dokter' => 2, 'ID_Apoteker' => 3,    'ID_Pasien' => 1, 'Tanggal' => '2026-02-05', 'Status' => 'selesai',  'Catatan' => 'Hindari makanan berlemak'],
            ['ID_Dokter' => 2, 'ID_Apoteker' => 1,    'ID_Pasien' => 2, 'Tanggal' => '2026-02-18', 'Status' => 'selesai',  'Catatan' => 'Banyak minum air putih'],
            ['ID_Dokter' => 1, 'ID_Apoteker' => 2,    'ID_Pasien' => 1, 'Tanggal' => '2026-03-01', 'Status' => 'selesai',  'Catatan' => null],
            ['ID_Dokter' => 2, 'ID_Apoteker' => 3,    'ID_Pasien' => 2, 'Tanggal' => '2026-03-15', 'Status' => 'selesai',  'Catatan' => 'Istirahat cukup'],
            ['ID_Dokter' => 1, 'ID_Apoteker' => 1,    'ID_Pasien' => 1, 'Tanggal' => '2026-04-02', 'Status' => 'diproses', 'Catatan' => 'Cek gula darah rutin'],
            ['ID_Dokter' => 2, 'ID_Apoteker' => 2,    'ID_Pasien' => 2, 'Tanggal' => '2026-04-20', 'Status' => 'diproses', 'Catatan' => null],
            ['ID_Dokter' => 1, 'ID_Apoteker' => null, 'ID_Pasien' => 1, 'Tanggal' => '2026-05-05', 'Status' => 'menunggu', 'Catatan' => 'Perlu observasi lanjut'],
            ['ID_Dokter' => 2, 'ID_Apoteker' => null, 'ID_Pasien' => 2, 'Tanggal' => '2026-05-10', 'Status' => 'menunggu', 'Catatan' => null],
        ]);
    }
}
