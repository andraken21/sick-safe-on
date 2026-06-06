<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    public function definition(): array
    {
        $obatList = [
            'Paracetamol', 'Amoxicillin', 'Ibuprofen', 'Metformin', 'Amlodipine',
            'Omeprazole', 'Cetirizine', 'Simvastatin', 'Allopurinol', 'Antasida',
            'Vitamin C', 'Vitamin B Complex', 'Salbutamol', 'Dexamethasone',
            'Ciprofloxacin', 'Ranitidin', 'Captopril', 'Furosemide', 'Diazepam',
        ];

        $satuan = ['500mg', '250mg', '100mg', '20mg', '10mg', '5mg', '1g'];

        $produksi = $this->faker->dateTimeBetween('-2 years', '-6 months');
        $kadaluarsa = $this->faker->dateTimeBetween('+1 year', '+3 years');

        return [
            'nama_Obat'          => $this->faker->randomElement($obatList) . ' ' . $this->faker->randomElement($satuan),
            'stok'               => $this->faker->numberBetween(10, 500),
            'harga'              => $this->faker->randomElement([3000, 5000, 7000, 8000, 10000, 12000, 15000, 20000, 35000]),
            'tanggal_produksi'   => $produksi->format('Y-m-d'),
            'tanggal_kadaluarsa' => $kadaluarsa->format('Y-m-d'),
        ];
    }
}
