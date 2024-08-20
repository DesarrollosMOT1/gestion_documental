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
        Schema::create('solicitudes_compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_solicitud');
            $table->unsignedBigInteger('id_users');
            $table->string('prefijo');
            $table->text('descripcion');
            $table->string('estado_solicitud')->nullable(); 
            $table->date('fecha_estado')->nullable(); 
            $table->timestamps();
            $table->foreign('id_users')->references('id')->on('users');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_compras');
    }
};
