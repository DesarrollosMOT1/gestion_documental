<?php

namespace App\Http\Controllers;

use App\Models\CentroCosto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CentroCostoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CentroCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $centroCostos = CentroCosto::paginate();

        return view('centro-costo.index', compact('centroCostos'))
            ->with('i', ($request->input('page', 1) - 1) * $centroCostos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $centroCosto = new CentroCosto();

        return view('centro-costo.create', compact('centroCosto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CentroCostoRequest $request): RedirectResponse
    {
        CentroCosto::create($request->validated());

        return Redirect::route('centro-costos.index')
            ->with('success', 'CentroCosto created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $centroCosto = CentroCosto::find($id);

        return view('centro-costo.show', compact('centroCosto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $centroCosto = CentroCosto::find($id);

        return view('centro-costo.edit', compact('centroCosto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CentroCostoRequest $request, CentroCosto $centroCosto): RedirectResponse
    {
        $centroCosto->update($request->validated());

        return Redirect::route('centro-costos.index')
            ->with('success', 'CentroCosto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        CentroCosto::find($id)->delete();

        return Redirect::route('centro-costos.index')
            ->with('success', 'CentroCosto deleted successfully');
    }
}
