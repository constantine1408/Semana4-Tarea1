<?php

namespace Database\Factories;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Autor>
 */
class AutorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombres' => fake()->unique()->firstName() . ' ' . fake()->lastName() . ' ' . fake()->lastName(),
            'nacionalidad' => fake()->randomElement(['Ecuatoriana', 'Colombiana', 'Peruana', 'Mexicana', 'Argentina', 'Chilena']),
            'fecha_nacimiento' => fake()->dateTimeBetween('-90 years', '-25 years')->format('Y-m-d'),
            'correo' => fake()->unique()->safeEmail(),
            'activo' => true,
        ];
    }
}
