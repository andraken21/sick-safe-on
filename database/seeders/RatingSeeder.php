<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 
class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $dokters = DB::table('dokter')->get();
        
        // AMBIL SEMUA ID PASIEN YANG ADA DI DATABASE
        $pasienIds = DB::table('pasien')->pluck('id_pasien')->toArray();

        // Antisipasi jika tabel pasien ternyata masih kosong (fallback pakai ID 1)
        $defaultPasienId = !empty($pasienIds) ? $pasienIds[0] : 1;
 
        // hanya seed rating untuk 5 dokter pertama saja
        $ratings = [
            // dokter[0] - 4 rating
            ['id_dokter' => $dokters[0]->id_dokter, 'rating' => 5],
            ['id_dokter' => $dokters[0]->id_dokter, 'rating' => 4],
            ['id_dokter' => $dokters[0]->id_dokter, 'rating' => 5],
            ['id_dokter' => $dokters[0]->id_dokter, 'rating' => 4],
 
            // dokter[1] - 3 rating
            ['id_dokter' => $dokters[1]->id_dokter, 'rating' => 4],
            ['id_dokter' => $dokters[1]->id_dokter, 'rating' => 3],
            ['id_dokter' => $dokters[1]->id_dokter, 'rating' => 5],
 
            // dokter[2] - 3 rating
            ['id_dokter' => $dokters[2]->id_dokter, 'rating' => 5],
            ['id_dokter' => $dokters[2]->id_dokter, 'rating' => 5],
            ['id_dokter' => $dokters[2]->id_dokter, 'rating' => 4],
 
            // dokter[3] - 2 rating
            ['id_dokter' => $dokters[3]->id_dokter, 'rating' => 3],
            ['id_dokter' => $dokters[3]->id_dokter, 'rating' => 4],
 
            // dokter[4] - 2 rating
            ['id_dokter' => $dokters[4]->id_dokter, 'rating' => 5],
            ['id_dokter' => $dokters[4]->id_dokter, 'rating' => 4],
        ];
 
        $rows = [];
        foreach ($ratings as $r) {
            // PILIH ID PASIEN SECARA ACAK DARI DATABASE
            $randomPasienId = !empty($pasienIds) ? $pasienIds[array_rand($pasienIds)] : $defaultPasienId;

            $rows[] = array_merge($r, [
                'id_pasien'  => $randomPasienId, // <--- FIX: id_pasien dimasukkan di sini
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
 
        DB::table('rating')->insert($rows);
    }
}