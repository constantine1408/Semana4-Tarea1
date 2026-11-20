<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Prestamo — entidad 5 de 5. Une a un socio con un libro: es la entidad
 * que deja a las cinco relacionadas en un solo grafo.
 */
class Prestamo extends Model
{
    public $timestamps = false;

    /** @use HasFactory<\Database\Factories\PrestamoFactory> */
    use HasFactory;

    /** Los 5 atributos de negocio (el id es adicional). */
    protected $fillable = [
        'fecha_prestamo',
        'fecha_limite',
        'estado',
        'socio_id',
        'libro_id',
    ];

    /** Estados posibles (se validan también en los Form Requests). */
    public const ESTADOS = ['prestado', 'devuelto', 'vencido'];

    protected function casts(): array
    {
        return [
            'fecha_prestamo' => 'date',
            'fecha_limite' => 'date',
            'socio_id' => 'integer',
            'libro_id' => 'integer',
        ];
    }

    /** Días que faltan para la fecha límite (negativo si ya pasó). */
    public function diasRestantes(): int
    {
        return (int) now()->startOfDay()->diffInDays($this->fecha_limite->copy()->startOfDay(), false);
    }

    /**
     * Situación que ve el bibliotecario, derivada del estado guardado y de
     * la fecha límite: un préstamo "prestado" cuya fecha ya pasó se muestra
     * como vencido aunque nadie haya cambiado su estado.
     *
     * @return array{clave: string, etiqueta: string}
     */
    public function situacion(): array
    {
        if ($this->estado === 'devuelto') {
            return ['clave' => 'devuelto', 'etiqueta' => 'Devuelto'];
        }

        $dias = $this->diasRestantes();

        if ($this->estado === 'vencido' || $dias < 0) {
            return ['clave' => 'vencido', 'etiqueta' => 'Vencido'];
        }

        if ($dias <= 3) {
            return ['clave' => 'pronto', 'etiqueta' => $dias === 0 ? 'Vence hoy' : 'Vence pronto'];
        }

        return ['clave' => 'prestado', 'etiqueta' => 'Prestado'];
    }

    /** Un préstamo pertenece a un socio. */
    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    /** Un préstamo corresponde a un libro. */
    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }
}
