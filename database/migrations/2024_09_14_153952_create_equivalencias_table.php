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
        Schema::create('equivalencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidad_principal');
            $table->unsignedBigInteger('unidad_equivalente');
            $table->integer('cantidad');

            $table->foreign('unidad_principal')
                ->references('id')->on('unidades')
                ->onDelete('cascade');

            $table->foreign('unidad_equivalente')
                ->references('id')->on('unidades')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equivalencias');
    }
};
