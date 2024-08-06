<?php

namespace App\Http\Controllers;

use App\Models\CentrosCosto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CentrosCostoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\ClasificacionesCentro;

class CentrosCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $centrosCostos = CentrosCosto::paginate();

        return view('centros-costo.index', compact('centrosCostos'))
            ->with('i', ($request->input('page', 1) - 1) * $centrosCostos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $centrosCosto = new CentrosCosto();
        $clasificacionesCentros = ClasificacionesCentro::all();
    
        return view('centros-costo.create', compact('centrosCosto', 'clasificacionesCentros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CentrosCostoRequest $request): RedirectResponse
    {
        CentrosCosto::create($request->validated());

        return Redirect::route('centros-costos.index')
            ->with('success', 'CentrosCosto created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($codigo): View
    {
        $centrosCosto = CentrosCosto::find($codigo);

        return view('centros-costo.show', compact('centrosCosto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($codigo): View
    {
        $centrosCosto = CentrosCosto::find($codigo);
        $clasificacionesCentros = ClasificacionesCentro::all();
    
        return view('centros-costo.edit', compact('centrosCosto', 'clasificacionesCentros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CentrosCostoRequest $request, CentrosCosto $centrosCosto): RedirectResponse
    {
        $centrosCosto->update($request->validated());

        return Redirect::route('centros-costos.index')
            ->with('success', 'CentrosCosto updated successfully');
    }

    public function destroy($codigo): RedirectResponse
    {
        CentrosCosto::find($codigo)->delete();

        return Redirect::route('centros-costos.index')
            ->with('success', 'CentrosCosto deleted successfully');
    }
}
