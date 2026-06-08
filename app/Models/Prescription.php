<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prescription extends Model
{
    protected $table = 'prescriptions';
    protected $primaryKey = 'ID_Resep';

    protected $fillable = [
        'ID_Dokter',
        'ID_Apoteker',
        'ID_Pasien',
        'Tanggal',
        'Status',
        'Catatan',
    ];

    protected $casts = [
        'Tanggal' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'ID_Pasien', 'ID_Pasien');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'ID_Dokter', 'ID_Dokter');
    }

    public function apoteker(): BelongsTo
    {
        return $this->belongsTo(Apoteker::class, 'ID_Apoteker', 'ID_Apoteker');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PrescriptionDetail::class, 'ID_Resep', 'ID_Resep');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'ID_Resep', 'ID_Resep');
    }
}
