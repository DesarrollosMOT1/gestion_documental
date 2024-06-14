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
            ->with('success', 'ReferenciaGasto created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $referenciaGasto = ReferenciaGasto::find($id);

        return view('referencia-gasto.show', compact('referenciaGasto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $referenciaGasto = ReferenciaGasto::find($id);

        return view('referencia-gasto.edit', compact('referenciaGasto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReferenciaGastoRequest $request, ReferenciaGasto $referenciaGasto): RedirectResponse
    {
        $referenciaGasto->update($request->validated());

        return Redirect::route('referencia-gastos.index')
            ->with('success', 'ReferenciaGasto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ReferenciaGasto::find($id)->delete();

        return Redirect::route('referencia-gastos.index')
            ->with('success', 'ReferenciaGasto deleted successfully');
    }
}
