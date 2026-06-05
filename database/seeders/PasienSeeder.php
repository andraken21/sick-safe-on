<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $data = [
                ['email' => 'andra@gmail.com',   'no_bpjs' => '0001234560001', 'riwayat_penyakit' => 'Diabetes'],
                ['email' => 'yeremia@gmail.com', 'no_bpjs' => '0001234560002', 'riwayat_penyakit' => 'Hipertensi'],
            ];

            $rows = [];
            foreach ($data as $item) {
                $user = User::where('email', $item['email'])->where('role', 'pasien')->first();
                if (!$user) throw new \RuntimeException("User {$item['email']} tidak ditemukan.");
                $rows[] = [
                    'id_user'          => $user->id_user,
                    'no_bpjs'          => $item['no_bpjs'],
                    'riwayat_penyakit' => $item['riwayat_penyakit'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }

            DB::table('pasien')->upsert($rows, ['id_user'], ['no_bpjs', 'riwayat_penyakit', 'updated_at']);

            $this->command->info('Pasien seeded successfully');
        } catch (\Exception $e) {
            $this->command->error('Error seeding pasien: ' . $e->getMessage());
            throw $e;
        }
    }
}