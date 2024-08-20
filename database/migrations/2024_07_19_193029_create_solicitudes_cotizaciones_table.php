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
        Schema::create('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_solicitudes_compras');
            $table->unsignedBigInteger('id_cotizaciones');
            $table->integer('cantidad');
            $table->unsignedBigInteger('id_impuestos');
            $table->string('estado');
            $table->timestamps();
            
            $table->foreign('id_solicitudes_compras')->references('id')->on('solicitudes_compras');
            $table->foreign('id_cotizaciones')->references('id')->on('cotizaciones');
            $table->foreign('id_impuestos')->references('id')->on('impuestos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_cotizaciones');
    }
};
