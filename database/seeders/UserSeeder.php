<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Admin
            [
                'email'          => 'admin@sicksafeon.com',
                'nama'           => 'Admin Utama',
                'password'       => Hash::make('Admin123.'),
                'tanggal_lahir'  => '1990-01-01',
                'jenis_kelamin'  => 'Laki-laki',
                'no_telp'        => '081200000001',
                'role'           => 'Admin',
                'nik'            => '1234567890000001',
                'alamat'         => 'Jl. Admin No. 1, Medan',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Dokter
            [
                'email'          => 'joel@gmail.com',
                'nama'           => 'dr. Budi Santoso, Sp.PD',
                'password'       => Hash::make('Joel123.'),
                'tanggal_lahir'  => '1980-05-15',
                'jenis_kelamin'  => 'Laki-laki',
                'no_telp'        => '081200000002',
                'role'           => 'Dokter',
                'nik'            => '1234567890000002',
                'alamat'         => 'Jl. Dokter No. 2, Medan',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'email'          => 'tiara@gmail.com',
                'nama'           => 'dr. Tiara Siahaan, Sp.A',
                'password'       => Hash::make('Tiara123.'),
                'tanggal_lahir'  => '1985-08-20',
                'jenis_kelamin'  => 'Perempuan',
                'no_telp'        => '081200000003',
                'role'           => 'Dokter',
                'nik'            => '1234567890000003',
                'alamat'         => 'Jl. Dokter No. 3, Medan',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Apoteker
            [
                'email'          => 'cici@gmail.com',
                'nama'           => 'Cindy Rajagukguk, S.Farm',
                'password'       => Hash::make('Cici123.'),
                'tanggal_lahir'  => '1992-03-10',
                'jenis_kelamin'  => 'Perempuan',
                'no_telp'        => '081200000004',
                'role'           => 'Apoteker',
                'nik'            => '1234567890000004',
                'alamat'         => 'Jl. Apoteker No. 4, Medan',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Pasien
            [
                'email'          => 'andra@gmail.com',
                'nama'           => 'Andra Kenzie, S.Kom',
                'password'       => Hash::make('Andra123.'),
                'tanggal_lahir'  => '1995-07-22',
                'jenis_kelamin'  => 'Laki-laki',
                'no_telp'        => '081200000005',
                'role'           => 'Pasien',
                'nik'            => '1234567890000005',
                'alamat'         => 'Jl. Pasien No. 5, Medan',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'email'          => 'pasien2@gmail.com',
                'nama'           => 'Dewi Lestari',
                'password'       => Hash::make('Dewi123.'),
                'tanggal_lahir'  => '1998-11-30',
                'jenis_kelamin'  => 'Perempuan',
                'no_telp'        => '081200000006',
                'role'           => 'Pasien',
                'nik'            => '1234567890000006',
                'alamat'         => 'Jl. Pasien No. 6, Medan',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'email'          => 'pasien3@gmail.com',
                'nama'           => 'Riko Prasetyo',
                'password'       => Hash::make('Riko123.'),
                'tanggal_lahir'  => '2000-04-05',
                'jenis_kelamin'  => 'Laki-laki',
                'no_telp'        => '081200000007',
                'role'           => 'Pasien',
                'nik'            => '1234567890000007',
                'alamat'         => 'Jl. Pasien No. 7, Medan',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
