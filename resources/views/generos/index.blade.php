@extends('layout')

@section('titulo', 'Géneros')

@section('contenido')
    <div class="cabecera">
        <div>
            <h1>Géneros</h1>
            <p>Cada género tiene su color de tela: así se reconoce en lomos y listados.</p>
        </div>
        <a class="btn" href="{{ route('generos.create') }}">@include('partials.icono', ['n' => 'mas']) Nuevo género</a>
    </div>

    <section class="panel">
        @if ($generos->isEmpty())
            <div class="vacio">
                <strong>Aún no hay géneros</strong>
                <p>Los géneros clasifican los libros y les dan color en la estantería. Crea al menos uno antes de registrar libros.</p>
                <a class="btn" href="{{ route('generos.create') }}">@include('partials.icono', ['n' => 'mas']) Registrar género</a>
            </div>
        @else
            <div class="tabla-marco">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Género</th>
                        <th scope="col" class="num">Edad mínima</th>
                        <th scope="col" class="num">Libros</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="num"><span class="visualmente-oculto">Acciones</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($generos as $genero)
                        <tr>
                            <td>@include('partials.chip-genero')</td>
                            <td class="fuerte">
                                <a href="{{ route('generos.show', $genero) }}">{{ $genero->nombre }}</a>
                                @if ($genero->descripcion)<span class="sec">{{ \Illuminate\Support\Str::limit($genero->descripcion, 70) }}</span>@endif
                            </td>
                            <td class="num">{{ $genero->edad_minima }}+</td>
                            <td class="num">{{ $genero->libros_count }}</td>
                            <td><span class="estado {{ $genero->activo ? 'activo' : 'inactivo' }}">{{ $genero->activo ? 'Activo' : 'Inactivo' }}</span></td>
                            <td class="acciones">
                                <a class="btn secundario chico" href="{{ route('generos.edit', $genero) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
                                @include('partials.eliminar', ['accion' => route('generos.destroy', $genero), 'pregunta' => '¿Eliminar este género?'])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $generos->links() }}
        @endif
    </section>
@endsection
