<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Entidad 1 de 5: autores (id + 5 atributos de negocio).
     *
     * Consigna: "un máximo de 5 entidades y cada entidad con 5 atributos".
     * El `id` es adicional, por eso la tabla queda con id + 5 columnas.
     */
    public function up(): void
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 120);
            $table->string('nacionalidad', 60);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('correo', 160)->nullable()->unique();
            $table->boolean('activo')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autores');
    }
};
