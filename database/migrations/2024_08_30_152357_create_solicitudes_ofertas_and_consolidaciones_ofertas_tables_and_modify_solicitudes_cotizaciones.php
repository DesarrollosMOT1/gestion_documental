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
        // Crear tabla solicitudes_ofertas
        Schema::create('solicitudes_ofertas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_solicitud_oferta');
            $table->unsignedBigInteger('id_users');
            $table->string('id_terceros');
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users');
            $table->foreign('id_terceros')->references('nit')->on('terceros');
        });

        // Crear tabla consolidaciones_ofertas
        Schema::create('consolidaciones_ofertas', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->string('estado');
            $table->unsignedBigInteger('id_solicitudes_compras');
            $table->unsignedBigInteger('id_solicitud_elemento');
            $table->unsignedBigInteger('id_consolidaciones');
            $table->timestamps();

            $table->foreign('id_solicitudes_compras')->references('id')->on('solicitudes_compras');
            $table->foreign('id_solicitud_elemento')->references('id')->on('solicitudes_elementos');
            $table->foreign('id_consolidaciones')->references('id')->on('consolidaciones');
        });

        // Modificar tabla solicitudes_cotizaciones
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_consolidaciones_oferta')->nullable();

            $table->foreign('id_consolidaciones_oferta')->references('id')->on('consolidaciones_ofertas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar relaciones y columnas de la tabla solicitudes_cotizaciones
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->dropForeign(['id_consolidaciones_oferta']);
            $table->dropColumn('id_consolidaciones_oferta');
        });

        // Eliminar tablas consolidaciones_ofertas y solicitudes_ofertas
        Schema::dropIfExists('consolidaciones_ofertas');
        Schema::dropIfExists('solicitudes_ofertas');
    }
};
