@extends('layout')

@section('titulo', 'Préstamos')

@section('contenido')
    <div class="cabecera">
        <div>
            <h1>Préstamos</h1>
            <p>Quién tiene cada libro y hasta cuándo.</p>
        </div>
        <a class="btn solo-escritorio" href="{{ route('prestamos.create') }}">@include('partials.icono', ['n' => 'mas']) Registrar préstamo</a>
    </div>

    <section class="panel">
        <nav class="barra-herr" aria-label="Filtrar por estado">
            <div class="pestanas">
                <a href="{{ route('prestamos.index') }}" @if (! $filtro) aria-current="true" @endif>
                    Todos <span class="n">{{ $conteos->sum() }}</span>
                </a>
                @foreach (\App\Models\Prestamo::ESTADOS as $estado)
                    <a href="{{ route('prestamos.index', ['estado' => $estado]) }}" @if ($filtro === $estado) aria-current="true" @endif>
                        {{ ucfirst($estado) }}s <span class="n">{{ $conteos[$estado] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        @if ($prestamos->isEmpty())
            <div class="vacio">
                @if ($filtro)
                    <strong>No hay préstamos en estado «{{ $filtro }}»</strong>
                    <p>Cambia el filtro para ver los demás préstamos.</p>
                    <a class="btn secundario" href="{{ route('prestamos.index') }}">Ver todos</a>
                @else
                    <strong>Aún no hay préstamos</strong>
                    <p>Elige un libro y un socio; la fecha límite se propone a 15 días.</p>
                    <a class="btn" href="{{ route('prestamos.create') }}">@include('partials.icono', ['n' => 'mas']) Registrar préstamo</a>
                @endif
            </div>
        @else
            <div class="tabla-marco apilada">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Libro</th>
                        <th scope="col">Socio</th>
                        <th scope="col">Situación</th>
                        <th scope="col" class="num">Prestado</th>
                        <th scope="col" class="num">Fecha límite</th>
                        <th scope="col" class="num"><span class="visualmente-oculto">Acciones</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($prestamos as $prestamo)
                        <tr>
                            <td class="fuerte c-libro">
                                <span class="celda-libro">
                                    <span class="franja" style="background: {{ $prestamo->libro->genero->tela()[0] }}"></span>
                                    <a href="{{ route('prestamos.show', $prestamo) }}">{{ $prestamo->libro->titulo }}</a>
                                </span>
                            </td>
                            <td class="c-socio"><a href="{{ route('socios.show', $prestamo->socio) }}">{{ $prestamo->socio->nombres }}</a></td>
                            <td class="c-estado">@include('partials.estado-prestamo')</td>
                            <td class="num c-ocultar">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td data-label="Límite" class="num c-fecha">{{ $prestamo->fecha_limite->format('d/m/Y') }}</td>
                            <td class="acciones c-acciones">
                                <a class="btn secundario chico" href="{{ route('prestamos.edit', $prestamo) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
                                @include('partials.eliminar', ['accion' => route('prestamos.destroy', $prestamo), 'pregunta' => '¿Eliminar este préstamo?'])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $prestamos->links() }}
        @endif
    </section>
@endsection
