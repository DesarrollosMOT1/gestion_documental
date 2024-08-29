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
        Schema::create('centros_costos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_mekano');
            $table->string('nombre');
            $table->unsignedBigInteger('id_clasificaciones_centros');
            $table->foreign('id_clasificaciones_centros')->references('id')->on('clasificaciones_centros');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centros_costos');
    }
};
