<?php

namespace App\Http\Controllers;

use App\Models\TiposMovimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TiposMovimientoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TiposMovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tiposMovimientos = TiposMovimiento::paginate();

        return view('tipos-movimiento.index', compact('tiposMovimientos'))
            ->with('i', ($request->input('page', 1) - 1) * $tiposMovimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tiposMovimiento = new TiposMovimiento();

        return view('tipos-movimiento.create', compact('tiposMovimiento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TiposMovimientoRequest $request): RedirectResponse
    {
        TiposMovimiento::create($request->validated());

        return Redirect::route('tipos-movimientos.index')
            ->with('success', 'TiposMovimiento created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tiposMovimiento = TiposMovimiento::find($id);

        return view('tipos-movimiento.show', compact('tiposMovimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tiposMovimiento = TiposMovimiento::find($id);

        return view('tipos-movimiento.edit', compact('tiposMovimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TiposMovimientoRequest $request, TiposMovimiento $tiposMovimiento): RedirectResponse
    {
        $tiposMovimiento->update($request->validated());

        return Redirect::route('tipos-movimientos.index')
            ->with('success', 'TiposMovimiento updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        TiposMovimiento::find($id)->delete();

        return Redirect::route('tipos-movimientos.index')
            ->with('success', 'TiposMovimiento deleted successfully');
    }

    public function getAllTiposMovimiento(Request $request): JsonResponse
    {
        $tiposMovimientos = TiposMovimiento::all(['id', 'nombre as name']);
        return response()->json($tiposMovimientos);
    }
}
