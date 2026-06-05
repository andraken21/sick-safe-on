<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        try {
            User::firstOrCreate(['email' => 'admin@sicksafeon.com'], [
                'nama' => 'Admin SSO', 'password' => Hash::make('Admin123.'),
                'tanggal_lahir' => '1990-01-01', 'jenis_kelamin' => 'Laki-laki',
                'no_telp' => '081234567890', 'role' => 'admin',
                'nik' => '1234567890123456', 'alamat' => 'Medan, Sumatera Utara',
            ]);

            User::firstOrCreate(['email' => 'tiara@gmail.com'], [
                'nama' => 'Dr. Tiara Agnesia Siahaan', 'password' => Hash::make('Tiara123.'),
                'tanggal_lahir' => '1990-05-15', 'jenis_kelamin' => 'Perempuan',
                'no_telp' => '088201660591', 'role' => 'dokter',
                'nik' => '1271119005123456', 'alamat' => 'Jl. Tamora, Tanjung Morawa',
            ]);

            User::firstOrCreate(['email' => 'joel@gmail.com'], [
                'nama' => 'Dr. Joel Purba Felix Ananta', 'password' => Hash::make('Joel123.'),
                'tanggal_lahir' => '1985-08-20', 'jenis_kelamin' => 'Laki-laki',
                'no_telp' => '087812345678', 'role' => 'dokter',
                'nik' => '1221119005123456', 'alamat' => 'Jl. Amsterdam, Siantar',
            ]);

            User::firstOrCreate(['email' => 'faridhah@gmail.com'], [
                'nama' => 'Apt. Faridhah Azzati Hasanah Hasugian', 'password' => Hash::make('Faridhah123.'),
                'tanggal_lahir' => '1995-11-30', 'jenis_kelamin' => 'Perempuan',
                'no_telp' => '081312345678', 'role' => 'apoteker',
                'nik' => '1918272617261421', 'alamat' => 'Jl. Pungo, Aceh',
            ]);

            User::firstOrCreate(['email' => 'cindy@gmail.com'], [
                'nama' => 'Apt. Cindy Christina Rajagukguk', 'password' => Hash::make('Cindy123.'),
                'tanggal_lahir' => '1999-07-25', 'jenis_kelamin' => 'Perempuan',
                'no_telp' => '082123456789', 'role' => 'apoteker',
                'nik' => '1302314567278291', 'alamat' => 'Jl. Berdikari, Batam',
            ]);

            User::firstOrCreate(['email' => 'Joice@gmail.com'], [
                'nama' => 'Apt. Joice Siahaan', 'password' => Hash::make('Joice123.'),
                'tanggal_lahir' => '2001-03-10', 'jenis_kelamin' => 'Perempuan',
                'no_telp' => '088543216789', 'role' => 'apoteker',
                'nik' => '1271129192716171', 'alamat' => 'Jl. STM, Teladan City',
            ]);

            User::firstOrCreate(['email' => 'andra@gmail.com'], [
                'nama' => 'M. Andra Kenzie Sibuea,S.Kom', 'password' => Hash::make('Andra123.'),
                'tanggal_lahir' => '1999-02-01', 'jenis_kelamin' => 'Laki-laki',
                'no_telp' => '081234567890', 'role' => 'pasien',
                'nik' => '1271110102200811', 'alamat' => 'Jl. Jolam, England',
            ]);

            User::firstOrCreate(['email' => 'yeremia@gmail.com'], [
                'nama' => 'Yeremia Sibuea,S.Cin', 'password' => Hash::make('Yereh123.'),
                'tanggal_lahir' => '1999-01-01', 'jenis_kelamin' => 'Laki-laki',
                'no_telp' => '082274162677', 'role' => 'pasien',
                'nik' => '1271110102200812', 'alamat' => 'Jl. Dekat rumah kevin, America',
            ]);

            $this->command->info('Users seeded successfully');
        } catch (\Exception $e) {
            $this->command->error('Error seeding users: ' . $e->getMessage());
            throw $e;
        }
    }
}
