<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table      = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_pasien',
        'total_bayar',
        'status',
        'metode',
    ];

    protected function casts(): array
    {
        return [
            'total_bayar' => 'decimal:2',
        ];
    }

    // ── Relasi ──────────────────────────────────────────

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
