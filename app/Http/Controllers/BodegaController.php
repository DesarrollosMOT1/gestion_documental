<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BodegaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $bodegas = Bodega::paginate();

        return view('bodegas.index', compact('bodegas'))
            ->with('i', ($request->input('page', 1) - 1) * $bodegas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $bodega = new Bodega();

        return view('bodegas.create', compact('bodega'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BodegaRequest $request): RedirectResponse
    {
        Bodega::create($request->validated());

        return Redirect::route('bodegas.index')
            ->with('success', 'Bodega created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $bodega = Bodega::find($id);

        return view('bodegas.show', compact('bodega'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $bodega = Bodega::find($id);

        return view('bodegas.edit', compact('bodega'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BodegaRequest $request, Bodega $bodega): RedirectResponse
    {
        $bodega->update($request->validated());

        return Redirect::route('bodegas.index')
            ->with('success', 'Bodega updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Bodega::find($id)->delete();

        return Redirect::route('bodegas.index')
            ->with('success', 'Bodega deleted successfully');
    }

    public function getAllBodegas(Request $request): JsonResponse
    {
        $bodegas = Bodega::all(['id', 'nombre as name']);
        return response()->json($bodegas);
    }
}
