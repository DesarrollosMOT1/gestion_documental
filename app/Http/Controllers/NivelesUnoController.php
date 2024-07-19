<?php

namespace App\Http\Controllers;

use App\Models\NivelesUno;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NivelesUnoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NivelesUnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $nivelesUnos = NivelesUno::paginate();

        return view('niveles-uno.index', compact('nivelesUnos'))
            ->with('i', ($request->input('page', 1) - 1) * $nivelesUnos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $nivelesUno = new NivelesUno();

        return view('niveles-uno.create', compact('nivelesUno'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NivelesUnoRequest $request): RedirectResponse
    {
        NivelesUno::create($request->validated());

        return Redirect::route('niveles-unos.index')
            ->with('success', 'NivelesUno created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $nivelesUno = NivelesUno::find($id);

        return view('niveles-uno.show', compact('nivelesUno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $nivelesUno = NivelesUno::find($id);

        return view('niveles-uno.edit', compact('nivelesUno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NivelesUnoRequest $request, NivelesUno $nivelesUno): RedirectResponse
    {
        $nivelesUno->update($request->validated());

        return Redirect::route('niveles-unos.index')
            ->with('success', 'NivelesUno updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        NivelesUno::find($id)->delete();

        return Redirect::route('niveles-unos.index')
            ->with('success', 'NivelesUno deleted successfully');
    }
}
