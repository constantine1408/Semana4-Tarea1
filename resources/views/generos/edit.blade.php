@extends('layout')

@section('titulo', 'Editar género')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('generos.index') }}">Géneros</a> / <a href="{{ route('generos.show', $genero) }}">{{ $genero->nombre }}</a></p>
            <h1>Editar género</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('generos.update', $genero) }}">
        @csrf
        @method('PUT')
        <div class="panel-cuerpo">
            @include('generos._form', ['genero' => $genero])
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar cambios</button>
            <a class="btn secundario" href="{{ route('generos.show', $genero) }}">Cancelar</a>
        </div>
    </form>
@endsection
