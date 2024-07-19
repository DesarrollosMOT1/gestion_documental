<?php

namespace App\Http\Controllers;

use App\Models\EstibaProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EstibaProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EstibaProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $estibaProductos = EstibaProducto::paginate();

        return view('estiba-producto.index', compact('estibaProductos'))
            ->with('i', ($request->input('page', 1) - 1) * $estibaProductos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estibaProducto = new EstibaProducto();

        return view('estiba-producto.create', compact('estibaProducto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstibaProductoRequest $request): RedirectResponse
    {
        EstibaProducto::create($request->validated());

        return Redirect::route('estiba-productos.index')
            ->with('success', 'EstibaProducto created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $estibaProducto = EstibaProducto::find($id);

        return view('estiba-producto.show', compact('estibaProducto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $estibaProducto = EstibaProducto::find($id);

        return view('estiba-producto.edit', compact('estibaProducto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstibaProductoRequest $request, EstibaProducto $estibaProducto): RedirectResponse
    {
        $estibaProducto->update($request->validated());

        return Redirect::route('estiba-productos.index')
            ->with('success', 'EstibaProducto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        EstibaProducto::find($id)->delete();

        return Redirect::route('estiba-productos.index')
            ->with('success', 'EstibaProducto deleted successfully');
    }
}
