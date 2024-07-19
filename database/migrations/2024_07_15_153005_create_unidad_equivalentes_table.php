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
        Schema::create('unidades_equivalentes', function (Blueprint $table) {
            $table->id();
            $table->string('unidad_principal',255);
            $table->string('unidad_equivalente',255);
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('unidad_principal')->references('codigo_producto')->on('productos')->onDelete('cascade');
            $table->foreign('unidad_equivalente')->references('codigo_producto')->on('productos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_equivalentes');
    }
};
