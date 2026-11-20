<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Genero;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Socio;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Requisito de la consigna: "las entidades deben estar relacionadas
 * entre sí".
 *
 * Relaciones 1:N: autores→libros, generos→libros, socios→prestamos y
 * libros→prestamos, verificadas en ambos sentidos y con la restricción
 * de integridad referencial de MySQL.
 */
class RelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_autor_tiene_sus_libros_y_el_libro_conoce_su_autor(): void
    {
        $autor = Autor::factory()->create();
        $libro = Libro::factory()->for($autor)->create();

        $this->assertCount(1, $autor->libros);
        $this->assertTrue($autor->libros->contains($libro));
        $this->assertTrue($libro->autor->is($autor));
    }

    public function test_un_genero_agrupa_sus_libros(): void
    {
        $genero = Genero::factory()->create();
        $libro = Libro::factory()->for($genero)->create();

        $this->assertCount(1, $genero->libros);
        $this->assertTrue($libro->genero->is($genero));
    }

    public function test_un_socio_tiene_sus_prestamos_y_el_prestamo_conoce_su_socio(): void
    {
        $socio = Socio::factory()->create();
        $prestamo = Prestamo::factory()->for($socio)->create();

        $this->assertCount(1, $socio->prestamos);
        $this->assertTrue($prestamo->socio->is($socio));
    }

    public function test_un_libro_tiene_sus_prestamos(): void
    {
        $libro = Libro::factory()->create();
        $prestamo = Prestamo::factory()->for($libro)->create();

        $this->assertCount(1, $libro->prestamos);
        $this->assertTrue($prestamo->libro->is($libro));
    }

    public function test_no_se_puede_eliminar_un_autor_con_libros(): void
    {
        $autor = Autor::factory()->create();
        Libro::factory()->for($autor)->create();

        $this->expectException(QueryException::class);

        $autor->delete();
    }

    public function test_no_se_puede_eliminar_un_libro_prestado(): void
    {
        $libro = Libro::factory()->create();
        Prestamo::factory()->for($libro)->create();

        $this->expectException(QueryException::class);

        $libro->delete();
    }

    public function test_eliminar_una_entidad_sin_referencias_si_funciona(): void
    {
        $genero = Genero::factory()->create();

        $this->assertTrue($genero->delete());
        $this->assertDatabaseMissing('generos', ['id' => $genero->id]);
    }
}
