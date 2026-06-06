<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
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
    }
}
