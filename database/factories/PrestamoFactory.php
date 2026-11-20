<?php

namespace Database\Factories;

use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Prestamo>
 */
class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Los devueltos son de hace meses; los vigentes, de las últimas
        // semanas, para que haya préstamos al día, por vencer y vencidos.
        $devuelto = fake()->boolean(40);
        $prestamo = $devuelto
            ? fake()->dateTimeBetween('-6 months', '-1 month')
            : fake()->dateTimeBetween('-20 days', 'now');
        $limite = (clone $prestamo)->modify('+15 days');

        return [
            'fecha_prestamo' => $prestamo->format('Y-m-d'),
            'fecha_limite' => $limite->format('Y-m-d'),
            'estado' => $devuelto ? 'devuelto' : ($limite < new \DateTime('today') ? 'vencido' : 'prestado'),
            'socio_id' => Socio::factory(),
            'libro_id' => Libro::factory(),
        ];
    }
}
