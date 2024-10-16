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
        Schema::create('niveles_tres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->unsignedBigInteger('id_niveles_dos');
            $table->unsignedBigInteger('id_referencias_gastos');
            $table->timestamps();

            $table->foreign('id_niveles_dos')->references('id')->on('niveles_dos');
            $table->foreign('id_referencias_gastos')->references('id')->on('referencias_gastos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveles_tres');
    }
};
