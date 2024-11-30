<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovimientoRequest;
use App\Models\Movimiento;
use App\Models\Registro;
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
        $movimientos = Movimiento::with(['Almacenes', 'tiposMovimiento', 'clasesMovimiento'])->paginate();

        foreach ($movimientos as $movimiento) {
            $movimiento->clase = $movimiento->clasesMovimiento->nombre;
            $movimiento->tipo = $movimiento->tiposMovimiento->nombre;
            $movimiento->almacen = $movimiento->Almacenes->nombre;
        }

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
        try {
            $movimientoData = $request->only('tipo', 'clase', 'almacen', 'fecha', 'descripcion');

            $registrosArray = json_decode($request->input('registros'), true) ?? [];

            $movimientoBuilder = new MovimientoBuilder;
            $movimientoBuilder->setMovimientoData($movimientoData);

            $movimientoBuilder->addRegistros($registrosArray);

            $movimientoBuilder->build();

            return Redirect::route('movimientos.index')
                ->with('success', 'Movimiento creado exitosamente.');
        } catch (\Exception $e) {
            return Redirect::route('movimientos.create')
                ->with('error', 'An error occurred: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movimientoObtenido = Movimiento::find($id);

        $registrosObtenidos = Registro::where('movimiento', $id)->get();
        $movimientoObtenido = $movimientoObtenido->load([
            'Almacenes',
            'tiposMovimiento',
            'clasesMovimiento',
        ]);
        $movimiento = [
            'id' => $movimientoObtenido->id,
            'clase_nombre' => $movimientoObtenido->clasesMovimiento->nombre,
            'tipo_nombre' => $movimientoObtenido->tiposMovimiento->nombre,
            'almacen_nombre' => $movimientoObtenido->Almacenes->nombre,
            'fecha' => $movimientoObtenido->fecha,
            'descripcion' => $movimientoObtenido->descripcion,
            'created_at' => $movimientoObtenido->created_at,
        ];
        $registros = [];

        foreach ($registrosObtenidos as $registro) {
            $registro = $registro->load(['producto', 'tercero', 'unidad', 'movimiento', 'motivo'])->toArray();
            $registros[] = [
                'producto_nombre' => $registro['producto']['nombre'],
                'unidad_nombre' => $registro['unidad']['nombre'],
                'cantidad' => $registro['cantidad'],
                'tercero_nombre' => $registro['tercero']['nombre'],
                'motivo_nombre' => $registro['motivo']['nombre'],
                'detalle_registro' => $registro['detalle_registro'],
            ];

        }

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
