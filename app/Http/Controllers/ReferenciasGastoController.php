<?php

namespace App\Http\Controllers;

use App\Models\ReferenciasGasto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReferenciasGastoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ReferenciasGastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $referenciasGastos = ReferenciasGasto::paginate();

        return view('referencias-gasto.index', compact('referenciasGastos'))
            ->with('i', ($request->input('page', 1) - 1) * $referenciasGastos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $referenciasGasto = new ReferenciasGasto();

        return view('referencias-gasto.create', compact('referenciasGasto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReferenciasGastoRequest $request): RedirectResponse
    {
        ReferenciasGasto::create($request->validated());

        return Redirect::route('referencias-gastos.index')
            ->with('success', 'Referencia Gasto creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($codigo): View
    {
        $referenciasGasto = ReferenciasGasto::find($codigo);

        return view('referencias-gasto.show', compact('referenciasGasto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($codigo): View
    {
        $referenciasGasto = ReferenciasGasto::find($codigo);

        return view('referencias-gasto.edit', compact('referenciasGasto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReferenciasGastoRequest $request, ReferenciasGasto $referenciasGasto): RedirectResponse
    {
        $referenciasGasto->update($request->validated());

        return Redirect::route('referencias-gastos.index')
            ->with('success', 'Referencia Gasto actualizada exitosamente');
    }

    public function destroy($codigo): RedirectResponse
    {
        ReferenciasGasto::find($codigo)->delete();

        return Redirect::route('referencias-gastos.index')
            ->with('success', 'ReferenciasGasto eliminada exitosamente');
    }
}
