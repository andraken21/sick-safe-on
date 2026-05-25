<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id('ID_Pasien');
            $table->unsignedBigInteger('ID_User');
            $table->enum('Jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->date('Tanggal_Lahir')->nullable();
            $table->string('No_BPJS')->nullable();
            $table->text('Riwayat_Penyakit')->nullable();
            $table->string('Alamat')->nullable();
            $table->timestamps();
            $table->foreign('ID_User')->references('ID_User')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
