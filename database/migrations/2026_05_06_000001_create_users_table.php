<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nik')->nullable()->unique();
            $table->string('no_telp')->nullable();
            $table->date('tanggal_lahir')->nullable(); // tambahkan
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('role', ['pasien', 'dokter', 'apoteker', 'admin'])->default('pasien');
            $table->string('alamat')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
