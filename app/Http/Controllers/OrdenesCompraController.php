<?php

namespace App\Http\Controllers;

use App\Models\OrdenesCompra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrdenesCompraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OrdenesCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ordenesCompras = OrdenesCompra::paginate();

        return view('ordenes-compra.index', compact('ordenesCompras'))
            ->with('i', ($request->input('page', 1) - 1) * $ordenesCompras->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ordenesCompra = new OrdenesCompra();

        return view('ordenes-compra.create', compact('ordenesCompra'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrdenesCompraRequest $request): RedirectResponse
    {
        OrdenesCompra::create($request->validated());

        return Redirect::route('ordenes-compras.index')
            ->with('success', 'OrdenesCompra created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $ordenesCompra = OrdenesCompra::find($id);

        return view('ordenes-compra.show', compact('ordenesCompra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $ordenesCompra = OrdenesCompra::find($id);

        return view('ordenes-compra.edit', compact('ordenesCompra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrdenesCompraRequest $request, OrdenesCompra $ordenesCompra): RedirectResponse
    {
        $ordenesCompra->update($request->validated());

        return Redirect::route('ordenes-compras.index')
            ->with('success', 'OrdenesCompra updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        OrdenesCompra::find($id)->delete();

        return Redirect::route('ordenes-compras.index')
            ->with('success', 'OrdenesCompra deleted successfully');
    }
}