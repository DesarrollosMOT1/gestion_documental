<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesElemento;
use App\Models\SolicitudesCompra;
use App\Models\User;
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
use Spatie\Permission\Models\Permission;

class AgrupacionesConsolidacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $agrupacionesConsolidaciones = AgrupacionesConsolidacione::paginate();

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
                    'estado' => 0,
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
                    'estado' => 0,
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
        
        // Mapeo de permisos a los nombres de los niveles uno
        $permissions = [
            'ver_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_sistemas' => 'SISTEMAS',
            'ver_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_dotacion_personal' => 'DOTACION PERSONAL',
        ];

        // Obtener los nombres de los niveles uno permitidos según los permisos del usuario
        $nivelesPermitidos = [];
        foreach ($permissions as $permiso => $nombre) {
            if (auth()->user()->hasPermissionTo($permiso)) {
                $nivelesPermitidos[] = $nombre;
            }
        }

        // Obtener los niveles uno permitidos
        $nivelesUnoIds = NivelesUno::whereIn('nombre', $nivelesPermitidos)->pluck('id')->toArray();

        // Obtener los elementos filtrados por nivel uno permitido y estado
        $elementos = SolicitudesElemento::with('nivelesTres')
            ->whereIn('id_solicitudes_compra', $solicitudes)
            ->where('estado', '1')
            ->whereHas('nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
                $query->whereIn('id', $nivelesUnoIds);
            })
            ->get();

        return response()->json($elementos);
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
                    'estado' => 0,
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
        $solicitudesCompra = new SolicitudesCompra();
        $solicitudesCompra->prefijo = $this->generatePrefix();
        $users = User::all();
        $centrosCostos = CentrosCosto::all();
        $fechaActual = Carbon::now()->toDateString();

        // Mapeo de permisos a los nombres de los niveles uno
        $permissions = [
            'ver_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_sistemas' => 'SISTEMAS',
            'ver_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_dotacion_personal' => 'DOTACION PERSONAL',
        ];
    
        // Obtener los nombres de los niveles uno según los permisos del usuario
        $nivelesPermitidos = [];
        foreach ($permissions as $permiso => $nombre) {
            if (auth()->user()->hasPermissionTo($permiso)) {
                $nivelesPermitidos[] = $nombre;
            }
        }
    
        // Obtener los niveles uno con base en los permisos del usuario
        $nivelesUno = NivelesUno::whereIn('nombre', $nivelesPermitidos)->get();

        $agrupacionesConsolidacione = AgrupacionesConsolidacione::with([
            'consolidaciones.solicitudesCompra.user', 
            'consolidaciones.solicitudesCompra.solicitudesElemento.nivelesTres',
            'consolidaciones.solicitudesCompra.solicitudesCotizaciones',
            'consolidaciones.elementosConsolidados.solicitudesCompra',
            'consolidaciones.elementosConsolidados.solicitudesElemento.nivelesTres'
        ])->findOrFail($id);

        $agrupacion = AgrupacionesConsolidacione::findOrFail($id);
    
        return view('agrupaciones-consolidacione.show', compact('agrupacion', 'agrupacionesConsolidacione', 'solicitudesCompra', 'users', 'centrosCostos', 'fechaActual', 'nivelesUno'));
    }

    private function generatePrefix(): string
    {
        $month = strtoupper(date('M')); // Obtiene las primeras tres letras del mes actual (Jun, Jul, etc.)
        $year = date('y'); // Obtiene los últimos dos dígitos del año actual (24 para 2024)
        return $month . $year;
    }
    public function actualizarEstado(Request $request, $id)
    {
        $consolidacion = Consolidacione::findOrFail($id);
        $consolidacion->estado = $request->input('estado');
        $consolidacion->save();

        return response()->json(['success' => true]);
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
