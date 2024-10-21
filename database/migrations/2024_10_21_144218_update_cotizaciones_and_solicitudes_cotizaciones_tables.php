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
        // Modificar la tabla cotizaciones
        Schema::table('cotizaciones', function (Blueprint $table) {
            // Cambiar el campo valor a un formato de 12,2
            $table->decimal('valor', 12, 2)->change();
        });

        // Modificar la tabla solicitudes_cotizaciones
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            // Cambiar el campo precio a un formato de 12,2
            $table->decimal('precio', 12, 2)->change();
            // Cambiar el campo descuento a un formato de 5,2
            $table->decimal('descuento', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios en la tabla cotizaciones
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->decimal('valor', 8, 2)->change();
        });

        // Revertir cambios en la tabla solicitudes_cotizaciones
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->decimal('precio', 10, 2)->change();
            $table->decimal('descuento', 8, 2)->nullable()->change();
        });
    }
};
