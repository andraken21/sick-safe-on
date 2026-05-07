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
    Schema::create('users', function (Blueprint $table) {
        $table->id('ID_User');
        $table->string('Nama');
        $table->string('Email')->unique();
        $table->string('Password');
        $table->string('No_Hp')->nullable();
        $table->enum('Role', ['pasien','dokter','apoteker','admin']);
        $table->string('Alamat')->nullable();
        $table->enum('Status', ['aktif','nonaktif'])->default('aktif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
