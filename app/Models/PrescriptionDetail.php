<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionDetail extends Model
{
    protected $table = 'prescription_details';
    protected $primaryKey = 'ID_Detail';

    protected $fillable = [
        'ID_Resep',
        'ID_Obat',
        'Jumlah',
        'Dosis',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'ID_Resep', 'ID_Resep');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'ID_Obat', 'ID_Obat');
    }
}
