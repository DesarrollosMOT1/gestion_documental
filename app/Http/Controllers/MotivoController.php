<?php

namespace App\Http\Controllers;

use App\Models\Motivo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MotivoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MotivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $motivos = Motivo::paginate();

        return view('motivos.index', compact('motivos'))
            ->with('i', ($request->input('page', 1) - 1) * $motivos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $motivo = new Motivo();

        return view('motivos.create', compact('motivo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MotivoRequest $request): RedirectResponse
    {
        Motivo::create($request->validated());

        return Redirect::route('motivos.index')
            ->with('success', 'Motivo created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $motivo = Motivo::find($id);

        return view('motivos.show', compact('motivo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $motivo = Motivo::find($id);

        return view('motivos.edit', compact('motivo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MotivoRequest $request, Motivo $motivo): RedirectResponse
    {
        $motivo->update($request->validated());

        return Redirect::route('motivos.index')
            ->with('success', 'Motivo updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Motivo::find($id)->delete();

        return Redirect::route('motivos.index')
            ->with('success', 'Motivo deleted successfully');
    }

    public function getAllMotivos(Request $request): JsonResponse
    {
        $motivos = Motivo::all(['id', 'nombre as name']);
        return response()->json($motivos);
    }
}
