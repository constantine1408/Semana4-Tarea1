@extends('layout')

@section('titulo', $genero->nombre)

@section('contenido')
    @php([$fondo, $texto] = $genero->tela())
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('generos.index') }}">Géneros</a></p>
            <h1>{{ $genero->nombre }}</h1>
            <p>@include('partials.chip-genero') · {{ $genero->libros->count() }} {{ $genero->libros->count() === 1 ? 'libro' : 'libros' }}</p>
        </div>
        <div class="acciones">
            <a class="btn secundario" href="{{ route('generos.edit', $genero) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
            @include('partials.eliminar', ['accion' => route('generos.destroy', $genero), 'pregunta' => '¿Eliminar este género?', 'clase' => ''])
        </div>
    </div>

    <div class="detalle-rejilla">
        <section class="panel">
            <div class="panel-cab"><h2>Ficha</h2></div>
            <div class="panel-cuerpo">
                <dl class="ficha">
                    <dt>Código</dt><dd>{{ $genero->codigo }}</dd>
                    <dt>Color de tela</dt><dd><span class="muestra" style="background: {{ $fondo }}"></span> {{ $fondo }}</dd>
                    <dt>Edad mínima</dt><dd>{{ $genero->edad_minima }} años</dd>
                    <dt>Descripción</dt><dd>{{ $genero->descripcion ?? 'Sin descripción' }}</dd>
                    <dt>Estado</dt><dd><span class="estado {{ $genero->activo ? 'activo' : 'inactivo' }}">{{ $genero->activo ? 'Activo' : 'Inactivo' }}</span></dd>
                </dl>
            </div>
        </section>

        <section class="panel">
            <div class="panel-cab"><h2>Libros de este género</h2></div>
            @if ($genero->libros->isEmpty())
                <div class="vacio">
                    <strong>Estante vacío</strong>
                    <p>Los libros que clasifiques como {{ $genero->nombre }} aparecerán aquí con este color.</p>
                </div>
            @else
                @include('partials.estanteria', ['libros' => $genero->libros])
                <div class="panel-cuerpo">
                    <table>
                        <tbody>
                        @foreach ($genero->libros as $libro)
                            <tr>
                                <td class="fuerte"><a href="{{ route('libros.show', $libro) }}">{{ $libro->titulo }}</a></td>
                                <td><a href="{{ route('autores.show', $libro->autor) }}">{{ $libro->autor->nombres }}</a></td>
                                <td class="num">{{ $libro->paginas }} págs.</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
