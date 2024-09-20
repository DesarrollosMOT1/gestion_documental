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
use App\Models\ConsolidacionesOferta;
use App\Models\OrdenesCompra;
use App\Models\CotizacionesPrecio;
use Illuminate\Http\JsonResponse;

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
                'descuento' => $elemento['descuento'],
                'id_impuestos' => $elemento['id_impuestos'],
                'id_solicitud_elemento' => $elemento['id_solicitud_elemento'],
                'id_consolidaciones_oferta' => $elemento['id_consolidaciones_oferta'],
                'estado' => '0',
                'precio' => $elemento['precio'],
            ]);
        }
    
    return redirect()->route('solicitudes-ofertas.show', $request->solicitud_oferta_id)
        ->with('success', 'Cotización creada exitosamente.');
    }

    public function obtenerElementosConsolidaciones($solicitudesOfertaId)
    {
        $consolidaciones = ConsolidacionesOferta::with([
            'solicitudesElemento.nivelesTres', 
            'solicitudesCompra'
        ])->where('id_solicitudes_ofertas', $solicitudesOfertaId)->get();
    
        return response()->json($consolidaciones);
    }

    public function getImpuestos(): JsonResponse
    {
        $impuestos = Impuesto::all();

        return response()->json($impuestos);
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
        $solicitudCotizacion = SolicitudesCotizacione::findOrFail($id);
        $idSolicitudElemento = $solicitudCotizacion->id_solicitud_elemento;
        $idAgrupacion = $request->input('id_agrupaciones_consolidaciones');
        $idConsolidaciones = $request->input('id_consolidaciones');  
    
        // Si el estado principal es 0, asegurarse de que estado_jefe también sea 0
        $estado = $request->input('estado');
        $estadoJefe = $estado == 0 ? 0 : $request->input('estado_jefe', 0);
    
        // Desactivar todas las cotizaciones para este elemento en esta agrupación
        CotizacionesPrecio::whereHas('solicitudesCotizacione', function($query) use ($idSolicitudElemento) {
            $query->where('id_solicitud_elemento', $idSolicitudElemento);
        })->where('id_agrupaciones_consolidaciones', $idAgrupacion)
          ->where('id_consolidaciones', $idConsolidaciones)  
          ->update(['estado' => 0, 'estado_jefe' => 0]);
    
        // Actualizar o crear el registro específico
        $cotizacionPrecio = CotizacionesPrecio::updateOrCreate(
            [
                'id_solicitudes_cotizaciones' => $id,
                'id_agrupaciones_consolidaciones' => $idAgrupacion,
                'id_consolidaciones' => $idConsolidaciones  
            ],
            [
                'estado' => $estado,
                'estado_jefe' => $estadoJefe,
                'descripcion' => $request->input('justificacion')
            ]
        );
    
        return response()->json([
            'success' => true,
            'idSolicitudElemento' => $idSolicitudElemento,
            'estado' => $estado,
            'estadoJefe' => $estadoJefe
        ]);
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
