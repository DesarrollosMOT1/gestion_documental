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
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_consolidacion')->nullable()->after('id');
            
            // Llave foránea
            $table->foreign('id_consolidacion')->references('id')->on('consolidaciones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes_cotizaciones', function (Blueprint $table) {
            $table->dropForeign(['id_consolidacion']);
            $table->dropColumn('id_consolidacion');
        });
    }
};
