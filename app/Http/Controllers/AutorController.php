<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAutorRequest;
use App\Http\Requests\UpdateAutorRequest;
use App\Models\Autor;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('autores.index', [
            'autores' => Autor::query()->withCount('libros')->orderBy('nombres')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('autores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAutorRequest $request): RedirectResponse
    {
        Autor::create($request->validated());

        return redirect()->route('autores.index')
            ->with('exito', 'Autor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Autor $autor): View
    {
        return view('autores.show', [
            'autor' => $autor->load('libros.genero'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Autor $autor): View
    {
        return view('autores.edit', ['autor' => $autor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAutorRequest $request, Autor $autor): RedirectResponse
    {
        $autor->update($request->validated());

        return redirect()->route('autores.show', $autor)
            ->with('exito', 'Autor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * La clave foránea restrictOnDelete hace que MySQL rechace el borrado
     * si el autor tiene libros; se informa al usuario en vez de un error 500.
     */
    public function destroy(Autor $autor): RedirectResponse
    {
        try {
            $autor->delete();

            return redirect()->route('autores.index')
                ->with('exito', 'Autor eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('autores.index')
                ->with('error', 'No se puede eliminar: el autor tiene libros registrados.');
        }
    }
}
