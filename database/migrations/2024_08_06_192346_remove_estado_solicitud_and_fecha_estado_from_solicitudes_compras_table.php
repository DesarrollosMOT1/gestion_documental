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
        Schema::table('solicitudes_compras', function (Blueprint $table) {
            Schema::table('solicitudes_compras', function (Blueprint $table) {
                $table->dropColumn('estado_solicitud');
                $table->dropColumn('fecha_estado');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes_compras', function (Blueprint $table) {
            $table->string('estado_solicitud')->nullable();
            $table->date('fecha_estado')->nullable();
        });
    }
};
