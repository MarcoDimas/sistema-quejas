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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('respondido_por');
            $table->string('correo_encargado');
            $table->string('descripcion');
            $table->string('archivo')->nullable();
            $table->unsignedBigInteger('queja_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('queja_id')->references('id')->on('quejas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
