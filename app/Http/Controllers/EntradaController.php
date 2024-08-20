<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EntradaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $entradas = Entrada::paginate();

        return view('entrada.index', compact('entradas'))
            ->with('i', ($request->input('page', 1) - 1) * $entradas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $entrada = new Entrada();

        return view('entrada.create', compact('entrada'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntradaRequest $request): RedirectResponse
    {
        Entrada::create($request->validated());

        return Redirect::route('entradas.index')
            ->with('success', 'Entrada created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $entrada = Entrada::find($id);

        return view('entrada.show', compact('entrada'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $entrada = Entrada::find($id);

        return view('entrada.edit', compact('entrada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntradaRequest $request, Entrada $entrada): RedirectResponse
    {
        $entrada->update($request->validated());

        return Redirect::route('entradas.index')
            ->with('success', 'Entrada updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Entrada::find($id)->delete();

        return Redirect::route('entradas.index')
            ->with('success', 'Entrada deleted successfully');
    }
}
