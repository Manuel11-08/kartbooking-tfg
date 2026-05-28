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
    Schema::create('meetups', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
        $table->string('title');
        $table->string('karting_name');
        $table->string('place_id')->nullable(); // Para enlazar a la ficha técnica
        $table->dateTime('meet_date');
        $table->integer('max_participants')->default(10);
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetups');
    }
};
