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
    Schema::create('pembayaran', function (Blueprint $table) {
        $table->id('ID_Pembayaran');
        $table->unsignedBigInteger('ID_Resep');
        $table->string('Metode');
        $table->decimal('Total_Bayar', 10, 2);
        $table->enum('Status', ['unpaid','paid']);
        $table->date('Tanggal_Bayar');
        $table->timestamps();

        $table->foreign('ID_Resep')->references('ID_Resep')->on('resep')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
