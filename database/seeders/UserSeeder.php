<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menambahkan data Admin
        User::create([
            'nama' => 'Admin SSO',
            'email' => 'admin@sicksafeon.com',
            'password' => Hash::make('Admin123.'),
            'tanggal_lahir' => '2026-12-05',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567890',
            'role' => 'Admin',
            'nik' => '1234567890123456',
            'alamat' => 'Medan, Sumatera Utara',
        ]);

        // Menambahkan data Dokter (Contoh)
        User::create([
            'nama' => 'Dr. Tiara Agnesia Siahaan',
            'email' => 'tiara@gmail.com',
            'password' => Hash::make('Tiara123.'),
            'tanggal_lahir' => '1990-05-15',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '088201660591',
            'role' => 'Dokter',
            'nik' => '1271119005123456',
            'alamat' => 'Jl. Tamora, Tanjung Morawa',
        ]);
        
        User::create([
            'nama' => 'Dr. Joel Purba Felix Ananta',
            'email' => 'joel@gmail.com',
            'password' => Hash::make('Joel123.'),
            'tanggal_lahir' => '1985-08-20',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '087812345678',
            'role' => 'Dokter',
            'nik' => '1221119005123456',
            'alamat' => 'Jl. Amsterdam, Siantar',
        ]);
        
        User::create([
            'nama' => 'Apt. Faridhah Azzati Hasanah Hasugian',
            'email' => 'faridhah@gmail.com',
            'password' => Hash::make('Faridhah123.'),
            'tanggal_lahir' => '1995-11-30',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081312345678',
            'role' => 'Apoteker',
            'nik' => '1918272617261421',
            'alamat' => 'Jl. Pungo, Aceh',
        ]);

        User::create([
            'nama' => 'Apt. Cindy Christina Rajagukguk',
            'email' => 'cindy@gmail.com',
            'password' => Hash::make('Cindy123.'),
            'tanggal_lahir' => '1999-07-25',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '082123456789',
            'role' => 'Apoteker',
            'nik' => '1302314567278291',
            'alamat' => 'Jl. Berdikari, Batam',
        ]);

        User::create([
            'nama' => 'Apt. Joice Siahaan Gultom',
            'email' => 'Joice@gmail.com',
            'password' => Hash::make('Joice123.'),
            'tanggal_lahir' => '2001-03-10',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '088543216789',
            'role' => 'Apoteker',
            'nik' => '1271129192716171',
            'alamat' => 'Jl. STM, Teladan City',
        ]);

        User::create([
            'nama' => 'M. Andra Kenzie Sibuea,S.Kom',
            'email' => 'andra@gmail.com',
            'password' => Hash::make('Andra123.'),
            'tanggal_lahir' => '1999-02-01',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567890',
            'role' => 'Pasien',
            'nik' => '1271110102200811',
            'alamat' => 'Jl. Jolam, England',
        ]);

        User::create([
            'nama' => 'Yeremia Sibuea,S.Cin',
            'email' => 'yeremia@gmail.com',
            'password' => Hash::make('Yereh123.'),
            'tanggal_lahir' => '1999-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '082274162677',
            'role' => 'Pasien',
            'nik' => '1271110102200812',
            'alamat' => 'Jl. Dekat rumah kevin, America',
        ]);

        // Tambahkan user lain sesuai kebutuhan project Anda
    }
}