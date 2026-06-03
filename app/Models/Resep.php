<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'reseps';

    protected $fillable = [
        'kode_resep',
        'id_pasien',
        'id_dokter',
        'keluhan',
        'kode_diagnosa',
        'nama_diagnosa',
        'catatan',
        'status',
        'tanggal_resep',
    ];

    protected $casts = [
        'tanggal_resep' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'ID_Pasien');
    }

    public function obats()
    {
        return $this->hasMany(ResepObat::class, 'id_resep');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }
}