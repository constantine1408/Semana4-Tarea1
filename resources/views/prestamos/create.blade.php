@extends('layout')

@section('titulo', 'Registrar préstamo')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('prestamos.index') }}">Préstamos</a></p>
            <h1>Registrar préstamo</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('prestamos.store') }}">
        @csrf
        <div class="panel-cuerpo">
            @include('prestamos._form')
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar</button>
            <a class="btn secundario" href="{{ route('prestamos.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
