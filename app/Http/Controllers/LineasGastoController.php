<?php

namespace App\Http\Controllers;

use App\Models\LineasGasto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\LineasGastoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Imports\lineasGastoImport;
use Maatwebsite\Excel\Facades\Excel;

class LineasGastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new lineasGastoImport, $request->file('file'));

        return redirect()->route('lineas-gasto.index')
                         ->with('success', 'Datos importados correctamente.');
    }
    public function index(Request $request): View
    {
        $lineasGastos = LineasGasto::paginate();

        return view('lineas-gasto.index', compact('lineasGastos'))
            ->with('i', ($request->input('page', 1) - 1) * $lineasGastos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $lineasGasto = new LineasGasto();

        return view('lineas-gasto.create', compact('lineasGasto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LineasGastoRequest $request): RedirectResponse
    {
        LineasGasto::create($request->validated());

        return Redirect::route('lineas-gastos.index')
            ->with('success', 'Linea Gasto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($codigo): View
    {
        $lineasGasto = LineasGasto::find($codigo);

        return view('lineas-gasto.show', compact('lineasGasto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($codigo): View
    {
        $lineasGasto = LineasGasto::find($codigo);

        return view('lineas-gasto.edit', compact('lineasGasto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LineasGastoRequest $request, LineasGasto $lineasGasto): RedirectResponse
    {
        $lineasGasto->update($request->validated());

        return Redirect::route('lineas-gastos.index')
            ->with('success', 'Linea Gasto actualizada correctamente');
    }

    public function destroy($codigo): RedirectResponse
    {
        LineasGasto::find($codigo)->delete();

        return Redirect::route('lineas-gastos.index')
            ->with('success', 'Linea Gasto eliminada correctamnte');
    }
}
