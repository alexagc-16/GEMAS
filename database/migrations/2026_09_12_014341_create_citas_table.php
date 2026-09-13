<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cita', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('motivo');
            $table->enum('estado', ['Pendiente', 'Confirmada', 'Atendida', 'Cancelada']);
            $table->unsignedBigInteger('idMascota');
            $table->unsignedBigInteger('idVeterinario');
            $table->unsignedBigInteger('idServicio');
            $table->foreign('idMascota')->references('id')->on('mascota');
            $table->foreign('idVeterinario')->references('id')->on('veterinario');
            $table->foreign('idServicio')->references('id')->on('servicio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita');
    }
};
