@extends('layout')

@section('titulo', 'Nuevo autor')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('autores.index') }}">Autores</a></p>
            <h1>Nuevo autor</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('autores.store') }}">
        @csrf
        <div class="panel-cuerpo">
            @include('autores._form')
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar</button>
            <a class="btn secundario" href="{{ route('autores.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
