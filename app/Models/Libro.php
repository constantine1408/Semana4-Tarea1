<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Libro — entidad 3 de 5. Centro del modelo: N:1 con autores y
 * generos, 1:N con prestamos.
 */
class Libro extends Model
{
    public $timestamps = false;

    /** @use HasFactory<\Database\Factories\LibroFactory> */
    use HasFactory;

    /** Los 5 atributos de negocio (el id es adicional). */
    protected $fillable = [
        'titulo',
        'isbn',
        'paginas',
        'autor_id',
        'genero_id',
    ];

    protected function casts(): array
    {
        return [
            'paginas' => 'integer',
            'autor_id' => 'integer',
            'genero_id' => 'integer',
        ];
    }

    /** Un libro pertenece a un autor. */
    public function autor(): BelongsTo
    {
        return $this->belongsTo(Autor::class);
    }

    /** Un libro pertenece a un género. */
    public function genero(): BelongsTo
    {
        return $this->belongsTo(Genero::class);
    }

    /** Un libro puede prestarse muchas veces. */
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
