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

class SolicitudesOfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $solicitudesOfertas = SolicitudesOferta::paginate();

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
        $solicitudOferta = SolicitudesOferta::create($request->validated());
    
        // Guardar los elementos asociados a la solicitud de oferta
        $elementos = $request->input('elementos', []);
    
        foreach ($elementos as $elemento) {
            ConsolidacionesOferta::create([
                'id_solicitudes_compras' => $elemento['id_solicitudes_compras'],
                'id_solicitud_elemento' => $elemento['id_solicitud_elemento'],
                'id_consolidaciones' => $elemento['id_consolidaciones'],
                'id_solicitudes_ofertas' => $solicitudOferta->id,
                'estado' => $elemento['estado'],
                'cantidad' => $elemento['cantidad'],
            ]);
        }
    
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
            ->where('estado', '1')
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
            'tercero', 
            'consolidacionesOfertas.solicitudesCompra', 
            'consolidacionesOfertas.solicitudesElemento.nivelesTres'
        ])->findOrFail($id);
    
        return view('solicitudes-oferta.show', compact('solicitudesOferta'));
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
