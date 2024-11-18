<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovimientoRequest;
use App\Models\Movimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Consulta del movimiento con todas las relaciones necesarias
        $movimiento = DB::table('movimientos')
            ->join('clases_movimientos', 'movimientos.clase', '=', 'clases_movimientos.id')
            ->join('tipos_movimientos', 'clases_movimientos.tipo', '=', 'tipos_movimientos.id')
            ->join('almacenes', 'movimientos.almacen', '=', 'almacenes.id')
            ->join('bodegas', 'almacenes.bodega', '=', 'bodegas.id')
            ->where('movimientos.id', $id)
            ->select(
                'movimientos.*',
                'clases_movimientos.nombre as clase_nombre',
                'tipos_movimientos.nombre as tipo_nombre',
                'almacenes.nombre as almacen_nombre',
                'bodegas.nombre as bodega_nombre'
            )
            ->first();

        // Consulta de los registros asociados con joins para obtener datos adicionales
        $registros = DB::table('registros')
            ->join('productos', 'registros.producto', '=', 'productos.codigo_producto')
            ->join('unidades', 'registros.unidad', '=', 'unidades.id')
            ->join('terceros', 'registros.tercero', '=', 'terceros.nit')
            ->join('motivos', 'registros.motivo', '=', 'motivos.id')
            ->where('registros.movimiento', $id)
            ->select(
                'productos.nombre as producto_nombre',
                'unidades.nombre as unidad_nombre',
                'registros.cantidad',
                'terceros.nombre as tercero_nombre',
                'motivos.nombre as motivo_nombre',
                'registros.detalle_registro'
            )
            ->get();

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
