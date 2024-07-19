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
        Schema::create('descargues_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('descargue');
            $table->unsignedBigInteger('producto');
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('descargue')->references('id')->on('descargues')->onDelete('cascade');
            $table->foreign('producto')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descargue_productos');
    }
};
