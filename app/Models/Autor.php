<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Autor — entidad 1 de 5. Relación 1:N con libros.
 */
class Autor extends Model
{
    public $timestamps = false;

    /** @use HasFactory<\Database\Factories\AutorFactory> */
    use HasFactory;

    /** Eloquent inferiría "autors": el plural en español se fija a mano. */
    protected $table = 'autores';

    /** Los 5 atributos de negocio (el id es adicional). */
    protected $fillable = [
        'nombres',
        'nacionalidad',
        'fecha_nacimiento',
        'correo',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'activo' => 'boolean',
        ];
    }

    /** Un autor escribe muchos libros. */
    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class);
    }
}
