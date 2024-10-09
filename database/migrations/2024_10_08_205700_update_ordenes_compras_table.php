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
        Schema::table('ordenes_compras', function (Blueprint $table) {
            // Eliminar columnas existentes
            $table->dropColumn(['subtotal', 'total', 'cantidad_total', 'nota']);
            
            // Añadir la nueva columna foránea
            $table->unsignedBigInteger('id_terceros');
            $table->foreign('id_terceros')->references('id')->on('terceros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes_compras', function (Blueprint $table) {
            // Añadir las columnas de nuevo en la reversión
            $table->decimal('subtotal', 8, 2);
            $table->decimal('total', 8, 2);
            $table->integer('cantidad_total');
            $table->text('nota');

            // Eliminar la clave foránea y la columna
            $table->dropForeign(['id_terceros']);
            $table->dropColumn('id_terceros');
        });
    }
};
