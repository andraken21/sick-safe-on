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
        Schema::create('dokter', function (Blueprint $table) {

            $table->id('ID_Dokter');

            $table->unsignedBigInteger('ID_User');

            $table->string('Spesialis');

            $table->timestamp('created_at')->useCurrent();

            $table->timestamp('updated_at')
                ->nullable()
                ->useCurrentOnUpdate();

            $table->foreign('ID_User')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};