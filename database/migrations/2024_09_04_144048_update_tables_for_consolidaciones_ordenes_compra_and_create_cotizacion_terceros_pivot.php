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
        // Eliminar el campo 'estado' de la tabla 'consolidaciones_ofertas'
        Schema::table('consolidaciones_ofertas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        // Eliminar el campo 'estado' de la tabla 'consolidaciones'
        Schema::table('consolidaciones', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        // Agregar campos a la tabla 'ordenes_compra_cotizaciones'
        Schema::table('ordenes_compra_cotizaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_consolidaciones_oferta')->nullable();
            $table->unsignedBigInteger('id_solicitud_elemento')->nullable();

            // Llaves foráneas
            $table->foreign('id_consolidaciones_oferta')->references('id')->on('consolidaciones_ofertas')->onDelete('cascade');
            $table->foreign('id_solicitud_elemento')->references('id')->on('solicitudes_elementos')->onDelete('cascade');
        });

        // Eliminar el campo 'id_terceros' de la tabla 'cotizaciones'
        Schema::table('solicitudes_ofertas', function (Blueprint $table) {
            // Eliminar la llave foránea y el campo 'id_terceros'
            $table->dropForeign(['id_terceros']);
            $table->dropColumn('id_terceros');
        });

        // Crear tabla intermedia entre 'terceros' y 'solicitudes_ofertas'
        Schema::create('solicitud_oferta_tercero', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitudes_ofertas_id');
            $table->unsignedBigInteger('tercero_id');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('solicitudes_ofertas_id')->references('id')->on('solicitudes_ofertas')->onDelete('cascade');
            $table->foreign('tercero_id')->references('id')->on('terceros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar el campo 'estado' en la tabla 'consolidaciones_ofertas'
        Schema::table('consolidaciones_ofertas', function (Blueprint $table) {
            $table->string('estado')->default('pendiente');
        });

        // Restaurar el campo 'estado' en la tabla 'consolidaciones'
        Schema::table('consolidaciones', function (Blueprint $table) {
            $table->integer('estado')->default(0); // 0 o 1 para el checkbox
        });

        // Eliminar los campos añadidos a la tabla 'ordenes_compra_cotizaciones'
        Schema::table('ordenes_compra_cotizaciones', function (Blueprint $table) {
            $table->dropForeign(['id_consolidaciones_oferta']);
            $table->dropForeign(['id_solicitud_elemento']);
            $table->dropColumn(['id_consolidaciones_oferta', 'id_solicitud_elemento']);
        });

        // Restaurar el campo 'id_terceros' en la tabla 'cotizaciones'
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_terceros');
            $table->foreign('id_terceros')->references('id')->on('terceros');
        });

        // Eliminar la tabla intermedia 'cotizacion_tercero'
        Schema::dropIfExists('solicitud_oferta_tercero');
    }

};
