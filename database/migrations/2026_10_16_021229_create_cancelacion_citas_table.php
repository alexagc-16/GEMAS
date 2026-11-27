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
        Schema::create('cancelacionCita', function (Blueprint $table) {
            $table->id();
            $table->enum('tipoCancelador', ['Usuario', 'Veterinario', 'Administrador']);
            $table->string('motivo');
            $table->timestamp('fechaCancelacion');
            $table->unsignedBigInteger('idCita');
            $table->foreign('idCita')->references('id')->on('cita');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelacionCita');
    }
};
