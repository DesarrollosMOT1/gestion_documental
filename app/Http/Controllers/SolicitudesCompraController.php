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
    
        // Obtener las solicitudes de compra que tienen al menos un SolicitudesElemento relacionado con los NivelesUno permitidos
        $solicitudesCompras = SolicitudesCompra::whereHas('solicitudesElemento.nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
            $query->whereIn('id', $nivelesUnoIds);
        })
        ->whereBetween('fecha_solicitud', [$fechaInicio, $fechaFin])
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
    
        $nivelesUno = NivelesUno::whereIn('id', $this->obtenerNivelesPermitidos())->get();
    
        return view('solicitudes-compra.create', compact('solicitudesCompra', 'nivelesUno', 'centrosCostos'));
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
            // Verificación de duplicados
            $existingElement = SolicitudesElemento::where('id_niveles_tres', $element['id_niveles_tres'])
                ->where('id_centros_costos', $element['id_centros_costos'])
                ->where('id_solicitudes_compra', $solicitudesCompra->id)
                ->exists();

            if ($existingElement) {
                return back()->withErrors(['error' => 'El elemento con id_niveles_tres ' . $element['id_niveles_tres'] . ' y id_centros_costos ' . $element['id_centros_costos'] . ' ya fue agregado.']);
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
    
        // Obtener la solicitud de compra con los elementos filtrados por nivel uno permitido
        $solicitudesCompra = SolicitudesCompra::with(['solicitudesElemento' => function($query) use ($nivelesUnoIds) {
            $query->whereHas('nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
                $query->whereIn('id', $nivelesUnoIds);
            });
        }, 'solicitudesElemento.nivelesTres', 'solicitudesElemento.centrosCosto'])
        ->findOrFail($id);

        $this->authorize('view', $solicitudesCompra);
    
        return view('solicitudes-compra.show', compact('solicitudesCompra'));
    }

    public function actualizarEstado(Request $request, $id)
    {
        $elemento = SolicitudesElemento::findOrFail($id);
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
