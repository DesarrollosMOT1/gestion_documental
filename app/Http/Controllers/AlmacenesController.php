<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AlmacenesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AlmacenesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $almacenes = Almacenes::paginate()->withQueryString();

        return view('almacenes.index', compact('almacenes'))
            ->with('i', ($request->input('page', 1) - 1) * $almacenes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $Almacenes = new Almacenes();

        return view('almacenes.create', compact('Almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlmacenesRequest $request): RedirectResponse
    {
        Almacenes::create($request->validated());

        return Redirect::route('almacenes.index')
            ->with('success', 'Almacenes created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $Almacenes = Almacenes::find($id);

        return view('almacenes.show', compact('Almacenes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $Almacenes = Almacenes::find($id);

        return view('almacenes.edit', compact('Almacenes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlmacenesRequest $request, Almacenes $Almacenes): RedirectResponse
    {
        $Almacenes->update($request->validated());

        return Redirect::route('almacenes.index')
            ->with('success', 'Almacenes updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Almacenes::find($id)->delete();

        return Redirect::route('almacenes.index')
            ->with('success', 'Almacenes deleted successfully');
    }

    public function getAllAlmacenes(): JsonResponse
    {
        $Almacenes = Almacenes::all(['id', 'nombre as name']);
        return response()->json($Almacenes);
    }
}
