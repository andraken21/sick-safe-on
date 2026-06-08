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
 
        // helper untuk insert satu transaksi + detail
        $buatTransaksi = function (
            int     $idxPasien,
            int     $idxResep,
            float   $totalBayar,
            string  $status,
            ?string $metode
        ) use ($pasiens, $reseps): void {
            $trx = DB::table('transaksi')->insertGetId([
                'id_pasien'   => $pasiens[$idxPasien]->id_pasien,
                'total_bayar' => $totalBayar,
                'status'      => $status,
                'metode'      => $metode,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
 
            DB::table('detail_transaksi')->insert([
                'id_transaksi' => $trx,
                'id_resep'     => $reseps[$idxResep]->id_resep,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        };
 
        // idx pasien disesuaikan dengan ResepSeeder (pasien ke-N di detail_resep)
        // idx resep 0-based sesuai urutan insert di ResepSeeder
 
        // 1  - Pasien[0]  Resep[0]  BPJS lunas
        $buatTransaksi(0, 0, 0.00, 'lunas', 'bpjs');
 
        // 2  - Pasien[1]  Resep[1]  transfer lunas
        $buatTransaksi(1, 1, 185000.00, 'lunas', 'transfer');
 
        // 3  - Pasien[2]  Resep[2]  qris lunas
        $buatTransaksi(2, 2, 21000.00, 'lunas', 'qris');
 
        // 4  - Pasien[3]  Resep[3]  transfer lunas
        $buatTransaksi(3, 3, 37000.00, 'lunas', 'transfer');
 
        // 5  - Pasien[4]  Resep[4]  qris lunas
        $buatTransaksi(4, 4, 25000.00, 'lunas', 'qris');
 
        // 6  - Pasien[5]  Resep[5]  bpjs lunas
        $buatTransaksi(5, 5, 0.00, 'lunas', 'bpjs');
 
        // 7  - Pasien[6]  Resep[6]  transfer lunas
        $buatTransaksi(6, 6, 120000.00, 'lunas', 'transfer');
 
        // 8  - Pasien[7]  Resep[7]  qris lunas
        $buatTransaksi(7, 7, 55000.00, 'lunas', 'qris');
 
        // 9  - Pasien[8]  Resep[8]  transfer lunas
        $buatTransaksi(8, 8, 62000.00, 'lunas', 'transfer');
 
        // 10 - Pasien[9]  Resep[9]  qris lunas
        $buatTransaksi(9, 9, 18000.00, 'lunas', 'qris');
 
        // 11 - Pasien[10] Resep[10] bpjs lunas
        $buatTransaksi(10, 10, 0.00, 'lunas', 'bpjs');
 
        // 12 - Pasien[11] Resep[11] transfer lunas
        $buatTransaksi(11, 11, 45000.00, 'lunas', 'transfer');
 
        // 13 - Pasien[12] Resep[12] qris lunas
        $buatTransaksi(12, 12, 78000.00, 'lunas', 'qris');
 
        // 14 - Pasien[13] Resep[13] bpjs lunas
        $buatTransaksi(13, 13, 0.00, 'lunas', 'bpjs');
 
        // 15 - Pasien[14] Resep[14] transfer lunas
        $buatTransaksi(14, 14, 32000.00, 'lunas', 'transfer');
 
        // 16 - Pasien[15] Resep[15] qris lunas
        $buatTransaksi(15, 15, 27000.00, 'lunas', 'qris');
 
        // 17 - Pasien[16] Resep[16] transfer lunas
        $buatTransaksi(16, 16, 96000.00, 'lunas', 'transfer');
 
        // 18 - Pasien[17] Resep[17] bpjs lunas
        $buatTransaksi(17, 17, 0.00, 'lunas', 'bpjs');
 
        // 19 - Pasien[18] Resep[18] qris lunas
        $buatTransaksi(18, 18, 42000.00, 'lunas', 'qris');
 
        // 20 - Pasien[0]  Resep[19] pending (resep ke-20 yang masih diproses)
        $buatTransaksi(0, 19, 9000.00, 'pending', null);
    }
}