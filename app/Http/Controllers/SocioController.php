<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocioRequest;
use App\Http\Requests\UpdateSocioRequest;
use App\Models\Socio;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->query('q', ''));

        return view('socios.index', [
            'buscar' => $buscar,
            'socios' => Socio::query()
                ->withCount('prestamos')
                ->when($buscar !== '', fn ($q) => $q->where(fn ($w) => $w
                    ->where('nombres', 'like', "%{$buscar}%")
                    ->orWhere('cedula', 'like', "%{$buscar}%")))
                ->orderBy('nombres')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('socios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocioRequest $request): RedirectResponse
    {
        Socio::create($request->validated());

        return redirect()->route('socios.index')
            ->with('exito', 'Socio creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Socio $socio): View
    {
        return view('socios.show', [
            'socio' => $socio->load('prestamos.libro'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Socio $socio): View
    {
        return view('socios.edit', ['socio' => $socio]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocioRequest $request, Socio $socio): RedirectResponse
    {
        $socio->update($request->validated());

        return redirect()->route('socios.show', $socio)
            ->with('exito', 'Socio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Socio $socio): RedirectResponse
    {
        try {
            $socio->delete();

            return redirect()->route('socios.index')
                ->with('exito', 'Socio eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('socios.index')
                ->with('error', 'No se puede eliminar: el socio tiene préstamos registrados.');
        }
    }
}
