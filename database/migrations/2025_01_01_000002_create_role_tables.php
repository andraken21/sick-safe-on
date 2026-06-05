<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id('id_pasien');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('no_bpjs', 13)->unique()->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->timestamps();
        });

        Schema::create('dokter', function (Blueprint $table) {
            $table->id('id_dokter');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('spesialis');
            $table->timestamps();
        });

        Schema::create('apoteker', function (Blueprint $table) {
            $table->id('id_apoteker');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
        Schema::dropIfExists('apoteker');
        Schema::dropIfExists('dokter');
        Schema::dropIfExists('pasien');
    }
};
