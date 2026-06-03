<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    protected $table = 'resep_obats';

    protected $fillable = [
        'id_resep',
        'nama_obat',
        'dosis',
        'jumlah',
        'satuan',
        'aturan_pakai',
        'keterangan',
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class, 'id_resep');
    }
}