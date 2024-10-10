<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\EquivalenciaController;
use App\Http\Requests\UnidadeRequest;
use App\Models\Unidades;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $unidades = Unidades::with(['equivalencias.unidad_equivalente'])->paginate();

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
    public function storeUnidad($request)
    {
        return Unidades::create($request);
    }

    public function store(UnidadeRequest $request): RedirectResponse
    {
        $request->validated();
        $UnidadData = $request->only('nombre');
        $EquivalenciaJson = $request->only('unidad', 'cantidad');
        $unidad = $this->storeUnidad($UnidadData);

        $equivalenciasController = new EquivalenciaController;
        $equivalenciasController->storeEquivalencia($unidad->id, $EquivalenciaJson);

        return Redirect::route('unidades.index')
            ->with('success', 'unidad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $unidad = Unidades::find($id);
        $equivalencias = DB::table('equivalencias')
            ->join('unidades AS unidad_equivalente', 'equivalencias.unidad_equivalente', '=', 'unidad_equivalente.id')
            ->where('equivalencias.unidad_principal', $unidad->id)
            ->select('equivalencias.cantidad', 'unidad_equivalente.nombre as nombre_equivalente', 'equivalencias.id')
            ->get();

        return view('unidades.show', compact('unidad', 'equivalencias'));
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
            ->with('success', 'Unidad updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Unidades::find($id)->delete();

        return Redirect::route('unidades.index')
            ->with('success', 'Unidad borrada exitosamente');
    }

    public function getAllUnidades(Request $request): JsonResponse
    {
        $unidades = Unidades::all(['id', 'nombre as name']);

        return response()->json($unidades);
    }
}
