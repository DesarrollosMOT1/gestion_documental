<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Models\Unidades;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $unidades = Unidades::paginate();

        return view('unidades.index', compact('unidades'))
            ->with('i', ($request->input('page', 1) - 1) * $unidades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $unidades = new Unidades;

        return view('unidades.create', compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUnidad(UnidadeRequest $request)
    {
        return Unidades::create($request->validated());
    }

    public function store(UnidadeRequest $request): RedirectResponse
    {
        $UnidadData = $request->input('nombre');
        $EquivalenciaJson = $request->only('unidad', 'cantidad');

        $unidad = $this->storeUnidad($UnidadData);

        Http::post(route('registros.store-array', ['movimientoId' => $unidad->id]),
            $EquivalenciaJson
        );

        return Redirect::route('movimientos.index')
            ->with('success', 'Movimiento created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $unidades = Unidades::find($id);

        return view('unidades.show', compact('unidades'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $unidades = Unidades::find($id);

        return view('unidades.edit', compact('unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnidadeRequest $request, Unidades $unidades): RedirectResponse
    {
        $unidades->update($request->validated());

        return Redirect::route('unidades.index')
            ->with('success', 'Unidade updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Unidades::find($id)->delete();

        return Redirect::route('unidades.index')
            ->with('success', 'Unidade deleted successfully');
    }

    public function getAllUnidades(Request $request): JsonResponse
    {
        $unidades = Unidades::all(['id', 'nombre as name']);

        return response()->json($unidades);
    }
}
