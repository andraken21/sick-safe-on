<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('kategori_obat')->unique();
            $table->timestamps();
        });

        Schema::create('obat', function (Blueprint $table) {
            $table->id('id_obat');
            $table->string('nama_obat');
            $table->foreignId('id_kategori')->constrained('kategori', 'id_kategori')->restrictOnDelete();
            $table->unsignedInteger('stok')->default(0);
            $table->decimal('harga', 10, 2);
            $table->enum('status', ['tersedia', 'habis', 'menipis'])->default('tersedia');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obat');
        Schema::dropIfExists('kategori');
    }
};
