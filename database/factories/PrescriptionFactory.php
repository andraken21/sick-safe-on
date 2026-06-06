<?php

// namespace Database\Factories;

// use App\Models\Dokter;
// use App\Models\Apoteker;
// use App\Models\Pasien;
// use App\Models\Medicine;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class PrescriptionFactory extends Factory
// {
//     public function definition(): array
//     {
//         return [
//             'id_dokter'    => Dokter::inRandomOrder()->first()->ID_Dokter,
//             'id_apoteker'  => $this->faker->boolean(70)
//                                 ? Apoteker::inRandomOrder()->first()->ID_Apoteker
//                                 : null,
//             'id_pasien'    => Pasien::inRandomOrder()->first()->ID_Pasien,
//             'tanggal'      => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
//             'status'       => $this->faker->randomElement(['menunggu', 'diproses', 'selesai', 'selesai', 'selesai']),
//             'catatan'      => $this->faker->boolean(60) ? $this->faker->sentence() : null,
//         ];
//     }

//     public function configure()
//     {
//         return $this->afterCreating(function ($prescription) {
//             // Setiap resep otomatis punya 1-3 detail obat
//             $obatList = Medicine::inRandomOrder()->take(rand(1, 3))->get();
//             foreach ($obatList as $obat) {
//                 \DB::table('prescription_details')->insert([
//                     'id_resep'   => $prescription->ID_Resep,
//                     'id_obat'    => $obat->ID_Obat,
//                     'jumlah'     => rand(5, 30),
//                     'dosis'      => $this->faker->randomElement([
//                         '1x1', '2x1', '3x1', '1x1 pagi', '1x1 malam',
//                         '3x1 sesudah makan', '2x1 sebelum makan', 'Jika perlu',
//                     ]),
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             }

//             // Otomatis buat transaksi jika status selesai/diproses
//             if (in_array($prescription->status, ['selesai', 'diproses'])) {
//                 DB::table('transactions')->insert([
//                     'id_Resep'      => $prescription->ID_Resep,
//                     'metode'        => $this->faker->randomElement(['Cash', 'Transfer', 'BPJS']),
//                     'total_bayar'   => $this->faker->randomElement([0, 50000, 80000, 150000, 300000, 450000]),
//                     'status'        => $prescription->status === 'selesai' ? 'lunas' : 'pending',
//                     'tanggal_bayar' => $prescription->status === 'selesai'
//                         ? $prescription->Tanggal
//                         : null,
//                     'created_at'    => now(),
//                     'updated_at'    => now(),
//                 ]);
//             }
//         });
//     }
// }
