<?php

namespace App\Http\Controllers;

use App\Models\Estiba;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EstibaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EstibaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $estibas = Estiba::paginate();

        return view('estiba.index', compact('estibas'))
            ->with('i', ($request->input('page', 1) - 1) * $estibas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estiba = new Estiba();

        return view('estiba.create', compact('estiba'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstibaRequest $request): RedirectResponse
    {
        Estiba::create($request->validated());

        return Redirect::route('estibas.index')
            ->with('success', 'Estiba created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $estiba = Estiba::find($id);

        return view('estiba.show', compact('estiba'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $estiba = Estiba::find($id);

        return view('estiba.edit', compact('estiba'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstibaRequest $request, Estiba $estiba): RedirectResponse
    {
        $estiba->update($request->validated());

        return Redirect::route('estibas.index')
            ->with('success', 'Estiba updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Estiba::find($id)->delete();

        return Redirect::route('estibas.index')
            ->with('success', 'Estiba deleted successfully');
    }
}
