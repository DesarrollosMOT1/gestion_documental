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
        // Crear la tabla agrupaciones_consolidaciones
        Schema::create('agrupaciones_consolidaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('fecha_cotizacion');
            $table->timestamps();

            // Llave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Modificar la tabla consolidaciones para añadir la clave foránea
        Schema::table('consolidaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('agrupacion_id')->nullable()->after('id'); // Añadir columna para la clave foránea

            // Llave foránea
            $table->foreign('agrupacion_id')->references('id')->on('agrupaciones_consolidaciones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la clave foránea y la columna en la tabla consolidaciones
        Schema::table('consolidaciones', function (Blueprint $table) {
            $table->dropForeign(['agrupacion_id']);
            $table->dropColumn('agrupacion_id');
        });

        // Eliminar la tabla agrupaciones_consolidaciones
        Schema::dropIfExists('agrupaciones_consolidaciones');
    }
};