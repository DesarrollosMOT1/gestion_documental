<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesCotizacione;
use App\Models\SolicitudesElemento;
use App\Models\SolicitudesCompra;
use App\Models\CentrosCosto;
use Carbon\Carbon;
use App\Http\Requests\SolicitudesCompraRequest;
use App\Models\ElementosConsolidado;
use App\Models\Consolidacione;
use App\Models\AgrupacionesConsolidacione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AgrupacionesConsolidacioneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\NivelesUno;
use App\Models\SolicitudesOferta;
use App\Models\Tercero;
use App\Models\OrdenesCompra;
use App\Traits\VerNivelesPermiso;
use App\Traits\GenerarPrefijo;
use App\Traits\ObtenerCentrosCostos;


class AgrupacionesConsolidacioneController extends Controller
{
    use VerNivelesPermiso, GenerarPrefijo, ObtenerCentrosCostos;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Rango de fechas por defecto (últimos 14 días)
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->subDays(14)->toDateString());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->toDateString());
    
        // Filtrar las consolidaciones por rango de fechas
        $agrupacionesConsolidaciones = AgrupacionesConsolidacione::whereHas('consolidaciones.solicitudesElemento.nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
            $query->whereIn('id', $nivelesUnoIds);
        })
        ->whereBetween('fecha_consolidacion', [$fechaInicio, $fechaFin])
        ->with('consolidaciones.solicitudesElemento')
        ->paginate();
    
        return view('agrupaciones-consolidacione.index', compact('agrupacionesConsolidaciones'))
            ->with('i', ($request->input('page', 1) - 1) * $agrupacionesConsolidaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $agrupacionesConsolidacione = new AgrupacionesConsolidacione();

        return view('agrupaciones-consolidacione.create', compact('agrupacionesConsolidacione'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(AgrupacionesConsolidacioneRequest $request): RedirectResponse
    {
        // Guardar la agrupación de consolidación
        $agrupacion = AgrupacionesConsolidacione::create($request->validated());
    
        if (!$agrupacion) {
            return Redirect::route('agrupaciones-consolidaciones.index')
                ->with('error', 'No se pudo crear la agrupación de consolidación.');
        }
    
        // Obtener los elementos del request
        $elementos = $request->input('elementos', []);
    
        foreach ($elementos as $elemento) {
            $elementosOriginales = $elemento['elementos_originales'] ?? [];
            
            // Verificar si realmente hubo consolidación (más de un elemento original)
            if (count($elementosOriginales) > 1) {
                $consolidacion = Consolidacione::create([
                    'agrupacion_id' => $agrupacion->id,
                    'id_solicitudes_compras' => $elemento['id_solicitudes_compra'],
                    'id_solicitud_elemento' => $elemento['id_solicitud_elemento'],
                    'cantidad' => $elemento['cantidad'],
                ]);
    
                if (!$consolidacion) {
                    return Redirect::route('agrupaciones-consolidaciones.index')
                        ->with('error', 'No se pudo crear la consolidación.');
                }
    
                // Registrar la trazabilidad de cada elemento original
                foreach ($elementosOriginales as $elementoOriginal) {
                    ElementosConsolidado::create([
                        'id_consolidacion' => $consolidacion->id,
                        'id_solicitud_compra' => $elementoOriginal['id_solicitudes_compra'],
                        'id_solicitud_elemento' => $elementoOriginal['id_solicitud_elemento'],
                    ]);
                }
            } else {
                // Si no hubo consolidación, crear una entrada normal en Consolidacione
                Consolidacione::create([
                    'agrupacion_id' => $agrupacion->id,
                    'id_solicitudes_compras' => $elemento['id_solicitudes_compra'],
                    'id_solicitud_elemento' => $elemento['id_solicitud_elemento'],
                    'cantidad' => $elemento['cantidad'],
                ]);
            }
        }
    
        return Redirect::route('agrupaciones-consolidaciones.index')
            ->with('success', 'Agrupación de consolidación creada exitosamente.');
    }

    public function getElementosMultiple(Request $request)
    {
        $solicitudes = $request->input('solicitudes', []);
        
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();
    
        // Obtener los elementos filtrados por nivel uno permitido, estado y que no tengan consolidaciones
        $elementos = SolicitudesElemento::with('nivelesTres')
            ->whereIn('id_solicitudes_compra', $solicitudes)
            ->where('estado', '1')
            ->whereHas('nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
                $query->whereIn('id', $nivelesUnoIds);
            })
            ->whereNotIn('id', function($query) {
                $query->select('id_solicitud_elemento')
                    ->from('consolidaciones');
            })
            ->whereNotIn('id', function($query) {
                $query->select('id_solicitud_elemento')
                    ->from('elementos_consolidados');
            })
            ->get();
    
        return response()->json($elementos);
    }    


    public function crearSolicitudCompra(): array
    {
        $solicitudesCompra = new SolicitudesCompra();
        $solicitudesCompra->prefijo = $this->generatePrefix();
        $centrosCostos = $this->obtenerCentrosCostos();
        
        $solicitudesOferta = new SolicitudesOferta();
        $terceros = Tercero::all();

        $nivelesUno = NivelesUno::whereIn('id', $this->obtenerNivelesPermitidos())->get();

        return compact('solicitudesCompra', 'centrosCostos', 'solicitudesOferta', 'terceros', 'nivelesUno');
    }

    public function storeSolicitudesCompra(SolicitudesCompraRequest $request, $agrupacionesConsolidacioneId): RedirectResponse
    {
        $validated = $request->validated();
    
        // Crear la solicitud de compra
        $solicitudesCompra = SolicitudesCompra::create($validated);
    
        // Obtener la agrupación de consolidaciones
        $agrupacion = AgrupacionesConsolidacione::findOrFail($agrupacionesConsolidacioneId);
    
        // Crear los elementos de solicitud y consolidar
        $elements = $request->input('elements', []);
        foreach ($elements as $element) {
            // Crear SolicitudesElemento
            $solicitudElemento = $solicitudesCompra->solicitudesElemento()->create([
                'id_niveles_tres' => $element['id_niveles_tres'],
                'id_centros_costos' => $element['id_centros_costos'],
                'cantidad' => $element['cantidad'],
                'estado' => 1,
                'id_solicitudes_compra' => $solicitudesCompra->id,
            ]);
    
            // Buscar una consolidación existente con el mismo nivel_tres
            $consolidacionExistente = Consolidacione::where('agrupacion_id', $agrupacion->id)
                ->whereHas('solicitudesElemento', function ($query) use ($element) {
                    $query->where('id_niveles_tres', $element['id_niveles_tres']);
                })
                ->first();
    
            if ($consolidacionExistente) {
                // Actualizar la cantidad consolidada
                $cantidadTotal = $consolidacionExistente->cantidad + $element['cantidad'];
                $consolidacionExistente->update([
                    'cantidad' => $cantidadTotal,
                ]);
    
                // Verificar si ya existe un registro en ElementosConsolidado para esta consolidación
                $elementoConsolidadoExistente = ElementosConsolidado::where('id_consolidacion', $consolidacionExistente->id)->exists();
    
                // Solo crear un nuevo registro en ElementosConsolidado para la nueva solicitud
                ElementosConsolidado::create([
                    'id_consolidacion' => $consolidacionExistente->id,
                    'id_solicitud_compra' => $solicitudesCompra->id,
                    'id_solicitud_elemento' => $solicitudElemento->id,
                ]);
    
                // Si no existía un registro previo, crear uno para la consolidación original
                if (!$elementoConsolidadoExistente) {
                    ElementosConsolidado::create([
                        'id_consolidacion' => $consolidacionExistente->id,
                        'id_solicitud_compra' => $consolidacionExistente->id_solicitudes_compras,
                        'id_solicitud_elemento' => $consolidacionExistente->id_solicitud_elemento,
                    ]);
                }
            } else {
                // Crear nueva Consolidacione sin consolidar
                Consolidacione::create([
                    'agrupacion_id' => $agrupacion->id,
                    'id_solicitudes_compras' => $solicitudesCompra->id,
                    'id_solicitud_elemento' => $solicitudElemento->id,
                    'cantidad' => $element['cantidad'],
                ]);
            }
        }
    
        return Redirect::route('agrupaciones-consolidaciones.show', $agrupacion->id)
            ->with('success', 'Solicitud de compra creada y consolidada exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $agrupacion = AgrupacionesConsolidacione::findOrFail($id);

        $ordenesCompra = new OrdenesCompra();
    
        // Llamar al nuevo método que encapsula la lógica de la solicitud de compra
        $datosSolicitudCompra = $this->crearSolicitudCompra();
    
        $agrupacionesConsolidacione = AgrupacionesConsolidacione::with([
            'consolidaciones.solicitudesCompra.user',
            'consolidaciones.solicitudesCompra.solicitudesElemento.nivelesTres',
            'consolidaciones.solicitudesCompra.solicitudesCotizaciones',
            'consolidaciones.elementosConsolidados.solicitudesCompra',
            'consolidaciones.elementosConsolidados.solicitudesElemento.nivelesTres',
            'consolidaciones.cotizacionesPrecio'
        ])->findOrFail($id);
    
        // Verificar si el usuario tiene el permiso 'ver_consolidaciones_jefe'
        if (auth()->user()->can('ver_consolidaciones_jefe')) {
            // Filtrar consolidaciones que tengan cotizaciones_precio relacionadas con estado = 1
            $consolidacionesFiltered = $agrupacionesConsolidacione->consolidaciones->filter(function ($consolidacion) {
                return $consolidacion->cotizacionesPrecio->where('estado', 1)->isNotEmpty();
            });
            $agrupacionesConsolidacione->setRelation('consolidaciones', $consolidacionesFiltered);
        }
    
        $cotizacionesPorElemento = $this->verificarCotizacionesVigentes($agrupacionesConsolidacione->id);

        $historialCotizaciones = $this->obtenerHistorialCotizaciones($agrupacionesConsolidacione->id);
        
        // Agrupar cotizaciones por elemento y tercero
        $elementosConsolidados = $agrupacionesConsolidacione->consolidaciones->mapToGroups(function($consolidacion) {
            return [$consolidacion->solicitudesElemento->nivelesTres->nombre => $consolidacion];
        });
        
        $cotizacionesPorTercero = $cotizacionesPorElemento->groupBy(function($cotizacion) {
            return $cotizacion->cotizacione->tercero->nombre ?? 'Proveedor N/A';
        });
    
        return view('agrupaciones-consolidacione.show', array_merge($datosSolicitudCompra, compact('agrupacion', 'agrupacionesConsolidacione', 'cotizacionesPorTercero', 'elementosConsolidados', 'ordenesCompra', 'historialCotizaciones')));
    }
    
    
    public function verificarCotizacionesVigentes($agrupacionId)
    {
        // Obtener los IDs de los niveles tres relacionados con las consolidaciones de la agrupación
        $nivelesTresIds = Consolidacione::where('agrupacion_id', $agrupacionId)
            ->whereHas('solicitudesElemento', function ($query) {
                $query->select('id_niveles_tres');
            })
            ->get()
            ->pluck('solicitudesElemento.nivelesTres.id');

        // Verificar las solicitudes cotizaciones vigentes que coincidan con esos niveles tres
        $cotizaciones = SolicitudesCotizacione::whereIn('id_solicitud_elemento', function ($subQuery) use ($nivelesTresIds) {
                $subQuery->select('id')
                        ->from('solicitudes_elementos')
                        ->whereIn('id_niveles_tres', $nivelesTresIds);
            })
            ->whereHas('cotizacione', function ($query) {
                $query->whereDate('fecha_inicio_vigencia', '<=', now())
                    ->whereDate('fecha_fin_vigencia', '>=', now());
            })
            ->with('cotizacione.tercero')
            ->get();
    
        foreach ($cotizaciones as $cotizacion) {
            $fechaFinVigencia = Carbon::parse($cotizacion->cotizacione->fecha_fin_vigencia);
            $diferenciaDias = now()->diffInDays($fechaFinVigencia);
    
            if ($fechaFinVigencia->endOfDay()->lt(now())) {
                $cotizacion->estado_vigencia = 'expirado';
            } elseif ($diferenciaDias <= 30) {
                $cotizacion->estado_vigencia = 'cercano';
            } elseif ($diferenciaDias <= 90) {
                $cotizacion->estado_vigencia = 'medio';
            } else {
                $cotizacion->estado_vigencia = 'lejos';
            }
    
            $cotizacion->diferencia_dias = $diferenciaDias;
        }
    
        return $cotizaciones;
    }

    public function obtenerHistorialCotizaciones($agrupacionId)
    {
        // Obtener los IDs de los niveles tres relacionados con las consolidaciones de la agrupación
        $nivelesTresIds = Consolidacione::where('agrupacion_id', $agrupacionId)
            ->whereHas('solicitudesElemento', function ($query) {
                $query->select('id_niveles_tres');
            })
            ->get()
            ->pluck('solicitudesElemento.nivelesTres.id');
    
        // Obtener el historial completo de cotizaciones para esos niveles tres
        $historialCotizaciones = SolicitudesCotizacione::whereIn('id_solicitud_elemento', function ($subQuery) use ($nivelesTresIds) {
                $subQuery->select('id')
                        ->from('solicitudes_elementos')
                        ->whereIn('id_niveles_tres', $nivelesTresIds);
            })
            ->with('cotizacione.tercero')
            ->get();
    
        return $historialCotizaciones;
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $agrupacionesConsolidacione = AgrupacionesConsolidacione::find($id);

        return view('agrupaciones-consolidacione.edit', compact('agrupacionesConsolidacione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgrupacionesConsolidacioneRequest $request, AgrupacionesConsolidacione $agrupacionesConsolidacione): RedirectResponse
    {
        $agrupacionesConsolidacione->update($request->validated());

        return Redirect::route('agrupaciones-consolidaciones.index')
            ->with('success', 'Agrupacion Consolidacion actualizada exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        AgrupacionesConsolidacione::find($id)->delete();

        return Redirect::route('agrupaciones-consolidaciones.index')
            ->with('success', 'Agrupacion Consolidacion eliminada exitosamente');
    }
}
