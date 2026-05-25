<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_details', function (Blueprint $table) {
            $table->id('ID_Detail');
            $table->unsignedBigInteger('ID_Resep');
            $table->unsignedBigInteger('ID_Obat');
            $table->integer('Jumlah');
            $table->string('Dosis')->nullable();
            $table->timestamps();
            $table->foreign('ID_Resep')->references('ID_Resep')->on('prescriptions')->onDelete('cascade');
            $table->foreign('ID_Obat')->references('ID_Obat')->on('medicines')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_details');
    }
};
