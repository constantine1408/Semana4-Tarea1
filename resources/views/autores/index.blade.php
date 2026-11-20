@extends('layout')

@section('titulo', 'Autores')

@section('contenido')
    <div class="cabecera">
        <div>
            <h1>Autores</h1>
            <p>Quienes escribieron los libros del catálogo.</p>
        </div>
        <a class="btn" href="{{ route('autores.create') }}">@include('partials.icono', ['n' => 'mas']) Nuevo autor</a>
    </div>

    <section class="panel">
        @if ($autores->isEmpty())
            <div class="vacio">
                <strong>Aún no hay autores</strong>
                <p>Cada libro necesita un autor. Registra el primero para empezar a llenar la estantería.</p>
                <a class="btn" href="{{ route('autores.create') }}">@include('partials.icono', ['n' => 'mas']) Registrar autor</a>
            </div>
        @else
            <div class="tabla-marco">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Autor</th>
                        <th scope="col">Nacionalidad</th>
                        <th scope="col" class="num">Nacimiento</th>
                        <th scope="col" class="num">Libros</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="num"><span class="visualmente-oculto">Acciones</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($autores as $autor)
                        <tr>
                            <td class="fuerte">
                                <a href="{{ route('autores.show', $autor) }}">{{ $autor->nombres }}</a>
                                @if ($autor->correo)<span class="sec">{{ $autor->correo }}</span>@endif
                            </td>
                            <td>{{ $autor->nacionalidad }}</td>
                            <td class="num">{{ $autor->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</td>
                            <td class="num">{{ $autor->libros_count }}</td>
                            <td><span class="estado {{ $autor->activo ? 'activo' : 'inactivo' }}">{{ $autor->activo ? 'Activo' : 'Inactivo' }}</span></td>
                            <td class="acciones">
                                <a class="btn secundario chico" href="{{ route('autores.edit', $autor) }}">@include('partials.icono', ['n' => 'editar']) Editar</a>
                                @include('partials.eliminar', ['accion' => route('autores.destroy', $autor), 'pregunta' => '¿Eliminar este autor?'])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $autores->links() }}
        @endif
    </section>
@endsection
