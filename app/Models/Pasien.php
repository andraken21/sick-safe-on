<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table      = 'pasien';
    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'id_user',
        'no_bpjs',
        'riwayat_penyakit',
    ];

    // ── Relasi ──────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function antrian()
    {
        return $this->hasMany(Antrian::class, 'id_pasien', 'id_pasien');
    }

    public function detailResep()
    {
        return $this->hasMany(DetailResep::class, 'id_pasien', 'id_pasien');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pasien', 'id_pasien');
    }
}
