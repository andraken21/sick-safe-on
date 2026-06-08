<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
<<<<<<< HEAD
    protected $table = 'pasien';
    protected $primaryKey = 'ID_Pasien';

    protected $fillable = [
        'ID_User',
        'Jenis_kelamin',
        'Tanggal_Lahir',
        'No_BPJS',
        'Riwayat_Penyakit',
        'Alamat',
    ];

    protected $casts = [
        'Tanggal_Lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_User', 'ID_User');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'ID_Pasien', 'ID_Pasien');
=======
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
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
    }
}
