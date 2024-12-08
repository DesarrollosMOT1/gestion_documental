<?php

namespace App\Http\Controllers;

use App\Models\NivelesTres;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NivelesTresRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\NivelesDos;
use App\Models\ReferenciasGasto;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NivelesTresImport;

class NivelesTresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $nivelesTres = NivelesTres::paginate();

        return view('niveles-tres.index', compact('nivelesTres'))
            ->with('i', ($request->input('page', 1) - 1) * $nivelesTres->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $nivelesTre = new NivelesTres();
        $nivelesDos = NivelesDos::all(); // Obtener todos los niveles dos
        $referenciasGastos = ReferenciasGasto::all(); // Obtener todas las referencias de gastos
    
        return view('niveles-tres.create', compact('nivelesTre', 'nivelesDos', 'referenciasGastos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NivelesTresRequest $request): RedirectResponse
    {
        NivelesTres::create($request->validated());

        return Redirect::route('niveles-unos.index')
            ->with('success', 'Nivel Tres creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $nivelesTre = NivelesTres::find($id);

        return view('niveles-tres.show', compact('nivelesTre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $nivelesTre = NivelesTres::find($id);
        $nivelesDos = NivelesDos::all(); // Obtener todos los niveles dos
        $referenciasGastos = ReferenciasGasto::all(); // Obtener todas las referencias de gastos
    
        return view('niveles-tres.edit', compact('nivelesTre', 'nivelesDos', 'referenciasGastos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NivelesTresRequest $request, $id): RedirectResponse
    {
        $nivelesTres = NivelesTres::findOrFail($id);
        $data = $request->validated();
        $data['inventario'] = $request->has('inventario') ? 1 : 0;
    
        $nivelesTres->update($data);
    
        return Redirect::route('niveles-unos.index')
            ->with('success', 'Nivel Tres actualizado exitosamente');
    }    

    public function destroy($id): RedirectResponse
    {
        NivelesTres::find($id)->delete();

        return Redirect::route('niveles-unos.index')
            ->with('success', 'Nivele Tres eliminado exitosamente');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new NivelesTresImport, $request->file('file')->store('temp'));

        return redirect()->route('niveles-unos.index')
                         ->with('success', 'Los datos han sido importados correctamente.');
    }
}
