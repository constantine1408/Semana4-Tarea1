<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Entidad 2 de 5: generos (id + 5 atributos de negocio).
     *
     * `codigo` es una sigla de 3 letras (NOV, POE, HIS...) y
     * `edad_minima` la edad recomendada para el género (0 a 18).
     */
    public function up(): void
    {
        Schema::create('generos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
            $table->char('codigo', 3)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->unsignedTinyInteger('edad_minima')->default(0);
            $table->boolean('activo')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generos');
    }
};
