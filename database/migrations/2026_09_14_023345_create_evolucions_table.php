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
        Schema::create('evolucion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('peso',10,2);
            $table->decimal('temperatura',10,2);
            $table->text('sintomas');
            $table->text('observaciones');
            $table->unsignedBigInteger('idHistoriaClinica');
            $table->unsignedBigInteger('idVeterinario');
            $table->foreign('idHistoriaClinica')->references('id')->on('historiaClinica');
            $table->foreign('idVeterinario')->references('id')->on('veterinario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evolucion');
    }
};
