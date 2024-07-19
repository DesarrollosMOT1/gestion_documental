<?php

namespace App\Http\Controllers;

use App\Models\DescarguesProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DescarguesProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DescarguesProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $descarguesProductos = DescarguesProducto::paginate();

        return view('descargues-producto.index', compact('descarguesProductos'))
            ->with('i', ($request->input('page', 1) - 1) * $descarguesProductos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $descarguesProducto = new DescarguesProducto();

        return view('descargues-producto.create', compact('descarguesProducto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DescarguesProductoRequest $request): RedirectResponse
    {
        DescarguesProducto::create($request->validated());

        return Redirect::route('descargues-productos.index')
            ->with('success', 'DescarguesProducto created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $descarguesProducto = DescarguesProducto::find($id);

        return view('descargues-producto.show', compact('descarguesProducto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $descarguesProducto = DescarguesProducto::find($id);

        return view('descargues-producto.edit', compact('descarguesProducto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DescarguesProductoRequest $request, DescarguesProducto $descarguesProducto): RedirectResponse
    {
        $descarguesProducto->update($request->validated());

        return Redirect::route('descargues-productos.index')
            ->with('success', 'DescarguesProducto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        DescarguesProducto::find($id)->delete();

        return Redirect::route('descargues-productos.index')
            ->with('success', 'DescarguesProducto deleted successfully');
    }
}
