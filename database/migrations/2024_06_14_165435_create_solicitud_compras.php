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
        Schema::create('solicitud_compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_solicitud');
            $table->unsignedBigInteger('nombre');
            $table->string('area');
            $table->string('tipo_factura');
            $table->string('prefijo');
            $table->string('cantidad');
            $table->string('nota');
            $table->string('id_centro_costo'); 
            $table->string('id_referencia_gastos'); 
            $table->timestamps();
            
            $table->foreign('nombre')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_centro_costo')->references('codigo')->on('centro_costos')->onDelete('cascade');
            $table->foreign('id_referencia_gastos')->references('codigo')->on('referencia_gastos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_compras');
    }
};
