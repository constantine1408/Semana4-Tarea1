@extends('layout')

@section('titulo', 'Inicio')

@section('contenido')
    <div class="cabecera">
        <div>
            <h1>Estantería</h1>
            <p>
                {{ $libros->count() }} {{ $libros->count() === 1 ? 'libro' : 'libros' }} en {{ $generos->count() }} géneros ·
                {{ $totalPendientes }} {{ $totalPendientes === 1 ? 'préstamo' : 'préstamos' }} sin devolver
                @if ($vencidos > 0)
                    · <strong class="dias-vencido">{{ $vencidos }} {{ $vencidos === 1 ? 'vencido' : 'vencidos' }}</strong>
                @endif
            </p>
        </div>
        <div class="acciones">
            <a class="btn secundario" href="{{ route('libros.create') }}">@include('partials.icono', ['n' => 'mas']) Nuevo libro</a>
            <a class="btn solo-escritorio" href="{{ route('prestamos.create') }}">@include('partials.icono', ['n' => 'prestamos']) Registrar préstamo</a>
        </div>
    </div>

    <section class="panel" aria-labelledby="t-estante">
        <div class="panel-cab">
            <h2 id="t-estante">Todos los libros</h2>
            <p>El color es el género; la altura, el número de páginas.</p>
        </div>
        @if ($libros->isEmpty())
            <div class="vacio">
                <strong>La estantería está vacía</strong>
                <p>Registra primero un autor y un género; después podrás agregar libros y aparecerán aquí como lomos.</p>
                <a class="btn" href="{{ route('autores.create') }}">@include('partials.icono', ['n' => 'mas']) Registrar autor</a>
            </div>
        @else
            @include('partials.estanteria', ['libros' => $libros])
            <ul class="leyenda">
                @foreach ($generos as $genero)
                    <li>
                        <span class="muestra" style="background: {{ $genero->tela()[0] }}"></span>
                        <a href="{{ route('generos.show', $genero) }}">{{ $genero->nombre }}</a>
                        <span class="n">{{ $genero->libros_count }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="panel" aria-labelledby="t-pendientes">
        <div class="panel-cab">
            <h2 id="t-pendientes">Préstamos por atender</h2>
            <p><a href="{{ route('prestamos.index') }}">Ver todos los préstamos</a></p>
        </div>
        @if ($pendientes->isEmpty())
            <div class="vacio">
                <strong>No hay préstamos pendientes</strong>
                <p>Cuando prestes un libro, aparecerá aquí ordenado por fecha límite.</p>
            </div>
        @else
            <div class="tabla-marco apilada">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Libro</th>
                        <th scope="col">Socio</th>
                        <th scope="col">Situación</th>
                        <th scope="col" class="num">Fecha límite</th>
                        <th scope="col" class="num">Días</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($pendientes as $prestamo)
                        @php($dias = $prestamo->diasRestantes())
                        <tr>
                            <td class="fuerte c-libro">
                                <span class="celda-libro">
                                    <span class="franja" style="background: {{ $prestamo->libro->genero->tela()[0] }}"></span>
                                    <a href="{{ route('prestamos.show', $prestamo) }}">{{ $prestamo->libro->titulo }}</a>
                                </span>
                            </td>
                            <td class="c-socio"><a href="{{ route('socios.show', $prestamo->socio) }}">{{ $prestamo->socio->nombres }}</a></td>
                            <td class="c-estado">@include('partials.estado-prestamo')</td>
                            <td class="num c-ocultar">{{ $prestamo->fecha_limite->format('d/m/Y') }}</td>
                            <td data-label="Días" class="num c-dias {{ $dias < 0 ? 'dias-vencido' : ($dias <= 3 ? 'dias-pronto' : '') }}">{{ $dias < 0 ? '−' . abs($dias) : $dias }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
