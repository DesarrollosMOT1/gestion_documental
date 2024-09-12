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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('producto',255);
            $table->unsignedBigInteger('tercero');
            $table->unsignedBigInteger('unidad');
            $table->unsignedBigInteger('movimiento');
            $table->integer('cantidad');
            $table->unsignedBigInteger('motivo');
            $table->string('detalle_registro');
            $table->timestamps();
            $table->foreign('producto')->references('codigo_producto')->on('productos')->onDelete('cascade');
            $table->foreign('tercero')->references('id')->on('tercerosTest')->onDelete('cascade');
            $table->foreign('unidad')->references('id')->on('unidades')->onDelete('cascade');
            $table->foreign('movimiento')->references('id')->on('movimientos')->onDelete('cascade');
            $table->foreign('motivo')->references('id')->on('motivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
