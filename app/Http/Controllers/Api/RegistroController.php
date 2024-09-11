<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistroRequest;
use App\Http\Resources\RegistroResource;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $registros = Registro::paginate();

        return RegistroResource::collection($registros);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistroRequest $request): Registro
    {
        return Registro::create($request->validated());
    }

    public function storeArray($movimientoId, Request $request)
    {
        $registrosArray = $request->validated();

        foreach ($registrosArray as $value) {
            $value['movimiento'] = $movimientoId;
        }

        Registro::insert($registrosArray);
    }

    /**
     * Display the specified resource.
     */
    public function show(Registro $registro): Registro
    {
        return $registro;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegistroRequest $request, Registro $registro): Registro
    {
        $registro->update($request->validated());

        return $registro;
    }

    public function destroy(Registro $registro): Response
    {
        $registro->delete();

        return response()->noContent();
    }
}
