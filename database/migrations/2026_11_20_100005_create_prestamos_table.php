<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Entidad 5 de 5: prestamos (id + 5 atributos de negocio).
     *
     * Entidad de unión entre socios y libros: sus dos últimas columnas
     * son las claves foráneas. `estado` ∈ prestado | devuelto | vencido.
     */
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_prestamo');
            $table->date('fecha_limite');
            $table->string('estado', 20)->default('prestado');
            $table->foreignId('socio_id')->constrained('socios')->restrictOnDelete();
            $table->foreignId('libro_id')->constrained('libros')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
