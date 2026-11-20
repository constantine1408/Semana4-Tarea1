<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Genero;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Socio;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Autores reales: nombres, nacionalidad y fecha de nacimiento. */
    private const AUTORES = [
        'icaza' => ['Jorge Icaza', 'Ecuatoriana', '1906-07-10'],
        'mera' => ['Juan León Mera', 'Ecuatoriana', '1832-06-28'],
        'garcia' => ['Gabriel García Márquez', 'Colombiana', '1927-03-06'],
        'rulfo' => ['Juan Rulfo', 'Mexicana', '1917-05-16'],
        'cortazar' => ['Julio Cortázar', 'Argentina', '1914-08-26'],
    ];

    /** Géneros: nombre, código, descripción y edad mínima. */
    private const GENEROS = [
        'nov' => ['Novela', 'NOV', 'Narraciones extensas de ficción.', 14],
        'cue' => ['Cuento', 'CUE', 'Relatos breves y colecciones de cuentos.', 12],
        'rea' => ['Realismo mágico', 'REA', 'Ficción donde lo extraordinario se cuenta como cotidiano.', 15],
        'rom' => ['Romanticismo', 'ROM', 'Novela romántica del siglo XIX.', 12],
    ];

    /**
     * Libros reales con su autor y su género. Los ISBN son de ejemplo
     * (13 dígitos válidos para el sistema, no de una edición concreta).
     */
    private const LIBROS = [
        ['Huasipungo', 'icaza', 'nov', 224],
        ['En las calles', 'icaza', 'nov', 196],
        ['Cumandá', 'mera', 'rom', 268],
        ['Cien años de soledad', 'garcia', 'rea', 471],
        ['Crónica de una muerte anunciada', 'garcia', 'nov', 122],
        ['El coronel no tiene quien le escriba', 'garcia', 'nov', 104],
        ['Pedro Páramo', 'rulfo', 'rea', 124],
        ['El llano en llamas', 'rulfo', 'cue', 170],
        ['Rayuela', 'cortazar', 'nov', 600],
        ['Bestiario', 'cortazar', 'cue', 160],
    ];

    /**
     * Siembra idempotente: cada bloque solo crea registros si la tabla
     * está vacía, así `db:seed` puede ejecutarse varias veces sin duplicar.
     */
    public function run(): void
    {
        if (! Autor::query()->exists()) {
            foreach (self::AUTORES as [$nombres, $nacionalidad, $nacimiento]) {
                Autor::create([
                    'nombres' => $nombres,
                    'nacionalidad' => $nacionalidad,
                    'fecha_nacimiento' => $nacimiento,
                    'correo' => null,
                    'activo' => true,
                ]);
            }
        }

        if (! Genero::query()->exists()) {
            foreach (self::GENEROS as [$nombre, $codigo, $descripcion, $edad]) {
                Genero::create([
                    'nombre' => $nombre,
                    'codigo' => $codigo,
                    'descripcion' => $descripcion,
                    'edad_minima' => $edad,
                    'activo' => true,
                ]);
            }
        }

        if (! Socio::query()->exists()) {
            Socio::factory()->count(6)->create();
        }

        if (! Libro::query()->exists()) {
            foreach (self::LIBROS as $i => [$titulo, $autor, $genero, $paginas]) {
                Libro::create([
                    'titulo' => $titulo,
                    'isbn' => '97899786' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                    'paginas' => $paginas,
                    'autor_id' => Autor::where('nombres', self::AUTORES[$autor][0])->value('id'),
                    'genero_id' => Genero::where('codigo', self::GENEROS[$genero][1])->value('id'),
                ]);
            }
        }

        if (! Prestamo::query()->exists()) {
            // Préstamos al azar (vigentes y devueltos)...
            Prestamo::factory()
                ->count(7)
                ->state(fn () => [
                    'socio_id' => Socio::query()->inRandomOrder()->value('id'),
                    'libro_id' => Libro::query()->inRandomOrder()->value('id'),
                ])
                ->create();

            // ...y uno vencido, para que el estado rojo siempre se vea.
            Prestamo::create([
                'fecha_prestamo' => now()->subDays(22)->format('Y-m-d'),
                'fecha_limite' => now()->subDays(7)->format('Y-m-d'),
                'estado' => 'vencido',
                'socio_id' => Socio::query()->inRandomOrder()->value('id'),
                'libro_id' => Libro::query()->inRandomOrder()->value('id'),
            ]);
        }
    }
}
