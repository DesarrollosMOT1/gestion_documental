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
        // Eliminar el campo 'descuento' de la tabla 'cotizaciones'
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn('descuento');
        });

        // Añadir el campo 'descuento' a la tabla 'solicitudes_cotizaciones'
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->decimal('descuento', 8, 2)->nullable()->after('cantidad');
            $table->dropColumn('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar el campo 'descuento' en la tabla 'cotizaciones'
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->decimal('descuento', 8, 2)->nullable();
        });

        // Eliminar el campo 'descuento' de la tabla 'solicitudes_cotizaciones' y restaurar el campo 'estado'
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->dropColumn('descuento');
            $table->string('estado')->after('id_impuestos');
        });
    }
};
