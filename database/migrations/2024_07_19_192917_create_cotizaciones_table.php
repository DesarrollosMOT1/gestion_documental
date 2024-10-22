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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_cotizacion');
            $table->string('nombre');
            $table->decimal('valor', 8, 2);
            $table->text('condiciones_pago');
            $table->decimal('descuento', 8, 2)->nullable();
            $table->unsignedBigInteger('id_terceros');
            $table->timestamps();
            
            $table->foreign('id_terceros')->references('id')->on('terceros');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
