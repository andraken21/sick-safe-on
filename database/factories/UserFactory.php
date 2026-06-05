<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'          => fake()->name(),              // FIX: 'name' → 'nama' sesuai kolom tabel users
            'email'         => fake()->unique()->safeEmail(),
            'password'      => static::$password ??= Hash::make('password'),
            'nik'           => fake()->numerify('################'), // 16 digit
            'no_telp'       => fake()->numerify('08##########'),
            'tanggal_lahir' => fake()->date(),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'role'          => 'pasien',                    // default role
            'alamat'        => fake()->address(),
            'status'        => 'aktif',
            // FIX: Hapus 'email_verified_at' dan 'remember_token' — kolom ini tidak ada di tabel users
        ];
    }

    /**
     * State untuk user dengan role admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * State untuk user dengan role dokter.
     */
    public function dokter(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'dokter',
        ]);
    }

    /**
     * State untuk user dengan role apoteker.
     */
    public function apoteker(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'apoteker',
        ]);
    }
}
