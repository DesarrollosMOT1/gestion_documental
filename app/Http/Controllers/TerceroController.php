<?php

namespace App\Http\Controllers;

use App\Http\Requests\TerceroRequest;
use App\Imports\TercerosImport;
use App\Models\Tercero;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class TerceroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $terceros = Tercero::paginate();

        return view('tercero.index', compact('terceros'))
            ->with('i', ($request->input('page', 1) - 1) * $terceros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tercero = new Tercero;

        return view('tercero.create', compact('tercero'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TerceroRequest $request): RedirectResponse
    {
        Tercero::create($request->validated());

        return Redirect::route('terceros.index')
            ->with('success', 'Tercero creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($nit): View
    {
        $tercero = Tercero::find($nit);

        return view('tercero.show', compact('tercero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nit): View
    {
        $tercero = Tercero::find($nit);

        return view('tercero.edit', compact('tercero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TerceroRequest $request, Tercero $tercero): RedirectResponse
    {
        $tercero->update($request->validated());

        return Redirect::route('terceros.index')
            ->with('success', 'Tercero actualizado exitosamente');
    }

    public function destroy($nit): RedirectResponse
    {
        Tercero::find($nit)->delete();

        return Redirect::route('terceros.index')
            ->with('success', 'Tercero eliminado exitosamente');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new TercerosImport, $request->file('file'));

        return redirect()->route('terceros.index')
            ->with('success', 'Terceros importados exitosamente.');
    }

    public function getAllTerceros(): JsonResponse
    {
        $tercerosTests = DB::table('terceros')
            ->select('nit as id', 'nombre as name')
            ->get();
        //dd($tercerosTests);

        return response()->json($tercerosTests);
    }
}
