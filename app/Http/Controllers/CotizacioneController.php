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
use App\Traits\VerNivelesPermiso;
use Carbon\Carbon;

class CotizacioneController extends Controller
{
    use VerNivelesPermiso;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Rango de fechas por defecto (últimos 14 días)
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->subDays(14)->toDateString());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->toDateString());

        $cotizaciones = Cotizacione::whereHas('solicitudesCotizaciones.solicitudesElemento.nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds){
            $query->whereIn('id', $nivelesUnoIds);
        })
        ->whereBetween('fecha_cotizacion', [$fechaInicio, $fechaFin])
        ->with('solicitudesCotizaciones.solicitudesElemento')
        ->paginate();

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
            'solicitudesCompra',
            'consolidacione'
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
        
        // Verificar si el usuario tiene acceso a la cotización
        $this->authorize('view', $cotizacione);
        
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
    
        // Validar permisos según el campo que se intenta actualizar
        if ($request->has('estado') || $request->has('justificacion')) {
            if (!auth()->user()->can('editar_consolidacion_estado')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para editar el estado o la justificación.'
                ], 403);
            }
        }
    
        if ($request->has('estado_jefe')) {
            if (!auth()->user()->can('editar_consolidacion_estado_jefe')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para editar el estado del jefe.'
                ], 403);
            }
        }
    
        // Preparar los datos a actualizar
        $dataToUpdate = [
            'id_solicitudes_cotizaciones' => $id,
            'id_agrupaciones_consolidaciones' => $idAgrupacion,
            'id_consolidaciones' => $idConsolidaciones
        ];
    
        // Si se está actualizando solo estado_jefe, obtenemos el valor actual de 'estado'
        if ($request->has('estado_jefe') && !$request->has('estado')) {
            $cotizacionExistente = CotizacionesPrecio::where([
                'id_solicitudes_cotizaciones' => $id,
                'id_agrupaciones_consolidaciones' => $idAgrupacion,
                'id_consolidaciones' => $idConsolidaciones
            ])->first();
    
            $dataToUpdate['estado'] = $cotizacionExistente ? $cotizacionExistente->estado : 0; // Valor por defecto si no existe
        }
    
        if ($request->has('estado')) {
            $dataToUpdate['estado'] = $request->input('estado');
            
            if ($request->input('estado') == 1) {
                // Desactivar otras cotizaciones
                CotizacionesPrecio::whereHas('solicitudesCotizacione', function($query) use ($idSolicitudElemento) {
                    $query->where('id_solicitud_elemento', $idSolicitudElemento);
                })->where('id_agrupaciones_consolidaciones', $idAgrupacion)
                    ->where('id_consolidaciones', $idConsolidaciones)  
                    ->where('id_solicitudes_cotizaciones', '!=', $id)
                    ->update(['estado' => 0]);
            }
        }
        
        if ($request->has('estado_jefe')) {
            $dataToUpdate['estado_jefe'] = $request->input('estado_jefe');
        }
        
        if ($request->has('justificacion')) {
            $dataToUpdate['descripcion'] = $request->input('justificacion');
        }
    
        // Actualizar o crear el registro
        $cotizacionPrecio = CotizacionesPrecio::updateOrCreate(
            [
                'id_solicitudes_cotizaciones' => $id,
                'id_agrupaciones_consolidaciones' => $idAgrupacion,
                'id_consolidaciones' => $idConsolidaciones  
            ],
            $dataToUpdate
        );
    
        return response()->json([
            'success' => true,
            'idSolicitudElemento' => $idSolicitudElemento
        ]);
    }    

    public function actualizarJustificacionJefe(Request $request, $id)
    {
        // Verificar si el usuario tiene el permiso
        if (!auth()->user()->can('editar_consolidacion_estado_jefe')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para realizar esta acción.'
            ], 403);
        }
    
        $solicitudCotizacion = SolicitudesCotizacione::findOrFail($id);
        $idAgrupacion = $request->input('id_agrupaciones_consolidaciones');
        $idConsolidaciones = $request->input('id_consolidaciones');
    
        $cotizacionPrecio = CotizacionesPrecio::updateOrCreate(
            [
                'id_solicitudes_cotizaciones' => $id,
                'id_agrupaciones_consolidaciones' => $idAgrupacion,
                'id_consolidaciones' => $idConsolidaciones
            ],
            [
                'justificacion_jefe' => $request->input('justificacion_jefe')
            ]
        );
    
        return response()->json([
            'success' => true
        ]);
    }    

    public function getCotizacionesEstadoJefe($agrupacionId): JsonResponse
    {
        // Obtener las cotizaciones_precio que no tengan órdenes de compra creadas
        $cotizacionesPrecio = CotizacionesPrecio::where('estado_jefe', 1)
            ->where('id_agrupaciones_consolidaciones', $agrupacionId)
            ->whereNotIn('id_consolidaciones', function($query) {
                $query->select('id_consolidaciones')
                      ->from('ordenes_compra_cotizaciones');
            })
            ->with([
                'solicitudesCotizacione.consolidacionOferta',
                'solicitudesCotizacione.cotizacione.tercero',
                'agrupacionesConsolidacione', 
                'consolidacione',
                'consolidacione.solicitudesElemento.nivelesTres'
            ])
            ->get();
    
        return response()->json([
            'success' => true,
            'data' => $cotizacionesPrecio
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
