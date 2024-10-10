<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquivalenciaRequest;
use App\Http\Resources\EquivalenciaResource;
use App\Models\Equivalencia;
use Illuminate\Http\Request;

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
    public function store($request)
    {
        return Equivalencia::create($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeRequestEquivalencia(EquivalenciaRequest $request)
    {
        Equivalencia::create($request->validated());

        return redirect()->back()->with('success', 'Equivalencia creada con éxito');
    }

    public function storeEquivalencia(int $unidadPrincipalId, array $unidadEquivalenteData): Equivalencia
    {
        if ($unidadEquivalenteData['unidad'] === 'base') {
            $unidadEquivalenteId = $unidadPrincipalId;
        } else {
            $unidadEquivalenteId = $unidadEquivalenteData['unidad'];
        }

        $data = [
            'unidad_principal' => $unidadPrincipalId,
            'unidad_equivalente' => $unidadEquivalenteId,
            'cantidad' => $unidadEquivalenteData['cantidad'],
        ];

        $equivalencia = $this->store($data);

        return $equivalencia;
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

    public function destroy(Equivalencia $equivalencia)
    {
        $equivalencia->delete();

        return redirect()->back();
    }
}
