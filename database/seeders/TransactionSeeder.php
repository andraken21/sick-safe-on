<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Prescription;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $reseps = Prescription::orderBy('id_resep')->get();

            if ($reseps->count() < 10) {
                throw new \RuntimeException('Prescription data tidak cukup, jalankan PrescriptionSeeder dulu.');
            }

            DB::table('transactions')->insert([
                ['id_resep' => $reseps[0]->id_resep,  'metode' => 'BPJS',    'total_bayar' => 0,      'status' => 'lunas',   'tanggal_bayar' => '2026-01-10', 'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[1]->id_resep,  'metode' => 'Mandiri', 'total_bayar' => 450000, 'status' => 'lunas',   'tanggal_bayar' => '2026-01-20', 'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[2]->id_resep,  'metode' => 'Mandiri', 'total_bayar' => 300000, 'status' => 'lunas',   'tanggal_bayar' => '2026-02-05', 'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[3]->id_resep,  'metode' => 'BPJS',    'total_bayar' => 0,      'status' => 'lunas',   'tanggal_bayar' => '2026-02-18', 'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[4]->id_resep,  'metode' => 'BPJS',    'total_bayar' => 0,      'status' => 'lunas',   'tanggal_bayar' => '2026-03-01', 'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[5]->id_resep,  'metode' => 'Mandiri', 'total_bayar' => 35000,  'status' => 'lunas',   'tanggal_bayar' => '2026-03-15', 'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[6]->id_resep,  'metode' => 'Mandiri', 'total_bayar' => 360000, 'status' => 'pending', 'tanggal_bayar' => null,         'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[7]->id_resep,  'metode' => 'BPJS',    'total_bayar' => 0,      'status' => 'pending', 'tanggal_bayar' => null,         'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[8]->id_resep,  'metode' => null,      'total_bayar' => 0,      'status' => 'pending', 'tanggal_bayar' => null,         'created_at' => now(), 'updated_at' => now()],
                ['id_resep' => $reseps[9]->id_resep,  'metode' => null,      'total_bayar' => 0,      'status' => 'pending', 'tanggal_bayar' => null,         'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->command->info('✅ Transaction seeded successfully');
        } catch (\Exception $e) {
            $this->command->error('❌ Error seeding transaction: ' . $e->getMessage());
            throw $e;
        }
    }
}
