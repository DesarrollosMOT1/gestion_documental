<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquivalenciaRequest;
use App\Http\Resources\EquivalenciaResource;
use App\Models\Equivalencia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquivalenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $equivalencias = Equivalencia::paginate();

        return EquivalenciaResource::collection($equivalencias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquivalenciaRequest $request): Equivalencia
    {
        return Equivalencia::create($request->validated());
    }

    public function storeEquivalencia(int $unidadPrincipalId, array $unidadEquivalenteData): Equivalencia
    {
        if ($unidadEquivalenteData['unidad_equivalente'] === 'base') {
            $unidadEquivalenteId = $unidadPrincipalId;
        } else {
            $unidadEquivalenteId = $unidadEquivalenteData['unidad_equivalente'];
        }

        $data = [
            'unidad_principal' => $unidadPrincipalId,
            'unidad_equivalente' => $unidadEquivalenteId,
            'cantidad' => $unidadEquivalenteData['cantidad'],
        ];

        return $this->store(new EquivalenciaRequest($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(Equivalencia $equivalencia): Equivalencia
    {
        return $equivalencia;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquivalenciaRequest $request, Equivalencia $equivalencia): Equivalencia
    {
        $equivalencia->update($request->validated());

        return $equivalencia;
    }

    public function destroy(Equivalencia $equivalencia): Response
    {
        $equivalencia->delete();

        return response()->noContent();
    }
}
