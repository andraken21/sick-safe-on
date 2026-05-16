<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('ID_Pembayaran');
            $table->unsignedBigInteger('ID_Resep');
            $table->string('Metode')->nullable();
            $table->decimal('Total_Bayar', 14, 2)->default(0);
            $table->enum('Status', ['pending', 'lunas', 'gagal'])->default('pending');
            $table->date('Tanggal_Bayar')->nullable();
            $table->timestamps();
            $table->foreign('ID_Resep')->references('ID_Resep')->on('prescriptions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
