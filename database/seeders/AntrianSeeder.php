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
            // ─── Tanggal 2025-01-10 ──────────────────────────────
            ['id_pasien' => $pasiens[0]->id_pasien, 'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-10', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[1]->id_pasien, 'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 2, 'tanggal' => '2025-01-10', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[2]->id_pasien, 'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-10', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[3]->id_pasien, 'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 2, 'tanggal' => '2025-01-10', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[4]->id_pasien, 'id_dokter' => $dokters[2]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-10', 'status' => 'selesai'],
 
            // ─── Tanggal 2025-01-11 ──────────────────────────────
            ['id_pasien' => $pasiens[2]->id_pasien, 'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-11', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[5]->id_pasien, 'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 2, 'tanggal' => '2025-01-11', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[6]->id_pasien, 'id_dokter' => $dokters[2]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-11', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[7]->id_pasien, 'id_dokter' => $dokters[3]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-11', 'status' => 'selesai'],
 
            // ─── Tanggal 2025-01-13 ──────────────────────────────
            ['id_pasien' => $pasiens[0]->id_pasien, 'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-13', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[8]->id_pasien, 'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-13', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[9]->id_pasien, 'id_dokter' => $dokters[2]->id_dokter, 'nomor_antrian' => 2, 'tanggal' => '2025-01-13', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[10]->id_pasien, 'id_dokter' => $dokters[3]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-13', 'status' => 'selesai'],
 
            // ─── Tanggal 2025-01-14 ──────────────────────────────
            ['id_pasien' => $pasiens[1]->id_pasien, 'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-14', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[3]->id_pasien, 'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-14', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[11]->id_pasien, 'id_dokter' => $dokters[2]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-14', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[12]->id_pasien, 'id_dokter' => $dokters[4]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-14', 'status' => 'selesai'],
 
            // ─── Tanggal 2025-01-15 ──────────────────────────────
            ['id_pasien' => $pasiens[4]->id_pasien, 'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-15', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[6]->id_pasien, 'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-15', 'status' => 'selesai'],
            ['id_pasien' => $pasiens[13]->id_pasien, 'id_dokter' => $dokters[3]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => '2025-01-15', 'status' => 'selesai'],
 
            // ─── Hari ini (sebagian masih aktif) ─────────────────
            ['id_pasien' => $pasiens[0]->id_pasien,  'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => now()->toDateString(), 'status' => 'selesai'],
            ['id_pasien' => $pasiens[1]->id_pasien,  'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 2, 'tanggal' => now()->toDateString(), 'status' => 'diproses'],
            ['id_pasien' => $pasiens[2]->id_pasien,  'id_dokter' => $dokters[2]->id_dokter, 'nomor_antrian' => 1, 'tanggal' => now()->toDateString(), 'status' => 'menunggu'],
            ['id_pasien' => $pasiens[5]->id_pasien,  'id_dokter' => $dokters[0]->id_dokter, 'nomor_antrian' => 3, 'tanggal' => now()->toDateString(), 'status' => 'menunggu'],
            ['id_pasien' => $pasiens[7]->id_pasien,  'id_dokter' => $dokters[1]->id_dokter, 'nomor_antrian' => 2, 'tanggal' => now()->toDateString(), 'status' => 'menunggu'],
        ];
 
        foreach ($antrians as $a) {
            DB::table('antrian')->insert(array_merge($a, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}