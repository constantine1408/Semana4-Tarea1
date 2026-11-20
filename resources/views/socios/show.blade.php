@extends('layout')

@section('titulo', $socio->nombres)

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('socios.index') }}">Socios</a></p>
            <h1>{{ $socio->nombres }}</h1>
            <p>Cédula {{ $socio->cedula }} · socio desde {{ $socio->fecha_afiliacion->format('d/m/Y') }}</p>
        </div>
        <div class="acciones">
            <a class="btn" href="{{ route('prestamos.create', ['socio' => $socio->id]) }}">@include('partials.icono', ['n' => 'prestamos']) Prestarle un libro</a>
            <a class="btn secundario" href="{{ route('socios.edit', $socio) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
            @include('partials.eliminar', ['accion' => route('socios.destroy', $socio), 'pregunta' => '¿Eliminar este socio?', 'clase' => ''])
        </div>
    </div>

    <div class="detalle-rejilla">
        <section class="panel">
            <div class="panel-cab"><h2>Ficha</h2></div>
            <div class="panel-cuerpo">
                <dl class="ficha">
                    <dt>Cédula</dt><dd>{{ $socio->cedula }}</dd>
                    <dt>Correo</dt><dd><a href="mailto:{{ $socio->correo }}">{{ $socio->correo }}</a></dd>
                    <dt>Teléfono</dt><dd>{{ $socio->telefono }}</dd>
                    <dt>Afiliación</dt><dd>{{ $socio->fecha_afiliacion->format('d/m/Y') }}</dd>
                </dl>
            </div>
        </section>

        <section class="panel">
            <div class="panel-cab"><h2>Historial de préstamos</h2></div>
            @if ($socio->prestamos->isEmpty())
                <div class="vacio">
                    <strong>Todavía no ha pedido libros</strong>
                    <p>Usa «Prestarle un libro» para registrar su primer préstamo.</p>
                </div>
            @else
                <div class="tabla-marco">
                    <table>
                        <thead>
                        <tr>
                            <th scope="col">Libro</th>
                            <th scope="col">Situación</th>
                            <th scope="col" class="num">Prestado</th>
                            <th scope="col" class="num">Fecha límite</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($socio->prestamos->sortByDesc('fecha_prestamo') as $prestamo)
                            <tr>
                                <td class="fuerte"><a href="{{ route('prestamos.show', $prestamo) }}">{{ $prestamo->libro->titulo }}</a></td>
                                <td>@include('partials.estado-prestamo')</td>
                                <td class="num">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                <td class="num">{{ $prestamo->fecha_limite->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
