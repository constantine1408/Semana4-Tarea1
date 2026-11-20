@extends('layout')

@section('titulo', 'Nuevo libro')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('libros.index') }}">Libros</a></p>
            <h1>Nuevo libro</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('libros.store') }}">
        @csrf
        <div class="panel-cuerpo">
            @include('libros._form')
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar</button>
            <a class="btn secundario" href="{{ route('libros.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
