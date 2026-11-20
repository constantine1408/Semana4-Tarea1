@extends('layout')

@section('titulo', 'Socios')

@section('contenido')
    <div class="cabecera">
        <div>
            <h1>Socios</h1>
            <p>Personas afiliadas que pueden llevarse libros.</p>
        </div>
        <a class="btn" href="{{ route('socios.create') }}">@include('partials.icono', ['n' => 'mas']) Nuevo socio</a>
    </div>

    <section class="panel">
        <form class="barra-herr" method="GET" action="{{ route('socios.index') }}" role="search">
            <div class="buscar">
                <label class="visualmente-oculto" for="q">Buscar socio</label>
                <span class="campo-icono">
                    @include('partials.icono', ['n' => 'buscar'])
                    <input id="q" name="q" type="search" placeholder="Nombre o cédula" value="{{ $buscar }}">
                </span>
                <button class="btn secundario" type="submit">Buscar</button>
            </div>
            @if ($buscar !== '')
                <a href="{{ route('socios.index') }}">Quitar búsqueda</a>
            @endif
        </form>

        @if ($socios->isEmpty())
            <div class="vacio">
                @if ($buscar !== '')
                    <strong>Ningún socio coincide con «{{ $buscar }}»</strong>
                    <p>Revisa la cédula (10 dígitos) o busca por apellido.</p>
                    <a class="btn secundario" href="{{ route('socios.index') }}">Ver todos los socios</a>
                @else
                    <strong>Aún no hay socios</strong>
                    <p>Afilia a una persona para poder prestarle libros.</p>
                    <a class="btn" href="{{ route('socios.create') }}">@include('partials.icono', ['n' => 'mas']) Afiliar socio</a>
                @endif
            </div>
        @else
            <div class="tabla-marco">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Socio</th>
                        <th scope="col">Cédula</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col" class="num">Afiliación</th>
                        <th scope="col" class="num">Préstamos</th>
                        <th scope="col" class="num"><span class="visualmente-oculto">Acciones</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($socios as $socio)
                        <tr>
                            <td class="fuerte">
                                <a href="{{ route('socios.show', $socio) }}">{{ $socio->nombres }}</a>
                                <span class="sec">{{ $socio->correo }}</span>
                            </td>
                            <td>{{ $socio->cedula }}</td>
                            <td>{{ $socio->telefono }}</td>
                            <td class="num">{{ $socio->fecha_afiliacion->format('d/m/Y') }}</td>
                            <td class="num">{{ $socio->prestamos_count }}</td>
                            <td class="acciones">
                                <a class="btn secundario chico" href="{{ route('socios.edit', $socio) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
                                @include('partials.eliminar', ['accion' => route('socios.destroy', $socio), 'pregunta' => '¿Eliminar este socio?'])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $socios->links() }}
        @endif
    </section>
@endsection
