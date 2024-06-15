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
    public function index(Request $request): View
    {
        $centroCostos = CentroCosto::paginate();

        return view('centro-costo.index', compact('centroCostos'))
            ->with('i', ($request->input('page', 1) - 1) * $centroCostos->perPage());
    }

    public function create(): View
    {
        $centroCosto = new CentroCosto();

        return view('centro-costo.create', compact('centroCosto'));
    }

    public function store(CentroCostoRequest $request): RedirectResponse
    {
        CentroCosto::create($request->validated());

        return Redirect::route('centro-costos.index')
            ->with('success', 'Centro de Costo creada correctamente.');
    }

    public function show($codigo): View
    {
        $centroCosto = CentroCosto::where('codigo', $codigo)->firstOrFail();

        return view('centro-costo.show', compact('centroCosto'));
    }

    public function edit($codigo): View
    {
        $centroCosto = CentroCosto::where('codigo', $codigo)->firstOrFail();

        return view('centro-costo.edit', compact('centroCosto'));
    }

    public function update(CentroCostoRequest $request, $codigo): RedirectResponse
    {
        $centroCosto = CentroCosto::where('codigo', $codigo)->firstOrFail();
        $centroCosto->update($request->validated());

        return Redirect::route('centro-costos.index')
            ->with('success', 'Centro de Costo actualizada correctamente');
    }

    public function destroy($codigo): RedirectResponse
    {
        $centroCosto = CentroCosto::where('codigo', $codigo)->firstOrFail();
        $centroCosto->delete();

        return Redirect::route('centro-costos.index')
            ->with('success', 'Centro de Costo eliminada correctamente');
    }
}
