<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailResep extends Model
{
    use HasFactory;

    protected $table      = 'detail_resep';
    protected $primaryKey = 'id_detail_resep';

    protected $fillable = [
        'id_pasien',
        'id_dokter',
        'id_resep',
        'keluhan',
        'diagnosa',
        'keterangan',
        'status',
        'total_obat',
        'tanggal',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    // ── Relasi ──────────────────────────────────────────

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function resep()
    {
        return $this->belongsTo(Resep::class, 'id_resep', 'id_resep');
    }
}
