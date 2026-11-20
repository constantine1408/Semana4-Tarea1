@extends('layout')

@section('titulo', 'Editar préstamo')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('prestamos.index') }}">Préstamos</a> / <a href="{{ route('prestamos.show', $prestamo) }}">{{ 'Préstamo #' . $prestamo->id }}</a></p>
            <h1>Editar préstamo</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('prestamos.update', $prestamo) }}">
        @csrf
        @method('PUT')
        <div class="panel-cuerpo">
            @include('prestamos._form', ['prestamo' => $prestamo])
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar cambios</button>
            <a class="btn secundario" href="{{ route('prestamos.show', $prestamo) }}">Cancelar</a>
        </div>
    </form>
@endsection
