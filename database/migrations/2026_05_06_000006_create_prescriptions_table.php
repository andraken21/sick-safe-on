<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id('ID_Resep');
            $table->unsignedBigInteger('ID_Dokter');
            $table->unsignedBigInteger('ID_Apoteker')->nullable();
            $table->unsignedBigInteger('ID_Pasien');
            $table->date('Tanggal');
            $table->enum('Status', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->text('Catatan')->nullable();
            $table->timestamps();
            $table->foreign('ID_Dokter')->references('ID_Dokter')->on('dokter')->onDelete('cascade');
            $table->foreign('ID_Apoteker')->references('ID_Apoteker')->on('apoteker')->onDelete('set null');
            $table->foreign('ID_Pasien')->references('ID_Pasien')->on('pasien')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
