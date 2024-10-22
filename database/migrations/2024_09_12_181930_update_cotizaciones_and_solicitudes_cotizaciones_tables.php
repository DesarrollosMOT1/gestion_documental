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

        // Crear la tabla intermedia
        Schema::create('cotizaciones_precio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_solicitudes_cotizaciones');
            $table->unsignedBigInteger('id_agrupaciones_consolidaciones');
            $table->foreign('id_solicitudes_cotizaciones')->references('id')->on('solicitudes_cotizaciones')->onDelete('cascade');
            $table->foreign('id_agrupaciones_consolidaciones')->references('id')->on('agrupaciones_consolidaciones')->onDelete('cascade');

            $table->string('descripcion')->nullable();
            $table->string('estado'); 

            $table->timestamps();
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
            $table->string('estado')->after('cantidad');
        });

        // Eliminar la tabla intermedia
        Schema::dropIfExists('cotizaciones_precio');
    }
};
