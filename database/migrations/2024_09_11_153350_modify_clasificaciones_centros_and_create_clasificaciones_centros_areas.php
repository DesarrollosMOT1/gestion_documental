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
        // Eliminar clave foránea y columna 'id_areas' de 'clasificaciones_centros'
        Schema::table('clasificaciones_centros', function (Blueprint $table) {
            $table->dropForeign(['id_areas']); // Eliminar la clave foránea
            $table->dropColumn('id_areas'); // Eliminar la columna
        });

        // Crear tabla intermedia 'clasificaciones_centros_areas'
        Schema::create('clasificaciones_centros_areas', function (Blueprint $table) {
            $table->id(); // ID de la tabla intermedia
            $table->unsignedBigInteger('id_clasificaciones_centros');
            $table->unsignedBigInteger('id_areas');

            // Definir claves foráneas
            $table->foreign('id_clasificaciones_centros')
                ->references('id')->on('clasificaciones_centros')
                ->onDelete('cascade');

            $table->foreign('id_areas')
                ->references('id')->on('areas')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la tabla intermedia 'clasificaciones_centros_areas'
        Schema::dropIfExists('clasificaciones_centros_areas');

        // Agregar nuevamente la columna 'id_areas' y su clave foránea en 'clasificaciones_centros'
        Schema::table('clasificaciones_centros', function (Blueprint $table) {
            $table->unsignedBigInteger('id_areas');

            $table->foreign('id_areas')
                ->references('id')->on('areas')
                ->onDelete('cascade');
        });
    }
};
