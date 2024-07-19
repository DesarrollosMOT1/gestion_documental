<?php

namespace App\Http\Controllers;

use App\Models\UnidadesEquivalente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UnidadesEquivalenteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UnidadesEquivalenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $unidadesEquivalentes = UnidadesEquivalente::paginate();

        return view('unidades-equivalente.index', compact('unidadesEquivalentes'))
            ->with('i', ($request->input('page', 1) - 1) * $unidadesEquivalentes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $unidadesEquivalente = new UnidadesEquivalente();

        return view('unidades-equivalente.create', compact('unidadesEquivalente'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UnidadesEquivalenteRequest $request): RedirectResponse
    {
        UnidadesEquivalente::create($request->validated());

        return Redirect::route('unidades-equivalentes.index')
            ->with('success', 'UnidadesEquivalente created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $unidadesEquivalente = UnidadesEquivalente::find($id);

        return view('unidades-equivalente.show', compact('unidadesEquivalente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $unidadesEquivalente = UnidadesEquivalente::find($id);

        return view('unidades-equivalente.edit', compact('unidadesEquivalente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnidadesEquivalenteRequest $request, UnidadesEquivalente $unidadesEquivalente): RedirectResponse
    {
        $unidadesEquivalente->update($request->validated());

        return Redirect::route('unidades-equivalentes.index')
            ->with('success', 'UnidadesEquivalente updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        UnidadesEquivalente::find($id)->delete();

        return Redirect::route('unidades-equivalentes.index')
            ->with('success', 'UnidadesEquivalente deleted successfully');
    }
}
