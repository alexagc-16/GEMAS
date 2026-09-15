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
        Schema::create('diagnosticoTratamiento', function (Blueprint $table) {
            $table->id();
            $table->text('diagnostico');
            $table->text('tratamiento');
            $table->text('medicamento');
            $table->string('dosis');
            $table->string('frecuencia');
            $table->string('duracion');
            $table->text('procedimiento');
            $table->text('examenOrdenado');
            $table->text('indicaciones');
            $table->date('fecha');
            $table->unsignedBigInteger('idEvolucion');
            $table->foreign('idEvolucion')->references('id')->on('evolucion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticoTratamiento');
    }
};
