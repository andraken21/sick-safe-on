<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DokterSeeder::class,
            ApotekerSeeder::class,
            PasienSeeder::class,
            MedicineSeeder::class,
            PrescriptionSeeder::class,
            PrescriptionDetailSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
