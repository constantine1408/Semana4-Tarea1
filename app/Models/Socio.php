<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Socio — entidad 4 de 5. Relación 1:N con prestamos.
 */
class Socio extends Model
{
    public $timestamps = false;

    /** @use HasFactory<\Database\Factories\SocioFactory> */
    use HasFactory;

    protected $table = 'socios';

    /** Los 5 atributos de negocio (el id es adicional). */
    protected $fillable = [
        'nombres',
        'cedula',
        'correo',
        'telefono',
        'fecha_afiliacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_afiliacion' => 'date',
        ];
    }

    /** Un socio tiene muchos préstamos. */
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
