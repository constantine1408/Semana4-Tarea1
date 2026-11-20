@extends('layout')

@section('titulo', 'Editar socio')

@section('contenido')
    <div class="cabecera">
        <div>
            <p class="migas"><a href="{{ route('socios.index') }}">Socios</a> / <a href="{{ route('socios.show', $socio) }}">{{ $socio->nombres }}</a></p>
            <h1>Editar socio</h1>
        </div>
    </div>

    @include('partials.errores')

    <form class="panel formulario" method="POST" action="{{ route('socios.update', $socio) }}">
        @csrf
        @method('PUT')
        <div class="panel-cuerpo">
            @include('socios._form', ['socio' => $socio])
        </div>
        <div class="pie-form">
            <button class="btn" type="submit">Guardar cambios</button>
            <a class="btn secundario" href="{{ route('socios.show', $socio) }}">Cancelar</a>
        </div>
    </form>
@endsection
