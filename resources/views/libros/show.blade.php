@extends('layout')

@section('titulo', $libro->titulo)

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('libros.index') }}">Libros</a></p>
            <h1>{{ $libro->titulo }}</h1>
            <p>de <a href="{{ route('autores.show', $libro->autor) }}">{{ $libro->autor->nombres }}</a> · @include('partials.chip-genero', ['genero' => $libro->genero])</p>
        </div>
        <div class="acciones">
            <a class="btn" href="{{ route('prestamos.create', ['libro' => $libro->id]) }}">@include('partials.icono', ['n' => 'prestamos']) Prestar este libro</a>
            <a class="btn secundario" href="{{ route('libros.edit', $libro) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
            @include('partials.eliminar', ['accion' => route('libros.destroy', $libro), 'pregunta' => '¿Eliminar este libro?', 'clase' => ''])
        </div>
    </div>

    <div class="detalle-rejilla">
        <section class="panel">
            <div class="panel-cab"><h2>Ficha</h2></div>
            <div class="panel-cuerpo">
                <dl class="ficha">
                    <dt>ISBN</dt><dd>{{ $libro->isbn }}</dd>
                    <dt>Páginas</dt><dd>{{ $libro->paginas }}</dd>
                    <dt>Autor</dt><dd><a href="{{ route('autores.show', $libro->autor) }}">{{ $libro->autor->nombres }}</a></dd>
                    <dt>Género</dt><dd><a href="{{ route('generos.show', $libro->genero) }}">{{ $libro->genero->nombre }}</a></dd>
                </dl>
            </div>
        </section>

        <section class="panel">
            <div class="panel-cab"><h2>Préstamos de este libro</h2></div>
            @if ($libro->prestamos->isEmpty())
                <div class="vacio">
                    <strong>Nunca se ha prestado</strong>
                    <p>Usa «Prestar este libro» para registrar el primer préstamo.</p>
                </div>
            @else
                <div class="tabla-marco">
                    <table>
                        <thead>
                        <tr>
                            <th scope="col">Socio</th>
                            <th scope="col">Situación</th>
                            <th scope="col" class="num">Prestado</th>
                            <th scope="col" class="num">Fecha límite</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($libro->prestamos->sortByDesc('fecha_prestamo') as $prestamo)
                            <tr>
                                <td class="fuerte"><a href="{{ route('socios.show', $prestamo->socio) }}">{{ $prestamo->socio->nombres }}</a></td>
                                <td>@include('partials.estado-prestamo')</td>
                                <td class="num">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                <td class="num"><a href="{{ route('prestamos.show', $prestamo) }}">{{ $prestamo->fecha_limite->format('d/m/Y') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
