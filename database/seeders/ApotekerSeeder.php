<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApotekerSeeder extends Seeder
{
    public function run(): void
    {
        // ID_User 4 = Faridhah, 5 = Cindy, 6 = Joice
        DB::table('apoteker')->insert([
            ['ID_User' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['ID_User' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['ID_User' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
