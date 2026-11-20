<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Genero — entidad 2 de 5. Relación 1:N con libros.
 */
class Genero extends Model
{
    public $timestamps = false;

    /** @use HasFactory<\Database\Factories\GeneroFactory> */
    use HasFactory;

    protected $table = 'generos';

    /** Los 5 atributos de negocio (el id es adicional). */
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'edad_minima',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'edad_minima' => 'integer',
            'activo' => 'boolean',
        ];
    }

    /**
     * Telas de encuadernación: [fondo, texto del lomo]. El color de cada
     * género se deriva de su id para no agregar una sexta columna.
     */
    public const TELAS = [
        ['#7a1f2b', '#f1d98a'], // vino
        ['#1f3a5f', '#f1d98a'], // azul marino
        ['#b8862b', '#2b1d05'], // mostaza
        ['#175c5c', '#f1d98a'], // petróleo
        ['#5a2d5e', '#f1d98a'], // ciruela
        ['#9a4a1f', '#fbe7c0'], // óxido
        ['#3d5a2a', '#f1d98a'], // musgo
        ['#2f2f3a', '#f1d98a'], // grafito
    ];

    /** @return array{0: string, 1: string} color de tela y de rotulado */
    public function tela(): array
    {
        return self::TELAS[((int) $this->id - 1) % count(self::TELAS)];
    }

    /** Un género agrupa muchos libros. */
    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class);
    }
}
