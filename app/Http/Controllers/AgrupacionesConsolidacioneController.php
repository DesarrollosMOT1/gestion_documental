<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesElemento;
use App\Models\ElementosConsolidado;
use App\Models\Consolidacione;
use App\Models\AgrupacionesConsolidacione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AgrupacionesConsolidacioneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        $elementos = SolicitudesElemento::with('nivelesTres')
            ->whereIn('id_solicitudes_compra', $solicitudes)
            ->where('estado', '1')
            ->get();

        return response()->json($elementos);
    }
    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        // Cargar agrupaciones junto con consolidaciones, solicitudes de compra, y elementos
        $agrupacionesConsolidacione = AgrupacionesConsolidacione::with([
            'consolidaciones.solicitudesCompra.user', 
            'consolidaciones.solicitudesCompra.solicitudesElemento.nivelesTres',
            'consolidaciones.solicitudesCompra.solicitudesCotizaciones',
        ])->findOrFail($id);
    
        return view('agrupaciones-consolidacione.show', compact('agrupacionesConsolidacione'));
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
            ->with('success', 'AgrupacionesConsolidacione updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        AgrupacionesConsolidacione::find($id)->delete();

        return Redirect::route('agrupaciones-consolidaciones.index')
            ->with('success', 'AgrupacionesConsolidacione deleted successfully');
    }
}
