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
    Schema::create('dokter', function (Blueprint $table) {
        $table->id('ID_Dokter');
        $table->unsignedBigInteger('ID_User');
        $table->enum('Jenis_kelamin', ['L','P']);
        $table->string('Spesialis');
        $table->timestamps();

        $table->foreign('ID_User')->references('ID_User')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
