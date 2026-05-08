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
    Schema::create('resep_detail', function (Blueprint $table) {
        $table->id('ID_Detail');
        $table->unsignedBigInteger('ID_Resep');
        $table->unsignedBigInteger('ID_Obat');
        $table->integer('Jumlah');
        $table->string('Dosis');
        $table->timestamps();

        $table->foreign('ID_Resep')->references('ID_Resep')->on('resep')->onDelete('cascade');
        $table->foreign('ID_Obat')->references('ID_Obat')->on('obat')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_detail');
    }
};
