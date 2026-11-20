<?php

namespace Database\Factories;

use App\Models\Genero;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Genero>
 */
class GeneroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Las tres primeras letras de cada nombre son distintas entre sí,
        // así el código (NOV, POE, CUE...) también es único.
        $generos = [
            'Novela' => 'Narraciones extensas de ficción.',
            'Poesía' => 'Obras en verso y antologías poéticas.',
            'Cuento' => 'Relatos breves y colecciones de cuentos.',
            'Ensayo' => 'Textos de reflexión y análisis.',
            'Teatro' => 'Obras dramáticas para representar.',
            'Biografía' => 'Vidas de personas reales.',
            'Historia' => 'Estudios y crónicas del pasado.',
            'Ciencia ficción' => 'Ficción basada en ciencia y futuros posibles.',
            'Fantasía' => 'Mundos imaginarios y elementos mágicos.',
            'Misterio' => 'Intriga, crímenes e investigaciones.',
            'Infantil' => 'Lecturas para niñas y niños.',
            'Crónica' => 'Relatos periodísticos de hechos reales.',
        ];
        $nombre = fake()->unique()->randomElement(array_keys($generos));

        return [
            'nombre' => $nombre,
            'codigo' => strtoupper(substr(\Illuminate\Support\Str::ascii($nombre), 0, 3)),
            'descripcion' => $generos[$nombre],
            'edad_minima' => match ($nombre) {
                'Infantil' => 0,
                'Misterio', 'Ciencia ficción', 'Crónica' => 14,
                default => 12,
            },
            'activo' => true,
        ];
    }
}
