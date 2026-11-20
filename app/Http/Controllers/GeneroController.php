<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGeneroRequest;
use App\Http\Requests\UpdateGeneroRequest;
use App\Models\Genero;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('generos.index', [
            'generos' => Genero::query()->withCount('libros')->orderBy('nombre')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneroRequest $request): RedirectResponse
    {
        Genero::create($request->validated());

        return redirect()->route('generos.index')
            ->with('exito', 'Género creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genero $genero): View
    {
        return view('generos.show', [
            'genero' => $genero->load(['libros.autor', 'libros.genero']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genero $genero): View
    {
        return view('generos.edit', ['genero' => $genero]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneroRequest $request, Genero $genero): RedirectResponse
    {
        $genero->update($request->validated());

        return redirect()->route('generos.show', $genero)
            ->with('exito', 'Género actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genero $genero): RedirectResponse
    {
        try {
            $genero->delete();

            return redirect()->route('generos.index')
                ->with('exito', 'Género eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('generos.index')
                ->with('error', 'No se puede eliminar: el género tiene libros registrados.');
        }
    }
}
