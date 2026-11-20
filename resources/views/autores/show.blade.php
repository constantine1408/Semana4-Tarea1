@extends('layout')

@section('titulo', $autor->nombres)

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('autores.index') }}">Autores</a></p>
            <h1>{{ $autor->nombres }}</h1>
            <p>{{ $autor->nacionalidad }} · {{ $autor->libros->count() }} {{ $autor->libros->count() === 1 ? 'libro' : 'libros' }} en la biblioteca</p>
        </div>
        <div class="acciones">
            <a class="btn secundario" href="{{ route('autores.edit', $autor) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
            @include('partials.eliminar', ['accion' => route('autores.destroy', $autor), 'pregunta' => '¿Eliminar este autor?', 'clase' => ''])
        </div>
    </div>

    <div class="detalle-rejilla">
        <section class="panel">
            <div class="panel-cab"><h2>Ficha</h2></div>
            <div class="panel-cuerpo">
                <dl class="ficha">
                    <dt>Nacionalidad</dt><dd>{{ $autor->nacionalidad }}</dd>
                    <dt>Nacimiento</dt><dd>{{ $autor->fecha_nacimiento?->format('d/m/Y') ?? 'No registrado' }}</dd>
                    <dt>Correo</dt><dd>{{ $autor->correo ?? 'No registrado' }}</dd>
                    <dt>Estado</dt><dd><span class="estado {{ $autor->activo ? 'activo' : 'inactivo' }}">{{ $autor->activo ? 'Activo' : 'Inactivo' }}</span></dd>
                </dl>
            </div>
        </section>

        <section class="panel">
            <div class="panel-cab">
                <h2>Sus libros</h2>
                <p><a href="{{ route('libros.create') }}">Agregar libro</a></p>
            </div>
            @if ($autor->libros->isEmpty())
                <div class="vacio">
                    <strong>Sin libros todavía</strong>
                    <p>Cuando registres un libro de este autor, aparecerá aquí en su estante.</p>
                </div>
            @else
                @include('partials.estanteria', ['libros' => $autor->libros])
                <div class="panel-cuerpo">
                    <table>
                        <tbody>
                        @foreach ($autor->libros as $libro)
                            <tr>
                                <td class="fuerte"><a href="{{ route('libros.show', $libro) }}">{{ $libro->titulo }}</a></td>
                                <td>@include('partials.chip-genero', ['genero' => $libro->genero])</td>
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
