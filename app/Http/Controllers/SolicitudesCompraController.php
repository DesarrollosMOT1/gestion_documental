<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesCompra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudesCompraRequest;
use App\Models\AgrupacionesConsolidacione;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\NivelesUno;
use App\Models\NivelesDos;
use App\Models\NivelesTres;
use App\Models\SolicitudesElemento;
use App\Traits\VerNivelesPermiso;
use App\Traits\GenerarPrefijo;
use App\Traits\ObtenerCentrosCostos;


class SolicitudesCompraController extends Controller
{
    use VerNivelesPermiso, GenerarPrefijo, ObtenerCentrosCostos ;
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request): View
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();
    
        // Rango de fechas por defecto (últimos 14 días)
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->subDays(14)->toDateString());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->toDateString());
    
        $solicitudesComprasQuery = SolicitudesCompra::query();
    
        // Filtrar por solicitudes propias y las de los niveles permitidos
        $solicitudesComprasQuery->where(function($query) use ($nivelesUnoIds) {
            $query->where('id_users', auth()->user()->id)
                ->orWhereHas('solicitudesElemento.nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
                    $query->whereIn('id', $nivelesUnoIds);
                });
        });
    
        // Filtrar por el rango de fechas
        $solicitudesCompras = $solicitudesComprasQuery->whereBetween('fecha_solicitud', [$fechaInicio, $fechaFin])
            ->with('solicitudesElemento')
            ->paginate();
    
        $agrupacionesConsolidacione = new AgrupacionesConsolidacione();
    
        return view('solicitudes-compra.index', compact('solicitudesCompras', 'agrupacionesConsolidacione'))
            ->with('i', ($request->input('page', 1) - 1) * $solicitudesCompras->perPage());
    }
     


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $solicitudesCompra = new SolicitudesCompra();
        $solicitudesCompra->prefijo = $this->generatePrefix();
        $centrosCostos = $this->obtenerCentrosCostos();
        
        $nivelesUno = NivelesUno::whereIn('id', $this->obtenerNivelesPermitidosSolicitudCompra())->get();
        
        // Obtener los niveles tres
        $nivelesTres = NivelesTres::all();
    
        // Verificar si hay elementos antiguos
        $oldElements = old('elements', []);
        
        // Si hay elementos antiguos, buscar sus nombres
        $elementsWithNames = array_map(function ($element) use ($nivelesTres, $centrosCostos) {
            return [
                'id_niveles_tres' => $element['id_niveles_tres'],
                'id_centros_costos' => $element['id_centros_costos'],
                'cantidad' => $element['cantidad'],
                'nombre_nivel_tres' => $nivelesTres->firstWhere('id', $element['id_niveles_tres'])->nombre ?? 'No encontrado',
                'nombre_centro_costo' => $centrosCostos->firstWhere('id', $element['id_centros_costos'])->nombre ?? 'No encontrado',
            ];
        }, $oldElements);
    
        return view('solicitudes-compra.create', compact('solicitudesCompra', 'nivelesUno', 'centrosCostos', 'elementsWithNames'));
    }    
    
    
    public function getNivelesDos($idNivelUno)
    {
        $nivelesDos = NivelesDos::where('id_niveles_uno', $idNivelUno)->get();
        return response()->json($nivelesDos);
    }

    public function getNivelesTres($idNivelDos)
    {
        $nivelesTres = NivelesTres::where('id_niveles_dos', $idNivelDos)
            ->select('id', 'nombre', 'inventario')
            ->get();
        return response()->json($nivelesTres);
    }

    


    /**
     * Store a newly created resource in storage.
     */
    public function store(SolicitudesCompraRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Crear la solicitud de compra
        $solicitudesCompra = SolicitudesCompra::create($validated);

        // Crear los elementos de solicitud
        $elements = $request->input('elements', []);
        
        foreach ($elements as $element) {
            // Verificar si ya existe un elemento con el mismo nivel tres y centro de costos en esta solicitud
            $existingElement = SolicitudesElemento::where('id_niveles_tres', $element['id_niveles_tres'])
                ->where('id_centros_costos', $element['id_centros_costos'])
                ->where('id_solicitudes_compra', $solicitudesCompra->id)
                ->exists();

            if ($existingElement) {
                return back()->withErrors([
                    'error' => 'El elemento con Nivel Tres "' . $element['id_niveles_tres'] . 
                    '" y Centro de Costos "' . $element['id_centros_costos'] . 
                    '" ya está agregado en esta solicitud.',
                ]);
            }

            $solicitudesCompra->solicitudesElemento()->create([
                'id_niveles_tres' => $element['id_niveles_tres'],
                'id_centros_costos' => $element['id_centros_costos'],
                'cantidad' => $element['cantidad'],
                'estado' => $element['estado'] ?? null,
                'id_solicitudes_compra' => $solicitudesCompra->id,
            ]);
        }

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'Solicitud de compra creada correctamente.');
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();
    
        // Obtener la solicitud de compra con sus relaciones
        $solicitudesCompra = SolicitudesCompra::with([
            'solicitudesElemento.nivelesTres',
            'solicitudesElemento.centrosCosto'
        ])->findOrFail($id);
    
        // Verificar si la solicitud pertenece al usuario autenticado
        if ($solicitudesCompra->id_users !== auth()->id()) {
            // Filtrar los elementos de la solicitud por niveles permitidos
            $solicitudesCompra->solicitudesElemento = $solicitudesCompra->solicitudesElemento->filter(function ($elemento) use ($nivelesUnoIds) {
                return in_array($elemento->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
            });
    
            // Si no hay elementos visibles, lanzar un 404
            if ($solicitudesCompra->solicitudesElemento->isEmpty()) {
                abort(404, 'No autorizado para acceder a esta solicitud.');
            }
        }
    
        // Verificar la política de acceso
        $this->authorize('view', $solicitudesCompra);
    
        return view('solicitudes-compra.show', compact('solicitudesCompra', 'nivelesUnoIds'));
    }
    

    public function actualizarEstado(Request $request, $id)
    {
        $elemento = SolicitudesElemento::findOrFail($id);
    
        // Obtener los niveles permitidos del usuario
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();
    
        // Verificar si el usuario tiene permiso sobre el nivel del elemento
        if (!in_array($elemento->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds)) {
            return response()->json(['error' => 'No tienes permiso para actualizar este elemento.'], 403);
        }
    
        // Actualizar el estado si tiene permiso
        $elemento->estado = $request->input('estado');
        $elemento->save();
    
        return response()->json(['success' => true]);
    }
    




    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $solicitudesCompra = SolicitudesCompra::find($id);

        return view('solicitudes-compra.edit', compact('solicitudesCompra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SolicitudesCompraRequest $request, SolicitudesCompra $solicitudesCompra): RedirectResponse
    {
        $solicitudesCompra->update($request->validated());

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'Solicitud Compra actualizada exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        SolicitudesCompra::find($id)->delete();

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'Solicitud Compra eliminada exitosamente');
    }
}
