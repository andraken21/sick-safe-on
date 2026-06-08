<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->id('id_resep');
            $table->timestamps();
        });

        Schema::create('resep_obat', function (Blueprint $table) {
            $table->id('id_resep_obat');
            $table->foreignId('id_resep')->constrained('resep', 'id_resep')->cascadeOnDelete();
            $table->foreignId('id_obat')->constrained('obat', 'id_obat')->restrictOnDelete();
            $table->unsignedSmallInteger('jumlah');
            $table->string('dosis')->comment('Contoh: 500mg, 1g');
            $table->string('satuan')->comment('Contoh: tablet, botol, strip');
            $table->string('aturan_pakai')->comment('Contoh: 3x1, 2x1/2');
            $table->timestamps();
        });

        Schema::create('detail_resep', function (Blueprint $table) {
            $table->id('id_detail_resep');
            $table->foreignId('id_pasien')->constrained('pasien', 'id_pasien')->cascadeOnDelete();
            $table->foreignId('id_dokter')->constrained('dokter', 'id_dokter')->restrictOnDelete();
            $table->foreignId('id_resep')->constrained('resep', 'id_resep')->cascadeOnDelete();
            $table->text('keluhan');
            $table->text('diagnosa')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['menunggu', 'menunggu_pembayaran', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->unsignedTinyInteger('total_obat')->default(0)->comment('Cache jumlah jenis obat dalam resep');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_resep');
        Schema::dropIfExists('resep_obat');
        Schema::dropIfExists('resep');
    }
};
