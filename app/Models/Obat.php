<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table      = 'obat';
    protected $primaryKey = 'id_obat';

    protected $fillable = [
        'nama_obat',
        'id_kategori',
        'stok',
        'harga',
        'status',
        'tanggal_kadaluarsa',
    ];

    protected function casts(): array
    {
        return [
            'harga'              => 'decimal:2',
            'tanggal_kadaluarsa' => 'date',
        ];
    }

    // ── Relasi ──────────────────────────────────────────

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'id_obat', 'id_obat');
    }

    // ── Accessor: cek stok ───────────────────────────────

    public function getIsStokHabisAttribute(): bool
    {
        return $this->stok === 0;
    }
}
