<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_pasien')->constrained('pasien', 'id_pasien')->cascadeOnDelete();
            $table->decimal('total_bayar', 12, 2);
            $table->enum('status', ['pending', 'lunas', 'batal'])->default('pending');
            $table->enum('metode', ['bpjs', 'transfer', 'qris'])->nullable();
            $table->timestamps();
        });

        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->foreignId('id_transaksi')->constrained('transaksi', 'id_transaksi')->cascadeOnDelete();
            $table->foreignId('id_resep')->constrained('resep', 'id_resep')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
    }
};
