<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrestamoRequest;
use App\Http\Requests\UpdatePrestamoRequest;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Socio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filtro = in_array($request->query('estado'), Prestamo::ESTADOS, true)
            ? $request->query('estado')
            : null;

        $conteos = Prestamo::query()
            ->selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        return view('prestamos.index', [
            'filtro' => $filtro,
            'conteos' => $conteos,
            'prestamos' => Prestamo::query()
                ->with(['socio', 'libro.genero'])
                ->when($filtro, fn ($q) => $q->where('estado', $filtro))
                ->orderByDesc('fecha_prestamo')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('prestamos.create', $this->opciones());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrestamoRequest $request): RedirectResponse
    {
        Prestamo::create($request->validated());

        return redirect()->route('prestamos.index')
            ->with('exito', 'Préstamo registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo): View
    {
        return view('prestamos.show', [
            'prestamo' => $prestamo->load(['socio', 'libro.autor']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo): View
    {
        return view('prestamos.edit', ['prestamo' => $prestamo] + $this->opciones());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrestamoRequest $request, Prestamo $prestamo): RedirectResponse
    {
        $prestamo->update($request->validated());

        return redirect()->route('prestamos.show', $prestamo)
            ->with('exito', 'Préstamo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo): RedirectResponse
    {
        $prestamo->delete();

        return redirect()->route('prestamos.index')
            ->with('exito', 'Préstamo eliminado correctamente.');
    }

    /**
     * Opciones de los selects de relación (socio y libro).
     *
     * @return array<string, mixed>
     */
    private function opciones(): array
    {
        return [
            'socios' => Socio::query()->orderBy('nombres')->get(),
            'libros' => Libro::query()->orderBy('titulo')->get(),
        ];
    }
}
