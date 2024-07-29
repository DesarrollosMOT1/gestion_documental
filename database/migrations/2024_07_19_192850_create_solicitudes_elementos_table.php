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
        Schema::create('solicitudes_elementos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_niveles_tres');
            $table->unsignedBigInteger('id_solicitudes_compra');
            $table->string('id_centros_costos');
            $table->integer('cantidad');
            $table->string('estado')->nullable(); 
            $table->timestamps();
            
            $table->foreign('id_niveles_tres')->references('id')->on('niveles_tres');
            $table->foreign('id_solicitudes_compra')->references('id')->on('solicitudes_compras');
            $table->foreign('id_centros_costos')->references('codigo')->on('centros_costos');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_elementos');
    }
};
