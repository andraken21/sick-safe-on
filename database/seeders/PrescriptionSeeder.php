<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $dokter1   = DB::table('dokter')->first();
            $dokter2   = DB::table('dokter')->skip(1)->first();
            $apoteker1 = DB::table('apoteker')->first();
            $apoteker2 = DB::table('apoteker')->skip(1)->first();
            $apoteker3 = DB::table('apoteker')->skip(2)->first();
            $pasien1   = DB::table('pasien')->first();
            $pasien2   = DB::table('pasien')->skip(1)->first();

            DB::table('prescriptions')->insert([
                ['id_dokter' => $dokter1->id_dokter, 'id_apoteker' => $apoteker1->id_apoteker, 'id_pasien' => $pasien1->id_pasien, 'tanggal' => '2026-01-10', 'status' => 'selesai',  'catatan' => 'Minum setelah makan',      'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter1->id_dokter, 'id_apoteker' => $apoteker2->id_apoteker, 'id_pasien' => $pasien2->id_pasien, 'tanggal' => '2026-01-20', 'status' => 'selesai',  'catatan' => 'Kontrol 2 minggu lagi',    'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter2->id_dokter, 'id_apoteker' => $apoteker3->id_apoteker, 'id_pasien' => $pasien1->id_pasien, 'tanggal' => '2026-02-05', 'status' => 'selesai',  'catatan' => 'Hindari makanan berlemak', 'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter2->id_dokter, 'id_apoteker' => $apoteker1->id_apoteker, 'id_pasien' => $pasien2->id_pasien, 'tanggal' => '2026-02-18', 'status' => 'selesai',  'catatan' => 'Banyak minum air putih',   'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter1->id_dokter, 'id_apoteker' => $apoteker2->id_apoteker, 'id_pasien' => $pasien1->id_pasien, 'tanggal' => '2026-03-01', 'status' => 'selesai',  'catatan' => null,                       'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter2->id_dokter, 'id_apoteker' => $apoteker3->id_apoteker, 'id_pasien' => $pasien2->id_pasien, 'tanggal' => '2026-03-15', 'status' => 'selesai',  'catatan' => 'Istirahat cukup',          'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter1->id_dokter, 'id_apoteker' => $apoteker1->id_apoteker, 'id_pasien' => $pasien1->id_pasien, 'tanggal' => '2026-04-02', 'status' => 'diproses', 'catatan' => 'Cek gula darah rutin',     'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter2->id_dokter, 'id_apoteker' => $apoteker2->id_apoteker, 'id_pasien' => $pasien2->id_pasien, 'tanggal' => '2026-04-20', 'status' => 'diproses', 'catatan' => null,                       'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter1->id_dokter, 'id_apoteker' => null,                    'id_pasien' => $pasien1->id_pasien, 'tanggal' => '2026-05-05', 'status' => 'menunggu', 'catatan' => 'Perlu observasi lanjut',   'created_at' => now(), 'updated_at' => now()],
                ['id_dokter' => $dokter2->id_dokter, 'id_apoteker' => null,                    'id_pasien' => $pasien2->id_pasien, 'tanggal' => '2026-05-10', 'status' => 'menunggu', 'catatan' => null,                       'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->command->info('Prescription seeded successfully');
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
            throw $e;
        }
    }
}