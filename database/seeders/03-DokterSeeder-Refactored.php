<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DokterSeeder extends Seeder
{
    /**
     * Seed dokter dengan query-based relationship (idempotent).
     * Tidak menggunakan hard-coded ID yang rentan error.
     */
    public function run(): void
    {
        try {
            // Cari user berdasarkan email dan role, bukan ID hard-coded
            $tiara = User::where('email', 'tiara@gmail.com')
                ->where('role', 'Dokter')
                ->first();

            $joel = User::where('email', 'joel@gmail.com')
                ->where('role', 'Dokter')
                ->first();

            // Validasi: pastikan user ada sebelum membuat relasi
            if (!$tiara) {
                throw new \RuntimeException('User tiara@gmail.com dengan role Dokter tidak ditemukan. Pastikan UserSeeder sudah berjalan.');
            }

            if (!$joel) {
                throw new \RuntimeException('User joel@gmail.com dengan role Dokter tidak ditemukan. Pastikan UserSeeder sudah berjalan.');
            }

            // Gunakan firstOrCreate untuk idempotency
            DB::table('dokter')->updateOrCreate(
                ['ID_User' => $tiara->id],
                [
                    'ID_User' => $tiara->id,
                    'Jenis_kelamin' => 'Perempuan',
                    'Spesialis' => 'Penyakit Dalam',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('dokter')->updateOrCreate(
                ['ID_User' => $joel->id],
                [
                    'ID_User' => $joel->id,
                    'Jenis_kelamin' => 'Laki-laki',
                    'Spesialis' => 'Umum',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $this->command->info(' Dokter seeded successfully');
        } catch (\Exception $e) {
            $this->command->error(' Error seeding dokter: ' . $e->getMessage());
            throw $e;
        }
    }
}
