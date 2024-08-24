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
        Schema::table('niveles_uno', function (Blueprint $table) {
            // Eliminar la relación foránea
            $table->dropForeign(['id_clasificaciones_centros']);
            // Eliminar la columna
            $table->dropColumn('id_clasificaciones_centros');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('niveles_uno', function (Blueprint $table) {
            // Restaurar la columna
            $table->unsignedBigInteger('id_clasificaciones_centros');
            // Restaurar la relación foránea
            $table->foreign('id_clasificaciones_centros')->references('id')->on('clasificaciones_centros');
        });
    }
};
