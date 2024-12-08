<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TercerosTestRequest;
use App\Models\TercerosTest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TercerosTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tercerosTests = TercerosTest::all(['id', 'nombre as name']);

        return response()->json($tercerosTests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TercerosTestRequest $request): TercerosTest
    {
        return TercerosTest::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(TercerosTest $tercerosTest): TercerosTest
    {
        return $tercerosTest;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TercerosTestRequest $request, TercerosTest $tercerosTest): TercerosTest
    {
        $tercerosTest->update($request->validated());

        return $tercerosTest;
    }

    public function destroy(TercerosTest $tercerosTest): Response
    {
        $tercerosTest->delete();

        return response()->noContent();
    }

    public function getAllTerceros(): JsonResponse
    {
        $tercerosTests = TercerosTest::all(['nit as id', 'nombre as name']);

        return response()->json($tercerosTests);
    }
}
