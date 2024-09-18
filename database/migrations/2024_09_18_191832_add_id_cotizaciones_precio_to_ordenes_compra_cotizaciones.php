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
        Schema::table('cotizaciones_precio', function (Blueprint $table) {
            $table->unsignedBigInteger('id_consolidaciones')->nullable();
            $table->foreign('id_consolidaciones')->references('id')->on('consolidaciones')->onDelete('set null');
            $table->string('estado_jefe')->nullable();
        });
        
        Schema::table('ordenes_compra_cotizaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cotizaciones_precio')->nullable();
            $table->foreign('id_cotizaciones_precio')->references('id')->on('cotizaciones_precio')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones_precio', function (Blueprint $table) {
            $table->dropForeign(['id_consolidaciones']);
            $table->dropColumn('id_consolidaciones');
            $table->dropColumn('estado_jefe');
        });

        Schema::table('ordenes_compra_cotizaciones', function (Blueprint $table) {
            $table->dropForeign(['id_cotizaciones_precio']);
            $table->dropColumn('id_cotizaciones_precio');
        });
    }
};
