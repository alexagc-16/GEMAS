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
        Schema::create('mascotaAdopcion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->enum('sexo', ['Macho', 'Hembra']);
            $table->date('fechaNacimiento')->nullable();
            $table->string('color')->nullable();
            $table->decimal('peso', 10, 2)->nullable();
            $table->text('descripcion');
            $table->string('imagen');
            $table->enum('estado', ['En adopción','Adoptada','No disponible'])->default('En adopción');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotaAdopcion');
    }
};
