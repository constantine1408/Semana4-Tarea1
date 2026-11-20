@extends('layout')

@section('titulo', 'Préstamo #' . $prestamo->id)

@section('contenido')
    @php($dias = $prestamo->diasRestantes())
    @php($situacion = $prestamo->situacion()['clave'])
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('prestamos.index') }}">Préstamos</a></p>
            <h1>{{ $prestamo->libro->titulo }}</h1>
            <p>
                Prestado a <a href="{{ route('socios.show', $prestamo->socio) }}">{{ $prestamo->socio->nombres }}</a> ·
                @include('partials.estado-prestamo')
            </p>
        </div>
        <div class="acciones">
            <a class="btn secundario" href="{{ route('prestamos.edit', $prestamo) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
            @include('partials.eliminar', ['accion' => route('prestamos.destroy', $prestamo), 'pregunta' => '¿Eliminar este préstamo?', 'clase' => ''])
        </div>
    </div>

    <div class="detalle-rejilla">
        <section class="panel">
            <div class="panel-cab"><h2>Préstamo #{{ $prestamo->id }}</h2></div>
            <div class="panel-cuerpo">
                <dl class="ficha">
                    <dt>Prestado</dt><dd>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</dd>
                    <dt>Fecha límite</dt><dd>{{ $prestamo->fecha_limite->format('d/m/Y') }}</dd>
                    <dt>Plazo</dt>
                    <dd>
                        @if ($situacion === 'devuelto')
                            Devuelto
                        @elseif ($dias < 0)
                            <span class="dias-vencido">{{ abs($dias) }} {{ abs($dias) === 1 ? 'día' : 'días' }} de retraso</span>
                        @elseif ($dias === 0)
                            <span class="dias-pronto">Vence hoy</span>
                        @else
                            <span class="{{ $dias <= 3 ? 'dias-pronto' : '' }}">Faltan {{ $dias }} {{ $dias === 1 ? 'día' : 'días' }}</span>
                        @endif
                    </dd>
                    <dt>Estado guardado</dt><dd>{{ ucfirst($prestamo->estado) }}</dd>
                </dl>
            </div>
        </section>

        <section class="panel">
            <div class="panel-cab"><h2>Libro y socio</h2></div>
            <div class="panel-cuerpo">
                <dl class="ficha">
                    <dt>Libro</dt><dd><a href="{{ route('libros.show', $prestamo->libro) }}">{{ $prestamo->libro->titulo }}</a></dd>
                    <dt>Autor</dt><dd><a href="{{ route('autores.show', $prestamo->libro->autor) }}">{{ $prestamo->libro->autor->nombres }}</a></dd>
                    <dt>Socio</dt><dd><a href="{{ route('socios.show', $prestamo->socio) }}">{{ $prestamo->socio->nombres }}</a></dd>
                    <dt>Cédula</dt><dd>{{ $prestamo->socio->cedula }}</dd>
                    <dt>Teléfono</dt><dd>{{ $prestamo->socio->telefono }}</dd>
                </dl>
            </div>
        </section>
    </div>
@endsection
