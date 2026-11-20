<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Genero;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * CRUD HTTP de las 5 entidades: listar, crear, ver, editar y eliminar,
 * con validación de datos y rechazo de borrados con dependencias.
 */
class CrudHttpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Definición por entidad: ruta, modelo, payload válido y payload inválido.
     *
     * @return array<string, array{0: string, 1: class-string, 2: array<string, mixed>, 3: array<string, mixed>}>
     */
    private function entidades(): array
    {
        $autor = Autor::factory()->create();
        $genero = Genero::factory()->create();
        $socio = Socio::factory()->create();
        $libro = Libro::factory()->create();

        return [
            'autores' => [
                'autores',
                Autor::class,
                ['nombres' => 'Jorge Icaza', 'nacionalidad' => 'Ecuatoriana', 'fecha_nacimiento' => '1906-07-10', 'correo' => 'icaza@correo.com', 'activo' => 1],
                ['nombres' => '', 'nacionalidad' => '', 'correo' => 'no-es-correo'],
            ],
            'generos' => [
                'generos',
                Genero::class,
                ['nombre' => 'Realismo social', 'codigo' => 'rso', 'descripcion' => 'Novela de denuncia', 'edad_minima' => 14, 'activo' => 1],
                ['nombre' => '', 'codigo' => 'ABCD', 'edad_minima' => 30],
            ],
            'libros' => [
                'libros',
                Libro::class,
                ['titulo' => 'Huasipungo', 'isbn' => '9789978670014', 'paginas' => 224, 'autor_id' => $autor->id, 'genero_id' => $genero->id],
                ['titulo' => '', 'isbn' => '123', 'paginas' => 0],
            ],
            'socios' => [
                'socios',
                Socio::class,
                ['nombres' => 'Ana Pérez', 'cedula' => '1712345678', 'correo' => 'ana@correo.com', 'telefono' => '0981234567', 'fecha_afiliacion' => '2026-01-15'],
                ['nombres' => '', 'cedula' => '123', 'correo' => 'no-es-correo'],
            ],
            'prestamos' => [
                'prestamos',
                Prestamo::class,
                ['fecha_prestamo' => '2026-11-01', 'fecha_limite' => '2026-11-16', 'estado' => 'prestado', 'socio_id' => $socio->id, 'libro_id' => $libro->id],
                ['fecha_prestamo' => '2026-11-10', 'fecha_limite' => '2026-11-01', 'estado' => 'inventado'],
            ],
        ];
    }

    public function test_la_portada_responde_200(): void
    {
        $this->get('/')->assertOk()->assertSee('Autores')->assertSee('Socios');
    }

    public function test_listado_y_formulario_de_cada_entidad_responden_200(): void
    {
        Prestamo::factory()->create();

        foreach (array_keys($this->entidades()) as $ruta) {
            $this->get("/{$ruta}")->assertOk();
            $this->get("/{$ruta}/create")->assertOk();
        }
    }

    public function test_store_crea_el_registro_con_datos_validos(): void
    {
        foreach ($this->entidades() as [$ruta, $modelo, $valido]) {
            $antes = $modelo::count();

            $this->post("/{$ruta}", $valido)
                ->assertRedirect("/{$ruta}")
                ->assertSessionHasNoErrors();

            $this->assertSame($antes + 1, $modelo::count(), "`{$ruta}` debe crear un registro.");
        }

        // El código del género se normaliza a mayúsculas.
        $this->assertDatabaseHas('generos', ['codigo' => 'RSO']);
    }

    public function test_store_rechaza_datos_invalidos_y_no_crea_el_registro(): void
    {
        foreach ($this->entidades() as [$ruta, $modelo, , $invalido]) {
            $antes = $modelo::count();

            $this->from("/{$ruta}/create")
                ->post("/{$ruta}", $invalido)
                ->assertRedirect("/{$ruta}/create")
                ->assertSessionHasErrors();

            $this->assertSame($antes, $modelo::count(), "`{$ruta}` no debe crear registros inválidos.");
        }
    }

    public function test_prestamo_rechaza_fecha_limite_anterior_al_prestamo(): void
    {
        $prestamo = Prestamo::factory()->make()->toArray();
        $prestamo['fecha_prestamo'] = '2026-11-10';
        $prestamo['fecha_limite'] = '2026-11-01';

        $this->post('/prestamos', $prestamo)->assertSessionHasErrors('fecha_limite');
    }

    public function test_show_de_cada_entidad_muestra_sus_relaciones(): void
    {
        $prestamo = Prestamo::factory()->create();
        $libro = $prestamo->libro;

        $this->get("/autores/{$libro->autor_id}")->assertOk()->assertSee($libro->titulo);
        $this->get("/generos/{$libro->genero_id}")->assertOk()->assertSee($libro->titulo);
        $this->get("/libros/{$libro->id}")->assertOk()->assertSee($prestamo->socio->nombres);
        $this->get("/socios/{$prestamo->socio_id}")->assertOk()->assertSee($libro->titulo);
        $this->get("/prestamos/{$prestamo->id}")->assertOk()->assertSee($libro->titulo);
    }

    public function test_edit_muestra_el_formulario_con_los_datos(): void
    {
        $prestamo = Prestamo::factory()->create(['fecha_limite' => '2026-12-24']);
        $libro = $prestamo->libro;

        $this->get("/autores/{$libro->autor_id}/edit")->assertOk()->assertSee($libro->autor->nombres);
        $this->get("/generos/{$libro->genero_id}/edit")->assertOk()->assertSee($libro->genero->codigo);
        $this->get("/libros/{$libro->id}/edit")->assertOk()->assertSee($libro->isbn);
        $this->get("/socios/{$prestamo->socio_id}/edit")->assertOk()->assertSee($prestamo->socio->cedula);
        $this->get("/prestamos/{$prestamo->id}/edit")->assertOk()->assertSee('2026-12-24');
    }

    public function test_update_modifica_el_registro(): void
    {
        $libro = Libro::factory()->create(['titulo' => 'Título original']);

        $this->put("/libros/{$libro->id}", [
            'titulo' => 'Título actualizado',
            'isbn' => $libro->isbn,
            'paginas' => 321,
            'autor_id' => $libro->autor_id,
            'genero_id' => $libro->genero_id,
        ])->assertRedirect("/libros/{$libro->id}");

        $this->assertDatabaseHas('libros', ['id' => $libro->id, 'titulo' => 'Título actualizado', 'paginas' => 321]);
    }

    public function test_update_rechaza_datos_invalidos(): void
    {
        $socio = Socio::factory()->create();

        $this->from("/socios/{$socio->id}/edit")
            ->put("/socios/{$socio->id}", [
                'nombres' => '',
                'cedula' => 'abc',
                'correo' => 'no-es-correo',
                'telefono' => $socio->telefono,
                'fecha_afiliacion' => $socio->fecha_afiliacion->format('Y-m-d'),
            ])
            ->assertRedirect("/socios/{$socio->id}/edit")
            ->assertSessionHasErrors(['nombres', 'cedula', 'correo']);

        $this->assertDatabaseMissing('socios', ['cedula' => 'abc']);
    }

    public function test_casilla_activo_incluye_valor_oculto(): void
    {
        $autor = Autor::factory()->create();
        $genero = Genero::factory()->create();

        $this->get("/autores/{$autor->id}/edit")
            ->assertSee('<input type="hidden" name="activo" value="0">', false);
        $this->get("/generos/{$genero->id}/edit")
            ->assertSee('<input type="hidden" name="activo" value="0">', false);
    }

    public function test_destroy_elimina_el_registro(): void
    {
        $socio = Socio::factory()->create();

        $this->delete("/socios/{$socio->id}")->assertRedirect('/socios');

        $this->assertDatabaseMissing('socios', ['id' => $socio->id]);
    }

    public function test_destroy_de_entidad_referenciada_es_rechazado(): void
    {
        $autor = Autor::factory()->create();
        Libro::factory()->for($autor)->create();

        $this->delete("/autores/{$autor->id}")
            ->assertRedirect('/autores')
            ->assertSessionHas('error');

        $this->assertDatabaseHas('autores', ['id' => $autor->id]);
    }
}
