<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $tiara = User::where('email', 'tiara@gmail.com')->where('role', 'dokter')->first();
            $joel  = User::where('email', 'joel@gmail.com')->where('role', 'dokter')->first();

            if (!$tiara) throw new \RuntimeException('User tiara@gmail.com tidak ditemukan.');
            if (!$joel)  throw new \RuntimeException('User joel@gmail.com tidak ditemukan.');

            DB::table('dokter')->upsert(
                [
                    ['id_user' => $tiara->id_user, 'spesialis' => 'Penyakit Dalam', 'created_at' => now(), 'updated_at' => now()],
                    ['id_user' => $joel->id_user,  'spesialis' => 'Umum',           'created_at' => now(), 'updated_at' => now()],
                ],
                ['id_user'],
                ['spesialis', 'updated_at']
            );

            $this->command->info('✅ Dokter seeded successfully');
        } catch (\Exception $e) {
            $this->command->error('❌ Error seeding dokter: ' . $e->getMessage());
            throw $e;
        }
    }
}
