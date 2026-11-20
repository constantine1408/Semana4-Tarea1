@extends('layout')

@section('titulo', 'Nuevo socio')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('socios.index') }}">Socios</a></p>
            <h1>Nuevo socio</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('socios.store') }}">
        @csrf
        <div class="panel-cuerpo">
            @include('socios._form')
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar</button>
            <a class="btn secundario" href="{{ route('socios.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
