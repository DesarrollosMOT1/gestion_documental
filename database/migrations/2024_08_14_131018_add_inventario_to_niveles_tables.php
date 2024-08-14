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
        Schema::table('niveles_uno', function (Blueprint $table) {
            $table->boolean('inventario')->default(false);
        });

        Schema::table('niveles_dos', function (Blueprint $table) {
            $table->boolean('inventario')->default(false);
        });

        Schema::table('niveles_tres', function (Blueprint $table) {
            $table->boolean('inventario')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('niveles_uno', function (Blueprint $table) {
            $table->dropColumn('inventario');
        });

        Schema::table('niveles_dos', function (Blueprint $table) {
            $table->dropColumn('inventario');
        });

        Schema::table('niveles_tres', function (Blueprint $table) {
            $table->dropColumn('inventario');
        });
    }
};
