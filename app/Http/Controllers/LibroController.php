<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibroRequest;
use App\Http\Requests\UpdateLibroRequest;
use App\Models\Autor;
use App\Models\Genero;
use App\Models\Libro;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->query('q', ''));

        return view('libros.index', [
            'buscar' => $buscar,
            'libros' => Libro::query()
                ->with(['autor', 'genero'])
                ->when($buscar !== '', fn ($q) => $q->where(fn ($w) => $w
                    ->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('isbn', 'like', "%{$buscar}%")))
                ->orderBy('titulo')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('libros.create', $this->opciones());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibroRequest $request): RedirectResponse
    {
        Libro::create($request->validated());

        return redirect()->route('libros.index')
            ->with('exito', 'Libro creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Libro $libro): View
    {
        return view('libros.show', [
            'libro' => $libro->load(['autor', 'genero', 'prestamos.socio']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Libro $libro): View
    {
        return view('libros.edit', ['libro' => $libro] + $this->opciones());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibroRequest $request, Libro $libro): RedirectResponse
    {
        $libro->update($request->validated());

        return redirect()->route('libros.show', $libro)
            ->with('exito', 'Libro actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Libro $libro): RedirectResponse
    {
        try {
            $libro->delete();

            return redirect()->route('libros.index')
                ->with('exito', 'Libro eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('libros.index')
                ->with('error', 'No se puede eliminar: el libro tiene préstamos registrados.');
        }
    }

    /**
     * Opciones de los selects de relación (autor y género).
     *
     * @return array<string, mixed>
     */
    private function opciones(): array
    {
        return [
            'autores' => Autor::query()->orderBy('nombres')->get(),
            'generos' => Genero::query()->orderBy('nombre')->get(),
        ];
    }
}
