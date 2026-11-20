<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;

Route::get('/', InicioController::class)->name('home');

// `Str::singular()` trabaja en inglés: "autores" daría "autore". Se fija
// el nombre del parámetro para que el binding implícito case con los
// argumentos de los controladores ($autor, $genero, $socio...).
Route::resource('autores', AutorController::class)
    ->parameters(['autores' => 'autor']);
Route::resource('generos', GeneroController::class)
    ->parameters(['generos' => 'genero']);
Route::resource('libros', LibroController::class)
    ->parameters(['libros' => 'libro']);
Route::resource('socios', SocioController::class)
    ->parameters(['socios' => 'socio']);
Route::resource('prestamos', PrestamoController::class)
    ->parameters(['prestamos' => 'prestamo']);
