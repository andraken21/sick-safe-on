<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apoteker', function (Blueprint $table) {
            $table->id('ID_Apoteker');
            $table->unsignedBigInteger('ID_User');
            $table->timestamps();
            $table->foreign('ID_User')->references('ID_User')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apoteker');
    }
};
