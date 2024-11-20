<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cotizaciones_precio', function (Blueprint $table) {
            $table->string('justificacion_jefe')->nullable()->after('estado_jefe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cotizaciones_precio', function (Blueprint $table) {
            $table->dropColumn('justificacion_jefe');
        });
    }
};
