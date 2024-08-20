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
        Schema::create('consolidaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_solicitudes_compras');
            $table->unsignedBigInteger('id_solicitud_elemento');
            $table->integer('estado')->default(0); // Usando checkbox (0 o 1)
            $table->integer('cantidad');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('id_solicitudes_compras')->references('id')->on('solicitudes_compras')->onDelete('cascade');
            $table->foreign('id_solicitud_elemento')->references('id')->on('solicitudes_elementos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consolidaciones');
    }
};
