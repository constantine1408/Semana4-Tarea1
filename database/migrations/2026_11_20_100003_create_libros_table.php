<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Entidad 3 de 5: libros (id + 5 atributos de negocio).
     *
     * Dos de sus atributos son claves foráneas: relacionan el libro con
     * su autor y su género. `restrictOnDelete()` impide borrar un autor o
     * un género que todavía tenga libros (integridad referencial en MySQL).
     */
    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 200);
            $table->char('isbn', 13)->unique();
            $table->unsignedSmallInteger('paginas');
            $table->foreignId('autor_id')->constrained('autores')->restrictOnDelete();
            $table->foreignId('genero_id')->constrained('generos')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
