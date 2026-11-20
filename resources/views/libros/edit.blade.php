@extends('layout')

@section('titulo', 'Editar libro')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('libros.index') }}">Libros</a> / <a href="{{ route('libros.show', $libro) }}">{{ $libro->titulo }}</a></p>
            <h1>Editar libro</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('libros.update', $libro) }}">
        @csrf
        @method('PUT')
        <div class="panel-cuerpo">
            @include('libros._form', ['libro' => $libro])
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar cambios</button>
            <a class="btn secundario" href="{{ route('libros.show', $libro) }}">Cancelar</a>
        </div>
    </form>
@endsection
