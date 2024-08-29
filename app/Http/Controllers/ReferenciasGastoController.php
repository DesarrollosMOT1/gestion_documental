<?php

namespace App\Http\Controllers;

use App\Models\ReferenciasGasto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReferenciasGastoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ReferenciasGastoImport;

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
    public function show($id): View
    {
        $referenciasGasto = ReferenciasGasto::find($id);

        return view('referencias-gasto.show', compact('referenciasGasto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $referenciasGasto = ReferenciasGasto::find($id);

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

    public function destroy($id): RedirectResponse
    {
        ReferenciasGasto::find($id)->delete();

        return Redirect::route('referencias-gastos.index')
            ->with('success', 'ReferenciasGasto eliminada exitosamente');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new ReferenciasGastoImport, $request->file('file')->store('temp'));

        return redirect()->route('referencias-gastos.index')
                         ->with('success', 'Los datos han sido importados correctamente.');
    }

}
