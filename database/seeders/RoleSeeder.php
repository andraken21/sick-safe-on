<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin ───────────────────────────────────────────────
        $admins = DB::table('users')->where('role', 'Admin')->get();
        foreach ($admins as $admin) {
            DB::table('admin')->insert([
                'id_user'    => $admin->id_user,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Dokter ──────────────────────────────────────────────
        $spesialisMap = [
            'tiara@gmail.com' => 'Sp.PD',
            'joel@gmail.com' => 'Sp.A',
            'yuniharahap36@gmail.com' => 'Sp.B',
            'rizkilubis37@gmail.com' => 'Sp.JP',
            'linasinaga42@gmail.com' => 'Sp.S',
            'rezaharahap47@gmail.com' => 'Sp.KK',
            'dewimanurung50@gmail.com' => 'Sp.M',
            'fitrisimanjuntak56@gmail.com' => 'Sp.THT',
            'agusmanurung57@gmail.com' => 'Sp.OT',
            'rinasinaga58@gmail.com' => 'Sp.OG',
            'agussinaga63@gmail.com' => 'Sp.U',
            'linahutagalung64@gmail.com' => 'Sp.P',
            'rezapanjaitan65@gmail.com' => 'Sp.GK',
            'hendrapratama67@gmail.com' => 'Sp.KJ',
            'nurmanurung72@gmail.com' => 'Umum',
            'andilubis73@gmail.com' => 'Sp.PD',
            'budiwijaya74@gmail.com' => 'Sp.A',
            'bayupratama79@gmail.com' => 'Sp.B',
            'rezasimanjuntak85@gmail.com' => 'Sp.JP',
            'dewinasution86@gmail.com' => 'Sp.S',
            'budisinaga103@gmail.com' => 'Sp.KK',
            'wahyusaputra106@gmail.com' => 'Sp.M',
            'bayumanurung107@gmail.com' => 'Sp.THT',
            'rezamanurung108@gmail.com' => 'Sp.OT',
            'nurhutagalung111@gmail.com' => 'Sp.OG',
            'nursinaga115@gmail.com' => 'Sp.U',
            'sitihutagalung116@gmail.com' => 'Sp.P',
            'fajarpanjaitan119@gmail.com' => 'Sp.GK',
            'wahyumanurung124@gmail.com' => 'Sp.KJ',
            'andipanjaitan126@gmail.com' => 'Umum',
            'putrisiregar127@gmail.com' => 'Sp.PD',
            'rudipratama130@gmail.com' => 'Sp.A',
            'rinapanjaitan137@gmail.com' => 'Sp.B',
            'jokosiregar144@gmail.com' => 'Sp.JP',
            'yuniharahap147@gmail.com' => 'Sp.S',
            'putrisiregar153@gmail.com' => 'Sp.KK',
            'jokowijaya160@gmail.com' => 'Sp.M',
            'linaharahap164@gmail.com' => 'Sp.THT',
            'sitihutagalung165@gmail.com' => 'Sp.OT',
            'hendralubis173@gmail.com' => 'Sp.OG',
            'dedisimanjuntak175@gmail.com' => 'Sp.U',
            'putrilubis179@gmail.com' => 'Sp.P',
            'wahyulubis181@gmail.com' => 'Sp.GK',
            'dedilubis182@gmail.com' => 'Sp.KJ',
            'ahmadsimanjuntak185@gmail.com' => 'Umum',
            'rinapratama187@gmail.com' => 'Sp.PD',
            'fitriharahap191@gmail.com' => 'Sp.A',
            'nurpermata192@gmail.com' => 'Sp.B',
            'rezasaputra193@gmail.com' => 'Sp.JP',
            'rinawijaya195@gmail.com' => 'Sp.S',
            'nurmanurung196@gmail.com' => 'Sp.KK',
            'ekosimanjuntak198@gmail.com' => 'Sp.M',
            'indahpermata201@gmail.com' => 'Sp.THT',
            'linalubis202@gmail.com' => 'Sp.OT',
            'bayusaputra203@gmail.com' => 'Sp.OG',
            'rinasitumorang204@gmail.com' => 'Sp.U',
            'fitrisimanjuntak207@gmail.com' => 'Sp.P',
            'wahyuwijaya208@gmail.com' => 'Sp.GK',
            'rinalestari215@gmail.com' => 'Sp.KJ',
            'yunisitumorang217@gmail.com' => 'Umum',
            'rezasiregar220@gmail.com' => 'Sp.PD',
            'rezalubis221@gmail.com' => 'Sp.A',
            'bayusimanjuntak224@gmail.com' => 'Sp.B',
            'dewipanjaitan232@gmail.com' => 'Sp.JP',
            'budipratama233@gmail.com' => 'Sp.S',
            'ayumanurung237@gmail.com' => 'Sp.KK',
            'bayusiregar238@gmail.com' => 'Sp.M',
            'bayusitumorang240@gmail.com' => 'Sp.THT',
            'bayulestari241@gmail.com' => 'Sp.OT',
            'rudilestari242@gmail.com' => 'Sp.OG',
            'rezapratama247@gmail.com' => 'Sp.U',
            'fitripermata253@gmail.com' => 'Sp.P',
            'dewisiregar254@gmail.com' => 'Sp.GK',
            'andisinaga262@gmail.com' => 'Sp.KJ',
            'wahyunasution264@gmail.com' => 'Umum',
            'desisaputra265@gmail.com' => 'Sp.PD',
            'rudisinaga266@gmail.com' => 'Sp.A',
            'fitrilubis268@gmail.com' => 'Sp.B',
            'rudisaputra271@gmail.com' => 'Sp.JP',
            'ahmadsimanjuntak273@gmail.com' => 'Sp.S',
            'ayumanurung274@gmail.com' => 'Sp.KK',
            'nursiregar276@gmail.com' => 'Sp.M',
            'putrisimanjuntak277@gmail.com' => 'Sp.THT',
            'ahmadsinaga278@gmail.com' => 'Sp.OT',
            'dedihutagalung286@gmail.com' => 'Sp.OG',
            'ekosimanjuntak293@gmail.com' => 'Sp.U',
            'putriharahap298@gmail.com' => 'Sp.P',
            'putrihutagalung299@gmail.com' => 'Sp.GK',
            'rizkipermata312@gmail.com' => 'Sp.KJ',
            'linalubis314@gmail.com' => 'Umum',
            'agushutagalung318@gmail.com' => 'Sp.PD',
            'rinasitumorang320@gmail.com' => 'Sp.A',
            'budisinaga321@gmail.com' => 'Sp.B',
            'dedimanurung325@gmail.com' => 'Sp.JP',
            'bayulestari328@gmail.com' => 'Sp.S',
            'linasaputra331@gmail.com' => 'Sp.KK',
            'ayusiregar333@gmail.com' => 'Sp.M',
            'andisinaga336@gmail.com' => 'Sp.THT',
            'hendralubis338@gmail.com' => 'Sp.OT',
            'rinamanurung352@gmail.com' => 'Sp.OG',
            'nursinaga353@gmail.com' => 'Sp.U',
            'rinasiregar355@gmail.com' => 'Sp.P',
            'yunipermata358@gmail.com' => 'Sp.GK',
            'fitrihutagalung359@gmail.com' => 'Sp.KJ',
            'wahyumanurung362@gmail.com' => 'Umum',
            'yunipratama363@gmail.com' => 'Sp.PD',
            'desisimanjuntak366@gmail.com' => 'Sp.A',
            'ekohutagalung367@gmail.com' => 'Sp.B',
            'fitrilubis372@gmail.com' => 'Sp.JP',
            'yunilubis373@gmail.com' => 'Sp.S',
            'fitrisimanjuntak380@gmail.com' => 'Sp.KK',
            'linapanjaitan383@gmail.com' => 'Sp.M',
            'ayumanurung384@gmail.com' => 'Sp.THT',
            'rudisinaga386@gmail.com' => 'Sp.OT',
            'dewisiregar387@gmail.com' => 'Sp.OG',
            'dedipermata389@gmail.com' => 'Sp.U',
            'putriharahap391@gmail.com' => 'Sp.P',
            'rudiharahap395@gmail.com' => 'Sp.GK',
            'hendrasinaga397@gmail.com' => 'Sp.KJ',
            'rudisinaga401@gmail.com' => 'Umum',
            'rezapratama402@gmail.com' => 'Sp.PD',
            'wahyusitumorang404@gmail.com' => 'Sp.A',
            'rezapratama408@gmail.com' => 'Sp.B',
            'budihutagalung409@gmail.com' => 'Sp.JP',
            'putripanjaitan411@gmail.com' => 'Sp.S',
            'yunisiregar418@gmail.com' => 'Sp.KK',
            'rudipermata420@gmail.com' => 'Sp.M',
            'andimanurung423@gmail.com' => 'Sp.THT',
            'fajarpermata426@gmail.com' => 'Sp.OT',
            'rezasiregar427@gmail.com' => 'Sp.OG',
            'indahwijaya434@gmail.com' => 'Sp.U',
            'sitipermata435@gmail.com' => 'Sp.P',
            'hendrapratama438@gmail.com' => 'Sp.GK',
            'ahmadsimanjuntak441@gmail.com' => 'Sp.KJ',
            'andisitumorang442@gmail.com' => 'Umum',
            'ahmadpermata444@gmail.com' => 'Sp.PD',
            'dewisaputra445@gmail.com' => 'Sp.A',
            'rinanasution447@gmail.com' => 'Sp.B',
            'ekosiregar448@gmail.com' => 'Sp.JP',
            'fajarpanjaitan449@gmail.com' => 'Sp.S',
            'bayuhutagalung458@gmail.com' => 'Sp.KK',
            'budinasution465@gmail.com' => 'Sp.M',
            'rizkilestari466@gmail.com' => 'Sp.THT',
            'andimanurung467@gmail.com' => 'Sp.OT',
            'fajarlestari470@gmail.com' => 'Sp.OG',
            'hendrawijaya471@gmail.com' => 'Sp.U',
            'budipanjaitan472@gmail.com' => 'Sp.P',
            'indahsitumorang473@gmail.com' => 'Sp.GK',
            'budisitumorang476@gmail.com' => 'Sp.KJ',
            'ekolestari477@gmail.com' => 'Umum',
            'rinasimanjuntak478@gmail.com' => 'Sp.PD',
            'bayunasution481@gmail.com' => 'Sp.A',
            'ekopanjaitan483@gmail.com' => 'Sp.B',
            'bayulestari487@gmail.com' => 'Sp.JP',
            'putrisaputra489@gmail.com' => 'Sp.S',
            'sitipanjaitan490@gmail.com' => 'Sp.KK',
            'aguspermata491@gmail.com' => 'Sp.M',
            'hendrasimanjuntak496@gmail.com' => 'Sp.THT',
        ];

        $dokters = DB::table('users')->where('role', 'Dokter')->get();
        foreach ($dokters as $dokter) {
            DB::table('dokter')->insert([
                'id_user'    => $dokter->id_user,
                'spesialis'  => $spesialisMap[$dokter->email] ?? 'Umum',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Apoteker ────────────────────────────────────────────
        $apotekers = DB::table('users')->where('role', 'Apoteker')->get();
        foreach ($apotekers as $apoteker) {
            DB::table('apoteker')->insert([
                'id_user'    => $apoteker->id_user,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Pasien ──────────────────────────────────────────────
        $pasiens     = DB::table('users')->where('role', 'Pasien')->get();
        $bpjsCounter = 1;
        foreach ($pasiens as $pasien) {
            DB::table('pasien')->insert([
                'id_user'          => $pasien->id_user,
                'no_bpjs'          => str_pad($bpjsCounter++, 13, '0', STR_PAD_LEFT),
                'riwayat_penyakit' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
