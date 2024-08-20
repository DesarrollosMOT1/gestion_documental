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
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
                $table->unsignedBigInteger('id_solicitud_elemento')->after('id_impuestos')->nullable();
                $table->decimal('precio', 10, 2)->after('estado');
                $table->string('estado')->nullable()->change();
                $table->foreign('id_solicitud_elemento')->references('id')->on('solicitudes_elementos')->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->dropColumn('precio');
            $table->string('estado')->nullable(false)->change();
            $table->dropForeign(['id_solicitud_elemento']);
            $table->dropColumn('id_solicitud_elemento');
        });
    }
};
