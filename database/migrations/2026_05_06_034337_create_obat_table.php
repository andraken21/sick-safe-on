<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('obat', function (Blueprint $table) {
        $table->id('ID_Obat');
        $table->string('Nama_Obat');
        $table->integer('Stok');
        $table->decimal('Harga', 10, 2);
        $table->date('Tanggal_Produksi');
        $table->date('Tanggal_Kadaluarsa');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
