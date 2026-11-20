@extends('layout')

@section('titulo', 'Editar autor')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('autores.index') }}">Autores</a> / <a href="{{ route('autores.show', $autor) }}">{{ $autor->nombres }}</a></p>
            <h1>Editar autor</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('autores.update', $autor) }}">
        @csrf
        @method('PUT')
        <div class="panel-cuerpo">
            @include('autores._form', ['autor' => $autor])
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar cambios</button>
            <a class="btn secundario" href="{{ route('autores.show', $autor) }}">Cancelar</a>
        </div>
    </form>
@endsection
