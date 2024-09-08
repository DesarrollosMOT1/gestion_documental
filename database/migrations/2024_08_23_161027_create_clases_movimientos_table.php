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
        Schema::create('clases_movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',255);
            $table->string('descripcion',255);
            $table->unsignedBigInteger('tipo');
            $table->timestamps();
            $table->foreign('tipo')->references('id')->on('tipos_movimientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases_movimientos');
    }
};
