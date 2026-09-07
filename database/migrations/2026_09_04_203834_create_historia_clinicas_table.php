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
        Schema::create('historiaClinica', function (Blueprint $table) {
            $table->id();
            $table->date('fechaApertura');
            $table->string('antecedentes');
            $table->string('alergias');
            $table->string('enfermedadesPrevias');
            $table->string('observaciones');
            $table->unsignedBigInteger('idMascota');
            $table->foreign('idMascota')->references('id')->on('mascota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiaClinica');
    }
};
