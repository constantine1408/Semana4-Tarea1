<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\View\View;

class InicioController extends Controller
{
    /**
     * Portada: la estantería completa y los préstamos que hay que atender
     * (todos los que no se han devuelto, primero los de fecha más cercana).
     */
    public function __invoke(): View
    {
        $pendientes = Prestamo::query()
            ->with(['socio', 'libro.genero'])
            ->where('estado', '!=', 'devuelto')
            ->orderBy('fecha_limite')
            ->get();

        return view('home', [
            'libros' => Libro::query()->with('genero')->orderBy('genero_id')->orderBy('titulo')->get(),
            'generos' => Genero::query()->withCount('libros')->orderBy('nombre')->get(),
            'pendientes' => $pendientes->take(8),
            'totalPendientes' => $pendientes->count(),
            'vencidos' => $pendientes->filter(fn (Prestamo $p) => $p->situacion()['clave'] === 'vencido')->count(),
        ]);
    }
}
