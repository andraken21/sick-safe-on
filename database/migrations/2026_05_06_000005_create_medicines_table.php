<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('ID_Obat');
            $table->string('Nama_Obat');
            $table->integer('Stok')->default(0);
            $table->decimal('Harga', 12, 2)->default(0);
            $table->date('Tanggal_Produksi')->nullable();
            $table->date('Tanggal_Kadaluarsa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
