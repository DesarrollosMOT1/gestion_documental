<?php

namespace App\Http\Controllers;

use App\Models\ClasificacionesCentro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ClasificacionesCentroRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ClasificacionesCentroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $clasificacionesCentros = ClasificacionesCentro::paginate();

        return view('clasificaciones-centro.index', compact('clasificacionesCentros'))
            ->with('i', ($request->input('page', 1) - 1) * $clasificacionesCentros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clasificacionesCentro = new ClasificacionesCentro();

        return view('clasificaciones-centro.create', compact('clasificacionesCentro'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClasificacionesCentroRequest $request): RedirectResponse
    {
        ClasificacionesCentro::create($request->validated());

        return Redirect::route('clasificaciones-centros.index')
            ->with('success', 'ClasificacionesCentro created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $clasificacionesCentro = ClasificacionesCentro::find($id);

        return view('clasificaciones-centro.show', compact('clasificacionesCentro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $clasificacionesCentro = ClasificacionesCentro::find($id);

        return view('clasificaciones-centro.edit', compact('clasificacionesCentro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClasificacionesCentroRequest $request, ClasificacionesCentro $clasificacionesCentro): RedirectResponse
    {
        $clasificacionesCentro->update($request->validated());

        return Redirect::route('clasificaciones-centros.index')
            ->with('success', 'ClasificacionesCentro updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ClasificacionesCentro::find($id)->delete();

        return Redirect::route('clasificaciones-centros.index')
            ->with('success', 'ClasificacionesCentro deleted successfully');
    }
}