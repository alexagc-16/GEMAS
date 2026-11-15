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
            $table->text('antecedentes')->nullable();
            $table->text('alergias')->nullable();
            $table->text('enfermedadesPrevias')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('idMascota')->unique();;
            $table->foreign('idMascota')->references('id')->on('mascota');
            $table->timestamp('completadaEn')->nullable();
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
