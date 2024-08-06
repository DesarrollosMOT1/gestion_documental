<?php

namespace App\Http\Controllers;

use App\Models\NivelesDos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NivelesDosRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\NivelesUno;

class NivelesDosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $nivelesDos = NivelesDos::paginate();

        return view('niveles-dos.index', compact('nivelesDos'))
            ->with('i', ($request->input('page', 1) - 1) * $nivelesDos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $nivelesDo = new NivelesDos();
        $nivelesUnos = NivelesUno::all(); // Obtener todos los niveles uno
    
        return view('niveles-dos.create', compact('nivelesDo', 'nivelesUnos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NivelesDosRequest $request): RedirectResponse
    {
        NivelesDos::create($request->validated());

        return Redirect::route('niveles-dos.index')
            ->with('success', 'NivelesDo created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $nivelesDo = NivelesDos::find($id);

        return view('niveles-dos.show', compact('nivelesDo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $nivelesDo = NivelesDos::find($id);
        $nivelesUnos = NivelesUno::all(); // Obtener todos los niveles uno
    
        return view('niveles-dos.edit', compact('nivelesDo', 'nivelesUnos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NivelesDosRequest $request, NivelesDos $nivelesDo): RedirectResponse
    {
        $nivelesDo->update($request->validated());

        return Redirect::route('niveles-dos.index')
            ->with('success', 'NivelesDo updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        NivelesDos::find($id)->delete();

        return Redirect::route('niveles-dos.index')
            ->with('success', 'NivelesDo deleted successfully');
    }
}
