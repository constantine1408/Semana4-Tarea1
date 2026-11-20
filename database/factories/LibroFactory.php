<?php

namespace Database\Factories;

use App\Models\Autor;
use App\Models\Genero;
use App\Models\Libro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Libro>
 */
class LibroFactory extends Factory
{
    /** Títulos reales para que los datos de ejemplo sean legibles. */
    private const TITULOS = [
        'Huasipungo', 'Cien años de soledad', 'La vorágine', 'Pedro Páramo',
        'Rayuela', 'Ficciones', 'La ciudad y los perros', 'El túnel',
        'Cumandá', 'A la Costa', 'Los de abajo', 'Don Segundo Sombra',
        'María', 'Los ríos profundos', 'El llano en llamas', 'Aura',
        'Doña Bárbara', 'Nada', 'La tregua', 'Crónica de una muerte anunciada',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->unique()->randomElement(self::TITULOS),
            'isbn' => fake()->unique()->numerify('978##########'),
            'paginas' => fake()->numberBetween(60, 900),
            'autor_id' => Autor::factory(),
            'genero_id' => Genero::factory(),
        ];
    }
}
