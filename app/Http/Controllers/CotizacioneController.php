<?php

namespace App\Http\Controllers;

use App\Models\Cotizacione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CotizacioneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\SolicitudesCotizacione;
use App\Models\SolicitudesCompra;
use App\Models\Impuesto;
use App\Models\SolicitudesElemento;
use App\Models\OrdenesCompra;

class CotizacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $cotizaciones = Cotizacione::paginate();

        return view('cotizacione.index', compact('cotizaciones'))
            ->with('i', ($request->input('page', 1) - 1) * $cotizaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create(): View
    {
        $cotizacione = new Cotizacione();
        $solicitudes_compras = SolicitudesCompra::all();
        $impuestos = Impuesto::all();

        return view('cotizacione.create', compact('cotizacione', 'solicitudes_compras', 'impuestos'));
    }

    public function store(CotizacioneRequest $request): RedirectResponse
    {
        $cotizacion = Cotizacione::create($request->validated());

        foreach ($request->elementos as $elemento) {
            SolicitudesCotizacione::create([
                'id_solicitudes_compras' => $elemento['id_solicitudes_compras'], 
                'id_cotizaciones' => $cotizacion->id,
                'cantidad' => $elemento['cantidad'],
                'id_impuestos' => $elemento['id_impuestos'],
                'id_solicitud_elemento' => $elemento['id_solicitud_elemento'],
                'estado' => '0',
                'precio' => $elemento['precio'],
            ]);
        }

        return Redirect::route('cotizaciones.index')
            ->with('success', 'Cotización creada exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Encuentra la cotización por ID e incluye las relaciones necesarias
        $cotizacione = Cotizacione::with([
            'solicitudesCotizaciones.solicitudesElemento.nivelesTres', 
            'solicitudesCotizaciones.impuesto'
        ])->findOrFail($id);
        
        // Filtra las solicitudes únicas por su ID de compra
        $solicitudesUnicas = $cotizacione->solicitudesCotizaciones->unique('id_solicitudes_compras');
    
        // Filtra las solicitudes de cotización con estado 1
        $solicitudesAprobadas = $cotizacione->solicitudesCotizaciones->where('estado', 1);
        
        // Crea una nueva instancia de OrdenesCompra
        $ordenesCompra = new OrdenesCompra();
    
        return view('cotizacione.show', compact('cotizacione', 'solicitudesUnicas', 'ordenesCompra', 'solicitudesAprobadas'));
    }
    

    public function actualizarEstado(Request $request, $id)
    {
        $elemento = SolicitudesCotizacione::findOrFail($id);
        $elemento->estado = $request->input('estado');
        $elemento->save();

        return response()->json(['success' => true]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $cotizacione = Cotizacione::find($id);

        return view('cotizacione.edit', compact('cotizacione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CotizacioneRequest $request, Cotizacione $cotizacione): RedirectResponse
    {
        $cotizacione->update($request->validated());

        return Redirect::route('cotizaciones.index')
            ->with('success', 'Cotizacion actualizada exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        Cotizacione::find($id)->delete();

        return Redirect::route('cotizaciones.index')
            ->with('success', 'Cotizacion eliminada exitosamente');
    }
}
