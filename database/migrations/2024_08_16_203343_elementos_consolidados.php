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
        Schema::create('elementos_consolidados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_consolidacion');
            $table->unsignedBigInteger('id_solicitud_compra');
            $table->unsignedBigInteger('id_solicitud_elemento');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('id_consolidacion')->references('id')->on('consolidaciones')->onDelete('cascade');
            $table->foreign('id_solicitud_compra')->references('id')->on('solicitudes_compras')->onDelete('cascade');
            $table->foreign('id_solicitud_elemento')->references('id')->on('solicitudes_elementos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos_consolidados');
    }
};
