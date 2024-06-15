<?php

namespace App\Http\Controllers;

use App\Models\ReferenciaGasto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReferenciaGastoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ReferenciaGastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $referenciaGastos = ReferenciaGasto::paginate();

        return view('referencia-gasto.index', compact('referenciaGastos'))
            ->with('i', ($request->input('page', 1) - 1) * $referenciaGastos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $referenciaGasto = new ReferenciaGasto();

        return view('referencia-gasto.create', compact('referenciaGasto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReferenciaGastoRequest $request): RedirectResponse
    {
        ReferenciaGasto::create($request->validated());

        return Redirect::route('referencia-gastos.index')
            ->with('success', 'Referencia de Gasto creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($codigo): View
    {
        $referenciaGasto = ReferenciaGasto::where('codigo', $codigo)->firstOrFail();

        return view('referencia-gasto.show', compact('referenciaGasto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($codigo): View
    {
        $referenciaGasto = ReferenciaGasto::where('codigo', $codigo)->firstOrFail();

        return view('referencia-gasto.edit', compact('referenciaGasto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReferenciaGastoRequest $request, $codigo): RedirectResponse
    {
        $referenciaGasto = ReferenciaGasto::where('codigo', $codigo)->firstOrFail();
        $referenciaGasto->update($request->validated());

        return Redirect::route('referencia-gastos.index')
            ->with('success', 'Referencia de Gasto actualizada correctamente');
    }

    public function destroy($codigo): RedirectResponse
    {
        $referenciaGasto = ReferenciaGasto::where('codigo', $codigo)->firstOrFail();
        $referenciaGasto->delete();

        return Redirect::route('referencia-gastos.index')
            ->with('success', 'Referencia de Gasto eliminada correctamente');
    }
}
