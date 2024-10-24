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
        Schema::table('cotizaciones', function (Blueprint $table) {
            // Agregar la columna id_users como clave foránea
            $table->unsignedBigInteger('id_users')->nullable()->after('id');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('ordenes_compras', function (Blueprint $table) {
            // Agregar la columna id_users como clave foránea
            $table->unsignedBigInteger('id_users')->nullable()->after('id');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna id_users
            $table->dropForeign(['id_users']);
            $table->dropColumn('id_users');
        });

        Schema::table('ordenes_compras', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna id_users
            $table->dropForeign(['id_users']);
            $table->dropColumn('id_users');
        });
    }
};
