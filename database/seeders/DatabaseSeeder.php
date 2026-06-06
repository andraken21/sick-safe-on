<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            KategoriObatSeeder::class,
            AntrianSeeder::class,
            RatingSeeder::class,
            ResepSeeder::class,
            TransaksiSeeder::class,
        ]);
    }
}
