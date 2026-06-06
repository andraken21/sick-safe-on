<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Prescription;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'ID_Pembayaran';

    protected $fillable = [
        'ID_Resep', 'Metode', 'Total_Bayar',
        'Status', 'Tanggal_Bayar',
    ];

    protected $casts = [
        'Total_Bayar' => 'decimal:2',
        'Tanggal_Bayar' => 'date',
    ];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'ID_Resep', 'ID_Resep');
    }
}
