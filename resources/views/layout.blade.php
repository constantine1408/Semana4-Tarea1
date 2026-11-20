<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Inicio') · Biblioteca UNIANDES</title>
    <link rel="preload" href="{{ asset('fonts/archivo-narrow-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/biblioteca.css') }}">
</head>
<body>
@include('partials.iconos')
<a class="saltar" href="#contenido">Saltar al contenido</a>

@php
    $modulos = [
        ['home', 'Inicio', 'inicio', 'home'],
        ['autores.index', 'Autores', 'autores', 'autores.*'],
        ['generos.index', 'Géneros', 'generos', 'generos.*'],
        ['libros.index', 'Libros', 'libros', 'libros.*'],
        ['socios.index', 'Socios', 'socios', 'socios.*'],
        ['prestamos.index', 'Préstamos', 'prestamos', 'prestamos.*'],
    ];
@endphp

<div class="app">
    <aside class="barra">
        <a class="marca" href="{{ route('home') }}">
            <strong>Biblioteca UNIANDES</strong>
            <span>Universidad Regional Autónoma de los Andes</span>
            <span class="filete" aria-hidden="true"></span>
        </a>

        <nav class="menu" aria-label="Módulos">
            @foreach ($modulos as [$ruta, $nombre, $icono, $patron])
                <a href="{{ route($ruta) }}" @if (request()->routeIs($patron)) aria-current="page" @endif>
                    @include('partials.icono', ['n' => $icono])
                    {{ $nombre }}
                </a>
            @endforeach
        </nav>

        <div class="accion-barra">
            <a class="btn barra-btn" href="{{ route('prestamos.create') }}">
                @include('partials.icono', ['n' => 'mas']) Registrar préstamo
            </a>
        </div>
        <p class="pie-barra">Semana 4 · Tarea 1 · Laravel</p>
    </aside>

    <main class="contenido" id="contenido">
        <div class="ancho">
            @if (session('exito'))
                <div class="aviso exito" role="status">
                    @include('partials.icono', ['n' => 'ok'])
                    <span>{{ session('exito') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="aviso error" role="alert">
                    @include('partials.icono', ['n' => 'alerta'])
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('contenido')

            <p class="pie">© {{ date('Y') }} <a href="https://www.uniandes.edu.ec/">UNIANDES, Universidad Regional Autónoma de los Andes</a> · Sistema de préstamos construido con scaffolding de Laravel.</p>
        </div>
    </main>
</div>
</body>
</html>
