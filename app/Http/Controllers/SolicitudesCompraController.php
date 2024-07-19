<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesCompra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudesCompraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SolicitudesCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $solicitudesCompras = SolicitudesCompra::paginate();

        return view('solicitudes-compra.index', compact('solicitudesCompras'))
            ->with('i', ($request->input('page', 1) - 1) * $solicitudesCompras->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $solicitudesCompra = new SolicitudesCompra();

        return view('solicitudes-compra.create', compact('solicitudesCompra'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SolicitudesCompraRequest $request): RedirectResponse
    {
        SolicitudesCompra::create($request->validated());

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'SolicitudesCompra created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $solicitudesCompra = SolicitudesCompra::find($id);

        return view('solicitudes-compra.show', compact('solicitudesCompra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $solicitudesCompra = SolicitudesCompra::find($id);

        return view('solicitudes-compra.edit', compact('solicitudesCompra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SolicitudesCompraRequest $request, SolicitudesCompra $solicitudesCompra): RedirectResponse
    {
        $solicitudesCompra->update($request->validated());

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'SolicitudesCompra updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        SolicitudesCompra::find($id)->delete();

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'SolicitudesCompra deleted successfully');
    }
}
