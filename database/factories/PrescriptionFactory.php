<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\Apoteker;
use App\Models\Pasien;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ID_Dokter'    => Dokter::inRandomOrder()->first()->ID_Dokter,
            'ID_Apoteker'  => $this->faker->boolean(70)
                                ? Apoteker::inRandomOrder()->first()->ID_Apoteker
                                : null,
            'ID_Pasien'    => Pasien::inRandomOrder()->first()->ID_Pasien,
            'Tanggal'      => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'Status'       => $this->faker->randomElement(['menunggu', 'diproses', 'selesai', 'selesai', 'selesai']),
            'Catatan'      => $this->faker->boolean(60) ? $this->faker->sentence() : null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($prescription) {
            // Setiap resep otomatis punya 1-3 detail obat
            $obatList = Medicine::inRandomOrder()->take(rand(1, 3))->get();
            foreach ($obatList as $obat) {
                \DB::table('prescription_details')->insert([
                    'ID_Resep'   => $prescription->ID_Resep,
                    'ID_Obat'    => $obat->ID_Obat,
                    'Jumlah'     => rand(5, 30),
                    'Dosis'      => $this->faker->randomElement([
                        '1x1', '2x1', '3x1', '1x1 pagi', '1x1 malam',
                        '3x1 sesudah makan', '2x1 sebelum makan', 'Jika perlu',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Otomatis buat transaksi jika status selesai/diproses
            if (in_array($prescription->Status, ['selesai', 'diproses'])) {
                \DB::table('transactions')->insert([
                    'ID_Resep'      => $prescription->ID_Resep,
                    'Metode'        => $this->faker->randomElement(['Cash', 'Transfer', 'BPJS']),
                    'Total_Bayar'   => $this->faker->randomElement([0, 50000, 80000, 150000, 300000, 450000]),
                    'Status'        => $prescription->Status === 'selesai' ? 'lunas' : 'pending',
                    'Tanggal_Bayar' => $prescription->Status === 'selesai'
                        ? $prescription->Tanggal
                        : null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        });
    }
}
