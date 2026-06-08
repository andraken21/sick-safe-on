<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';
    protected $primaryKey = 'ID_Obat';

    protected $fillable = [
        'Nama_Obat',
        'Stok',
        'Harga',
        'Tanggal_Produksi',
        'Tanggal_Kadaluarsa',
    ];

    protected $casts = [
        'Harga' => 'decimal:2',
        'Tanggal_Produksi' => 'date',
        'Tanggal_Kadaluarsa' => 'date',
    ];
}
