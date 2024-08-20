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
        Schema::create('ordenes_compra_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ordenes_compras');
            $table->unsignedBigInteger('id_solicitudes_cotizaciones');
            $table->unsignedBigInteger('id_entradas');
            $table->timestamps();
            
            $table->foreign('id_ordenes_compras')->references('id')->on('ordenes_compras');
            $table->foreign('id_solicitudes_cotizaciones')->references('id')->on('solicitudes_cotizaciones');
            $table->foreign('id_entradas')->references('id')->on('entradas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra_cotizaciones');
    }
};
