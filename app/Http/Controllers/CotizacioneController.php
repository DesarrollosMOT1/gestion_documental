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
use App\Models\Tercero;

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
        $cotizacione = Cotizacione::find($id);

        return view('cotizacione.show', compact('cotizacione'));
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
            ->with('success', 'Cotizacione updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Cotizacione::find($id)->delete();

        return Redirect::route('cotizaciones.index')
            ->with('success', 'Cotizacione deleted successfully');
    }
}
