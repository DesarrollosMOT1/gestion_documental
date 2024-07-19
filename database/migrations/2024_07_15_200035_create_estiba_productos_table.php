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
        Schema::create('estiba_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estiba');
            $table->unsignedBigInteger('descargue');
            $table->integer('cantidad_producto');
            $table->timestamps();

            $table->foreign('descargue')->references('id')->on('descargues_productos')->onDelete('cascade');
            $table->foreign('estiba')->references('id')->on('estibas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estiba_productos');
    }
};
