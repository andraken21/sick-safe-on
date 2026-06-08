<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 
class ResepSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = DB::table('pasien')->get();
        $dokters = DB::table('dokter')->get();
        $obats   = DB::table('obat')->get()->keyBy('nama_obat');
 
        // helper closure untuk insert satu resep lengkap
        $buatResep = function (
            array $obatList,   // [['nama_obat' => ..., 'jumlah' => ..., 'dosis' => ...], ...]
            int   $idPasien,
            int   $idDokter,
            string $keluhan,
            ?string $diagnosa,
            ?string $keterangan,
            string $status,
            string $tanggal
        ) use ($obats): int {
            $idResep = DB::table('resep')->insertGetId([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
 
            $rows = [];
            foreach ($obatList as $o) {
                // 1. Tentukan satuan secara dinamis berdasarkan nama obatnya
                $satuan = str_contains(strtolower($o['nama_obat']), 'ml') ? 'Botol' : 'Tablet';

                // 2. Tentukan aturan pakai secara dinamis
                $dosisLower = strtolower($o['dosis']);
                if (str_contains($dosisLower, 'oles')) {
                    $aturanPakai = 'Obat Luar (Dioleskan)';
                } elseif (str_contains(strtolower($o['nama_obat']), 'omeprazole') || str_contains(strtolower($o['nama_obat']), 'lambucid')) {
                    $aturanPakai = 'Sebelum Makan';
                } else {
                    $aturanPakai = 'Sesudah Makan'; // Default umum untuk obat lainnya
                }

                // 3. FIX ERROR: Logika pencarian obat pintar (Fallback handler)
                $idObatTerpilih = null;
                $namaObatInput = $o['nama_obat'];

                if (isset($obats[$namaObatInput])) {
                    // Jika nama obat pas 100% cocok dengan database
                    $idObatTerpilih = $obats[$namaObatInput]->id_obat;
                } else {
                    // Jika tidak cocok pas, cari obat yang mengandung kata depannya (misal: "Amlodipine 5mg" -> "Amlodipine 50mg")
                    $kataDepan = explode(' ', $namaObatInput)[0];
                    $obatMirip = $obats->filter(function ($item) use ($kataDepan) {
                        return str_contains(strtolower($item->nama_obat), strtolower($kataDepan));
                    })->first();

                    // Jika ditemukan obat mirip pakai itu, jika benar-benar buntu gunakan obat pertama di database
                    $idObatTerpilih = $obatMirip ? $obatMirip->id_obat : ($obats->first()->id_obat ?? 1);
                }

                $rows[] = [
                    'id_resep'     => $idResep,
                    'id_obat'      => $idObatTerpilih,
                    'jumlah'       => $o['jumlah'],
                    'dosis'        => $o['dosis'],
                    'satuan'       => $satuan,
                    'aturan_pakai' => $aturanPakai,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }
            DB::table('resep_obat')->insert($rows);
 
            DB::table('detail_resep')->insert([
                'id_pasien'  => $idPasien,
                'id_dokter'  => $idDokter,
                'id_resep'   => $idResep,
                'keluhan'    => $keluhan,
                'diagnosa'   => $diagnosa,
                'keterangan' => $keterangan,
                'status'     => $status,
                'total_obat' => count($obatList),
                'tanggal'    => $tanggal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
 
            return $idResep;
        };
 
        // ─── 1 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Clindamycin 300mg',           'jumlah' => 10, 'dosis' => '3x1'],
                ['nama_obat' => 'Fasidol / paracetamol 500mg', 'jumlah' => 6,  'dosis' => '3x1'],
            ],
            $pasiens[0]->id_pasien ?? 1, $dokters[0]->id_dokter ?? 1,
            'Batuk, pilek, dan demam selama 3 hari',
            'Infeksi Saluran Pernapasan Atas (ISPA)',
            'Istirahat cukup dan minum air putih yang banyak',
            'selesai', '2025-01-10'
        );
 
        // ─── 2 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Amlodipine 5mg',              'jumlah' => 30, 'dosis' => '1x1'], // <--- Otomatis dicarikan ke Amlodipine 50mg/500mg/besilate
                ['nama_obat' => 'Metformin 500mg',             'jumlah' => 60, 'dosis' => '2x1'],
                ['nama_obat' => 'Xonce Vit C 500',             'jumlah' => 30, 'dosis' => '1x1'],
            ],
            $pasiens[1]->id_pasien ?? 1, $dokters[0]->id_dokter ?? 1,
            'Sering pusing, mudah lelah, dan sering haus',
            'Hipertensi + Diabetes Mellitus Tipe 2',
            'Kontrol rutin setiap bulan. Kurangi konsumsi gula dan garam',
            'selesai', '2025-01-10'
        );
 
        // ─── 3 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Cetirizine 10mg', 'jumlah' => 7, 'dosis' => '1x1'],
            ],
            $pasiens[2]->id_pasien ?? 1, $dokters[1]->id_dokter ?? 1,
            'Gatal-gatal dan bersin-bersin setelah makan udang',
            'Alergi Makanan',
            'Hindari makanan pemicu alergi',
            'selesai', '2025-01-11'
        );
 
        // ─── 4 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Omeprazole',      'jumlah' => 14, 'dosis' => '2x1'],
                ['nama_obat' => 'Lambucid 100ml',  'jumlah' => 1,  'dosis' => '3x1'],
            ],
            $pasiens[3]->id_pasien ?? 1, $dokters[1]->id_dokter ?? 1,
            'Nyeri ulu hati dan mual setelah makan',
            'Gastritis Akut',
            'Hindari makanan pedas dan asam. Makan tepat waktu',
            'selesai', '2025-01-12'
        );
 
        // ─── 5 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Itraconazole 100mg', 'jumlah' => 14, 'dosis' => '1x1'],
                ['nama_obat' => 'Clotrimazole',        'jumlah' => 1,  'dosis' => 'Oleskan 2x sehari'],
            ],
            $pasiens[4]->id_pasien ?? 1, $dokters[2]->id_dokter ?? 1,
            'Kulit bersisik dan gatal di sela jari kaki',
            'Tinea Pedis (Kutu Air)',
            'Jaga kebersihan dan kekeringan kaki',
            'selesai', '2025-01-13'
        );
 
        // ─── 6 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Salbutamol 250mg', 'jumlah' => 10, 'dosis' => '3x1'],
                ['nama_obat' => 'Ambroxol 20mg',    'jumlah' => 10, 'dosis' => '3x1'],
            ],
            $pasiens[5]->id_pasien ?? 1, $dokters[2]->id_dokter ?? 1,
            'Sesak napas dan mengi saat beraktivitas',
            'Asma Bronkial',
            'Hindari paparan debu dan asap rokok',
            'selesai', '2025-01-13'
        );
 
        // ─── 7 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Metformin 500mg',  'jumlah' => 60, 'dosis' => '2x1'],
                ['nama_obat' => 'Xonce Vit C 500',  'jumlah' => 30, 'dosis' => '1x1'],
            ],
            $pasiens[6]->id_pasien ?? 1, $dokters[3]->id_dokter ?? 1,
            'Sering buang air kecil, mudah lapar, dan berat badan turun',
            'Diabetes Mellitus Tipe 2',
            'Diet rendah gula, olahraga rutin, cek gula darah berkala',
            'selesai', '2025-01-14'
        );
 
        // ─── 8 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Amlodipine 5mg',   'jumlah' => 30, 'dosis' => '1x1'],
                ['nama_obat' => 'Neuralgin Rx',      'jumlah' => 10, 'dosis' => '2x1'],
            ],
            $pasiens[7]->id_pasien ?? 1, $dokters[3]->id_dokter ?? 1,
            'Sakit kepala berdenyut dan tengkuk terasa kaku',
            'Hipertensi Grade 1',
            'Kurangi konsumsi garam. Kontrol tekanan darah setiap minggu',
            'selesai', '2025-01-14'
        );
 
        // ─── 9 ───────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Renadinac (Diclofenac 50)', 'jumlah' => 10, 'dosis' => '2x1'],
                ['nama_obat' => 'Fasidol / paracetamol 500mg', 'jumlah' => 10, 'dosis' => '3x1'],
            ],
            $pasiens[8]->id_pasien ?? 1, $dokters[0]->id_dokter ?? 1,
            'Nyeri sendi lutut kanan sejak seminggu lalu',
            'Osteoarthritis Lutut',
            'Kompres hangat pada lutut. Hindari aktivitas berat',
            'selesai', '2025-01-15'
        );
 
        // ─── 10 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Loratadine 10mg',  'jumlah' => 10, 'dosis' => '1x1'],
                ['nama_obat' => 'Xonce Vit C 500',  'jumlah' => 15, 'dosis' => '1x1'],
            ],
            $pasiens[9]->id_pasien ?? 1, $dokters[1]->id_dokter ?? 1,
            'Bersin-bersin di pagi hari dan hidung tersumbat',
            'Rinitis Alergi',
            'Hindari paparan debu dan bulu hewan',
            'selesai', '2025-01-15'
        );
 
        // ─── 11 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Cefixime 100mg',   'jumlah' => 10, 'dosis' => '2x1'],
                ['nama_obat' => 'Omeprazole',        'jumlah' => 10, 'dosis' => '1x1'],
            ],
            $pasiens[10]->id_pasien ?? 1, $dokters[4]->id_dokter ?? 1,
            'Demam tinggi, nyeri saat buang air kecil',
            'Infeksi Saluran Kemih (ISK)',
            'Perbanyak minum air putih. Selesaikan antibiotik',
            'selesai', '2025-01-16'
        );
 
        // ─── 12 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Mefenamic Acid 500mg', 'jumlah' => 9,  'dosis' => '3x1'],
                ['nama_obat' => 'Fasidol / paracetamol 500mg', 'jumlah' => 6, 'dosis' => '3x1'],
            ],
            $pasiens[11]->id_pasien ?? 1, $dokters[4]->id_dokter ?? 1,
            'Nyeri perut bagian bawah saat menstruasi',
            'Dismenore Primer',
            'Kompres hangat pada perut. Istirahat cukup',
            'selesai', '2025-01-17'
        );
 
        // ─── 13 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Levofloxacin 500mg', 'jumlah' => 7,  'dosis' => '1x1'],
                ['nama_obat' => 'Ambroxol 20mg',       'jumlah' => 10, 'dosis' => '3x1'],
            ],
            $pasiens[12]->id_pasien ?? 1, $dokters[0]->id_dokter ?? 1,
            'Batuk berdahak warna kuning kehijauan lebih dari seminggu',
            'Bronkitis Akut',
            'Istirahat cukup. Selesaikan antibiotik sampai habis',
            'selesai', '2025-01-18'
        );
 
        // ─── 14 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Metformin 500mg',   'jumlah' => 30, 'dosis' => '1x1'],
                ['nama_obat' => 'Amlodipine 5mg',    'jumlah' => 30, 'dosis' => '1x1'],
                ['nama_obat' => 'Atorvastatin 20mg', 'jumlah' => 30, 'dosis' => '1x1'],
            ],
            $pasiens[13]->id_pasien ?? 1, $dokters[1]->id_dokter ?? 1,
            'Kontrol rutin. Gula darah dan tekanan darah tidak terkontrol',
            'DM Tipe 2 + Hipertensi + Dislipidemia',
            'Kontrol tiap bulan. Jaga pola makan dan aktivitas fisik',
            'selesai', '2025-01-19'
        );
 
        // ─── 15 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Ketorolac 10mg',    'jumlah' => 5,  'dosis' => '3x1'],
                ['nama_obat' => 'Omeprazole',         'jumlah' => 10, 'dosis' => '2x1'],
            ],
            $pasiens[14]->id_pasien ?? 1, $dokters[2]->id_dokter ?? 1,
            'Nyeri punggung bawah setelah mengangkat benda berat',
            'Low Back Pain (LBP) Akut',
            'Hindari mengangkat beban berat. Fisioterapi jika nyeri berlanjut',
            'selesai', '2025-01-20'
        );
 
        // ─── 16 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Cetirizine 10mg',             'jumlah' => 7,  'dosis' => '1x1'],
                ['nama_obat' => 'Fasidol / paracetamol 500mg', 'jumlah' => 9,  'dosis' => '3x1'],
            ],
            $pasiens[15]->id_pasien ?? 1, $dokters[3]->id_dokter ?? 1,
            'Demam, ruam merah di kulit, dan gatal seluruh tubuh',
            'Urtikaria',
            'Hindari pemicu alergi. Kembali jika ruam tidak membaik dalam 3 hari',
            'selesai', '2025-01-21'
        );
 
        // ─── 17 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Clindamycin 300mg', 'jumlah' => 14, 'dosis' => '2x1'],
                ['nama_obat' => 'Neuralgin Rx',       'jumlah' => 10, 'dosis' => '3x1'],
            ],
            $pasiens[16]->id_pasien ?? 1, $dokters[4]->id_dokter ?? 1,
            'Gigi berlubang disertai nyeri berdenyut dan bengkak pada gusi',
            'Abses Dentoalveolar',
            'Selesaikan antibiotik. Rujuk ke dokter gigi untuk tindakan lanjut',
            'selesai', '2025-01-22'
        );
 
        // ─── 18 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Omeprazole',         'jumlah' => 14, 'dosis' => '2x1'],
                ['nama_obat' => 'Lambucid 100ml',     'jumlah' => 1,  'dosis' => '3x2 sendok'],
                ['nama_obat' => 'Domperidone 10mg',   'jumlah' => 10, 'dosis' => '3x1'],
            ],
            $pasiens[17]->id_pasien ?? 1, $dokters[0]->id_dokter ?? 1,
            'Mual, muntah, dan perut terasa penuh setelah makan',
            'Dispepsia Fungsional',
            'Makan porsi kecil tapi sering. Hindari makanan berlemak',
            'selesai', '2025-01-23'
        );
 
        // ─── 19 ──────────────────────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Amlodipine 5mg',    'jumlah' => 30, 'dosis' => '1x1'],
                ['nama_obat' => 'Xonce Vit C 500',   'jumlah' => 30, 'dosis' => '1x1'],
            ],
            $pasiens[18]->id_pasien ?? 1, $dokters[1]->id_dokter ?? 1,
            'Pusing dan penglihatan kabur, tekanan darah 160/100',
            'Hipertensi Grade 2',
            'Minum obat rutin. Batasi aktivitas berat. Kontrol 2 minggu lagi',
            'selesai', '2025-01-24'
        );
 
        // ─── 20 (masih diproses) ──────────────────────────────────
        $buatResep(
            [
                ['nama_obat' => 'Fasidol / paracetamol 500mg', 'jumlah' => 9, 'dosis' => '3x1'],
            ],
            $pasiens[0]->id_pasien ?? 1, $dokters[1]->id_dokter ?? 1,
            'Demam tinggi dan sakit kepala',
            null,
            null,
            'diproses', now()->toDateString()
        );
    }
}