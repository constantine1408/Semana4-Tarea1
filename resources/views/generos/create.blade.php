@extends('layout')

@section('titulo', 'Nuevo género')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('generos.index') }}">Géneros</a></p>
            <h1>Nuevo género</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('generos.store') }}">
        @csrf
        <div class="panel-cuerpo">
            @include('generos._form')
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar</button>
            <a class="btn secundario" href="{{ route('generos.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
