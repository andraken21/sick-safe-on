<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID user berdasarkan role dari tabel users
        $admin    = DB::table('users')->where('role', 'Admin')->first();
        $dokters  = DB::table('users')->where('role', 'Dokter')->get();
        $apoteker = DB::table('users')->where('role', 'Apoteker')->first();
        $pasiens  = DB::table('users')->where('role', 'Pasien')->get();

        // ─── Admin ───────────────────────────────────────────────
        DB::table('admin')->insert([
            'id_user'    => $admin->id_user,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ─── Dokter ──────────────────────────────────────────────
        $spesialis = ['Sp.PD', 'Sp.A'];
        foreach ($dokters as $index => $dokter) {
            DB::table('dokter')->insert([
                'id_user'    => $dokter->id_user,
                'spesialis'  => $spesialis[$index] ?? 'Umum',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Apoteker ────────────────────────────────────────────
        DB::table('apoteker')->insert([
            'id_user'    => $apoteker->id_user,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ─── Pasien ──────────────────────────────────────────────
        $bpjsData = [
            '0001234567891',
            null,             // pasien tanpa BPJS
            '0001234567892',
        ];
        $riwayat = [
            'Hipertensi, Diabetes Tipe 2',
            null,
            'Asma',
        ];

        foreach ($pasiens as $index => $pasien) {
            DB::table('pasien')->insert([
                'id_user'          => $pasien->id_user,
                'no_bpjs'          => $bpjsData[$index] ?? null,
                'riwayat_penyakit' => $riwayat[$index] ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
