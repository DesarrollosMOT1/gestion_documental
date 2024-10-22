<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesOferta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudesOfertaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\ConsolidacionesOferta;
use App\Models\Consolidacione;
use App\Models\Cotizacione;
use App\Models\SolicitudOfertaTercero;
use Barryvdh\DomPDF\Facade\Pdf;

class SolicitudesOfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $solicitudesOfertas = SolicitudesOferta::with('terceros')->paginate();
    
        return view('solicitudes-oferta.index', compact('solicitudesOfertas'))
            ->with('i', ($request->input('page', 1) - 1) * $solicitudesOfertas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $solicitudesOferta = new SolicitudesOferta();

        return view('solicitudes-oferta.create', compact('solicitudesOferta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SolicitudesOfertaRequest $request): RedirectResponse
    {
        // Crear la solicitud de oferta utilizando los datos validados
        $solicitudOferta = SolicitudesOferta::create($request->validated());

        // Guardar los elementos asociados a la solicitud de oferta
        $elementos = $request->input('elementos', []);
        // Guardar los terceros asociados a la solicitud de oferta
        $terceros = $request->input('terceros', []);

        // Guardar terceros
        foreach ($terceros as $terceroId) {
            SolicitudOfertaTercero::create([
                'solicitudes_ofertas_id' => $solicitudOferta->id,
                'tercero_id' => $terceroId,
            ]);
        }

        // Guardar elementos de la solicitud
        foreach ($elementos as $elemento) {
            ConsolidacionesOferta::create([
                'id_solicitudes_compras' => $elemento['id_solicitudes_compras'],
                'id_solicitud_elemento' => $elemento['id_solicitud_elemento'],
                'id_consolidaciones' => $elemento['id_consolidaciones'],
                'id_solicitudes_ofertas' => $solicitudOferta->id,
                'cantidad' => $elemento['cantidad'],
            ]);
        }

        // Redireccionar con un mensaje de éxito
        return Redirect::route('solicitudes-ofertas.index')
            ->with('success', 'Solicitud de oferta creada exitosamente.');
    }

    public function getConsolidacionesDetalles(Request $request)
    {
        $consolidacionesIds = $request->input('consolidaciones', []);
        $consolidaciones = Consolidacione::with([
            'solicitudesCompra',
            'solicitudesElemento.nivelesTres'
        ])
            ->whereIn('id', $consolidacionesIds)
            ->get();
    
        return response()->json($consolidaciones);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $solicitudesOferta = SolicitudesOferta::with([
            'user', 
            'terceros', 
            'consolidacionesOfertas.solicitudesCompra', 
            'consolidacionesOfertas.solicitudesElemento.nivelesTres',
            'consolidacionesOfertas.solicitudesCotizaciones.cotizacione' // Cargar cotizaciones relacionadas
        ])->findOrFail($id);
    
        $cotizacione = new Cotizacione();
        $tercerosSinCotizacion = $solicitudesOferta->getTercerosSinCotizacion();
        
        // Obtener todas las cotizaciones relacionadas
        $cotizacionesRelacionadas = $solicitudesOferta->consolidacionesOfertas
            ->flatMap(function ($consolidacion) {
                return $consolidacion->solicitudesCotizaciones->pluck('cotizacione');
            })->unique('id');
    
        return view('solicitudes-oferta.show', compact('solicitudesOferta', 'cotizacione', 'tercerosSinCotizacion', 'cotizacionesRelacionadas'));
    }    

    public function downloadPdf($id, $terceroId)
    {
        $solicitudesOferta = SolicitudesOferta::with([
            'user', 
            'terceros',
            'consolidacionesOfertas.solicitudesCompra', 
            'consolidacionesOfertas.solicitudesElemento.nivelesTres'
        ])->findOrFail($id);
    
        $tercero = $solicitudesOferta->terceros->where('id', $terceroId)->first();

    
        if (!$tercero) {
            abort(404, 'Tercero no encontrado.');
        }

        $i = 0;
    
        $pdf = Pdf::loadView('solicitudes-oferta.pdf', compact('solicitudesOferta', 'tercero', 'i'));
        return $pdf->stream('solicitud-oferta-' . $solicitudesOferta->id . '-tercero-' . $tercero->nit . '.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $solicitudesOferta = SolicitudesOferta::find($id);

        return view('solicitudes-oferta.edit', compact('solicitudesOferta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SolicitudesOfertaRequest $request, SolicitudesOferta $solicitudesOferta): RedirectResponse
    {
        $solicitudesOferta->update($request->validated());

        return Redirect::route('solicitudes-ofertas.index')
            ->with('success', 'SolicitudesOferta updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        SolicitudesOferta::find($id)->delete();

        return Redirect::route('solicitudes-ofertas.index')
            ->with('success', 'SolicitudesOferta deleted successfully');
    }
}
