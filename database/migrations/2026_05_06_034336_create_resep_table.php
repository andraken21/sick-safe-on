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
    Schema::create('resep', function (Blueprint $table) {
        $table->id('ID_Resep');
        $table->unsignedBigInteger('ID_Dokter');
        $table->unsignedBigInteger('ID_Apoteker')->nullable();
        $table->unsignedBigInteger('ID_Pasien');
        $table->date('Tanggal');
        $table->enum('Status', ['pending','validated','completed']);
        $table->text('Catatan')->nullable();
        $table->timestamps();

        $table->foreign('ID_Dokter')->references('ID_Dokter')->on('dokter');
        $table->foreign('ID_Apoteker')->references('ID_Apoteker')->on('apoteker');
        $table->foreign('ID_Pasien')->references('ID_Pasien')->on('pasien');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep');
    }
};
