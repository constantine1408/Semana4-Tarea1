<?php

namespace Database\Factories;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Socio>
 */
class SocioFactory extends Factory
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
            'cedula' => fake()->unique()->numerify('18########'),
            'correo' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('09########'),
            'fecha_afiliacion' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
        ];
    }
}
