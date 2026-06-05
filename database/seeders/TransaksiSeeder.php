<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = DB::table('pasien')->get();
        $reseps  = DB::table('resep')->orderBy('id_resep')->get();

        // ─── Transaksi 1 (Pasien 1 - Resep 1, BPJS, lunas) ──────
        $trx1 = DB::table('transaksi')->insertGetId([
            'id_pasien'   => $pasiens[0]->id_pasien,
            'total_bayar' => 0.00,          // ditanggung BPJS
            'status'      => 'lunas',
            'metode'      => 'bpjs',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $trx1,
            'id_resep'     => $reseps[0]->id_resep,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // ─── Transaksi 2 (Pasien 2 - Resep 2, transfer, lunas) ───
        $trx2 = DB::table('transaksi')->insertGetId([
            'id_pasien'   => $pasiens[1]->id_pasien,
            'total_bayar' => 185000.00,
            'status'      => 'lunas',
            'metode'      => 'transfer',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $trx2,
            'id_resep'     => $reseps[1]->id_resep,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // ─── Transaksi 3 (Pasien 3 - Resep 3, qris, lunas) ──────
        $trx3 = DB::table('transaksi')->insertGetId([
            'id_pasien'   => $pasiens[2]->id_pasien,
            'total_bayar' => 21000.00,
            'status'      => 'lunas',
            'metode'      => 'qris',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $trx3,
            'id_resep'     => $reseps[2]->id_resep,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // ─── Transaksi 4 (Pasien 1 - Resep 4, pending) ───────────
        $trx4 = DB::table('transaksi')->insertGetId([
            'id_pasien'   => $pasiens[0]->id_pasien,
            'total_bayar' => 9000.00,
            'status'      => 'pending',
            'metode'      => null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $trx4,
            'id_resep'     => $reseps[3]->id_resep,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}
