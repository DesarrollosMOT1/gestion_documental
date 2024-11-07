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
        Schema::table('consolidaciones_ofertas', function (Blueprint $table) {
            $table->string('descripcion')->after('id_solicitudes_ofertas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consolidaciones_ofertas', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });
    }
};
