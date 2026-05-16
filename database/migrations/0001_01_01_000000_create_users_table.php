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
            $table->id(); // bigint, auto_increment, primary key
            $table->string('email', 255)->unique();
            $table->string('nama', 255);
            $table->string('password', 255);
            $table->date('tanggal_lahir'); //->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);; //->nullable();
            $table->string('no_telp', 15); //->nullable();
            
            // Kolom role sesuai pilihan di gambar
            $table->enum('role', ['Admin', 'Pasien', 'Apoteker', 'Dokter']);
            
            $table->char('nik', 16)->unique();
            $table->text('alamat'); //->nullable();
            
            // Kolom created_at & updated_at dengan default sesuai gambar
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};