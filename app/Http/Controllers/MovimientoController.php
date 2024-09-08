<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovimientoRequest;
use App\Jobs\ProcessRegistrosJob;
use App\Models\Movimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $movimientos = Movimiento::paginate();

        return view('movimientos.index', compact('movimientos'))
            ->with('i', ($request->input('page', 1) - 1) * $movimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $movimiento = new Movimiento;

        return view('movimientos.create', compact('movimiento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMovimiento($request)
    {
        return Movimiento::create($request);
    }

    public function store(MovimientoRequest $request): RedirectResponse
    {
        $movimientoData = $request->only('tipo', 'clase', 'almacen', 'fecha', 'descripcion');
        $registrosJson = $request->input('registros');

        // Decodificar la cadena JSON en un array PHP
        $registrosArray = json_decode($registrosJson, true);

        $movimiento = $this->storeMovimiento($movimientoData);

        // Despacha el job para procesar los registros en segundo plano
        ProcessRegistrosJob::dispatch($movimiento->id, $registrosArray);

        return Redirect::route('movimientos.index')
            ->with('success', 'Movimiento created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $movimiento = Movimiento::find($id);
        $registros = $movimiento->registros->toArray();
        // dd($registros);

        return view('movimientos.show', compact('movimiento', 'registros'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $movimiento = Movimiento::find($id);

        return view('movimientos.edit', compact('movimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovimientoRequest $request, Movimiento $movimiento): RedirectResponse
    {
        $movimiento->update($request->validated());

        return Redirect::route('movimientos.index')
            ->with('success', 'Movimiento updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Movimiento::find($id)->delete();

        return Redirect::route('movimientos.index')
            ->with('success', 'Movimiento deleted successfully');
    }
}
