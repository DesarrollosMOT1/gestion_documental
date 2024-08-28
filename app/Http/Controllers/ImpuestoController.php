<?php

namespace App\Http\Controllers;

use App\Models\Impuesto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ImpuestoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ImpuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $impuestos = Impuesto::paginate();

        return view('impuesto.index', compact('impuestos'))
            ->with('i', ($request->input('page', 1) - 1) * $impuestos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $impuesto = new Impuesto();

        return view('impuesto.create', compact('impuesto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImpuestoRequest $request): RedirectResponse
    {
        Impuesto::create($request->validated());

        return Redirect::route('impuestos.index')
            ->with('success', 'Impuesto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $impuesto = Impuesto::find($id);

        return view('impuesto.show', compact('impuesto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $impuesto = Impuesto::find($id);

        return view('impuesto.edit', compact('impuesto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImpuestoRequest $request, Impuesto $impuesto): RedirectResponse
    {
        $impuesto->update($request->validated());

        return Redirect::route('impuestos.index')
            ->with('success', 'Impuesto actualizado exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        Impuesto::find($id)->delete();

        return Redirect::route('impuestos.index')
            ->with('success', 'Impuesto eliminado exitosamente');
    }
}
