<?php

namespace App\Http\Controllers;

use App\Models\ClasesMovimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ClasesMovimientoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ClasesMovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $clasesMovimientos = ClasesMovimiento::paginate();

        return view('clases-movimiento.index', compact('clasesMovimientos'))
            ->with('i', ($request->input('page', 1) - 1) * $clasesMovimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clasesMovimiento = new ClasesMovimiento();

        return view('clases-movimiento.create', compact('clasesMovimiento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClasesMovimientoRequest $request): RedirectResponse
    {
        ClasesMovimiento::create($request->validated());

        return Redirect::route('clases-movimientos.index')
            ->with('success', 'ClasesMovimiento created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $clasesMovimiento = ClasesMovimiento::find($id);

        return view('clases-movimiento.show', compact('clasesMovimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $clasesMovimiento = ClasesMovimiento::find($id);

        return view('clases-movimiento.edit', compact('clasesMovimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClasesMovimientoRequest $request, ClasesMovimiento $clasesMovimiento): RedirectResponse
    {
        $clasesMovimiento->update($request->validated());

        return Redirect::route('clases-movimientos.index')
            ->with('success', 'ClasesMovimiento updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ClasesMovimiento::find($id)->delete();

        return Redirect::route('clases-movimientos.index')
            ->with('success', 'ClasesMovimiento deleted successfully');
    }

    public function getAllClasesMovimientobyTipo(Request $request,$typeid): JsonResponse
    {

        $clasesMovimientos = ClasesMovimiento::where('tipo', $typeid)
        ->get(['id', 'nombre as name']);

        return response()->json($clasesMovimientos);

    }
    public function getAllClasesMovimiento(Request $request): JsonResponse
    {

        $clasesMovimientos = ClasesMovimiento::all(['id', 'nombre as name']);

        return response()->json($clasesMovimientos);

    }
}
