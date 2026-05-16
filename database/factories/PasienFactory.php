<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasienFactory extends Factory
{
    public function definition(): array
    {
        // Buat user baru dengan role Pasien
        $user = User::factory()->create(['role' => 'Pasien']);

        return [
            'ID_User'          => $user->id,
            'Jenis_kelamin'    => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'Tanggal_Lahir'    => $this->faker->date('Y-m-d', '-18 years'),
            'No_BPJS'          => $this->faker->boolean(60)
                                    ? $this->faker->numerify('##############')
                                    : null,
            'Riwayat_Penyakit' => $this->faker->randomElement([
                'Diabetes', 'Hipertensi', 'Asma', 'Maag', 'Kolesterol',
                'Asam Urat', 'TBC', 'Anemia', null, null,
            ]),
            'Alamat'           => $this->faker->address(),
        ];
    }
}
