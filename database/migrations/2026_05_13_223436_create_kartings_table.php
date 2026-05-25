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
        Schema::create('kartings', function (Blueprint $table) {
            $table->id();
            // Nombre del circuito (ej: KR24 Sanlúcar)
            $table->string('name');
            // Coordenadas con precisión para el mapa
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            // Ciudad o localidad (opcional)
            $table->string('city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartings');
    }
};