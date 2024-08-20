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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_area')->nullable();

            // Añadiendo la clave foránea, estableciendo que si se llega a eliminar el area quede NULL
            $table->foreign('id_area')->references('id')->on('areas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar la clave foránea primero
            $table->dropForeign(['id_area']);

            // Luego eliminar la columna
            $table->dropColumn('id_area');
        });
    }
};
