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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo');
            $table->unsignedBigInteger('clase');
            $table->unsignedBigInteger('almacen');
            $table->date('fecha');
            $table->string('descripcion',255);
            $table->timestamps();
            $table->foreign('tipo')->references('id')->on('tipos_movimientos')->onDelete('cascade');
            $table->foreign('clase')->references('id')->on('clases_movimientos')->onDelete('cascade');
            $table->foreign('almacen')->references('id')->on('Almacenes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
