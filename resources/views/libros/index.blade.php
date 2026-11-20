@extends('layout')

@section('titulo', 'Libros')

@section('contenido')
    <div class="cabecera">
        <div>
            <h1>Libros</h1>
            <p>El catálogo completo, con su autor y su género.</p>
        </div>
        <a class="btn" href="{{ route('libros.create') }}">@include('partials.icono', ['n' => 'mas']) Nuevo libro</a>
    </div>

    <section class="panel">
        <form class="barra-herr" method="GET" action="{{ route('libros.index') }}" role="search">
            <div class="buscar">
                <label class="visualmente-oculto" for="q">Buscar libro</label>
                <span class="campo-icono">
                    @include('partials.icono', ['n' => 'buscar'])
                    <input id="q" name="q" type="search" placeholder="Título o ISBN" value="{{ $buscar }}">
                </span>
                <button class="btn secundario" type="submit">Buscar</button>
            </div>
            @if ($buscar !== '')
                <a href="{{ route('libros.index') }}">Quitar búsqueda</a>
            @endif
        </form>

        @if ($libros->isEmpty())
            <div class="vacio">
                @if ($buscar !== '')
                    <strong>Ningún libro coincide con «{{ $buscar }}»</strong>
                    <p>Prueba con otra parte del título o con el ISBN completo.</p>
                    <a class="btn secundario" href="{{ route('libros.index') }}">Ver todos los libros</a>
                @else
                    <strong>Aún no hay libros</strong>
                    <p>Para registrar un libro necesitas un autor y un género. Luego aparecerá en la estantería de la portada.</p>
                    <a class="btn" href="{{ route('libros.create') }}">@include('partials.icono', ['n' => 'mas']) Registrar libro</a>
                @endif
            </div>
        @else
            <div class="tabla-marco">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Género</th>
                        <th scope="col">ISBN</th>
                        <th scope="col" class="num">Páginas</th>
                        <th scope="col" class="num"><span class="visualmente-oculto">Acciones</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($libros as $libro)
                        <tr>
                            <td class="fuerte">
                                <span class="celda-libro">
                                    <span class="franja" style="background: {{ $libro->genero->tela()[0] }}"></span>
                                    <a href="{{ route('libros.show', $libro) }}">{{ $libro->titulo }}</a>
                                </span>
                            </td>
                            <td><a href="{{ route('autores.show', $libro->autor) }}">{{ $libro->autor->nombres }}</a></td>
                            <td>@include('partials.chip-genero', ['genero' => $libro->genero])</td>
                            <td class="num-texto">{{ $libro->isbn }}</td>
                            <td class="num">{{ $libro->paginas }}</td>
                            <td class="acciones">
                                <a class="btn secundario chico" href="{{ route('libros.edit', $libro) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
                                @include('partials.eliminar', ['accion' => route('libros.destroy', $libro), 'pregunta' => '¿Eliminar este libro?'])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $libros->links() }}
        @endif
    </section>
@endsection
