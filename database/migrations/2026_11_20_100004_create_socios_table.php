<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Entidad 4 de 5: socios de la biblioteca (id + 5 atributos).
     */
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 120);
            $table->char('cedula', 10)->unique();
            $table->string('correo', 160)->unique();
            $table->string('telefono', 15);
            $table->date('fecha_afiliacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
