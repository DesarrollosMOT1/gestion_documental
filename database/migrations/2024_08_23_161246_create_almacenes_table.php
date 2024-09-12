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
        Schema::create('Almacenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bodega');
            $table->string('nombre',255);
            $table->timestamps();

            $table->foreign('bodega')->references('id')->on('bodegas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Almacenes');
    }
};
