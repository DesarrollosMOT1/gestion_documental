<?php

namespace App\Http\Controllers;

use App\Models\OrdenesCompra;
use App\Models\OrdenesCompraCotizacione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrdenesCompraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Traits\VerNivelesPermiso;

class OrdenesCompraController extends Controller
{
    use VerNivelesPermiso;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        $ordenesCompras = OrdenesCompra::whereHas('ordenesCompraCotizaciones.solicitudesElemento.nivelesTres.nivelesDos.nivelesUno', function($query) use($nivelesUnoIds){
            $query->whereIn('id', $nivelesUnoIds);
        })
        ->with('ordenesCompraCotizaciones.solicitudesElemento')
        ->paginate();

        return view('ordenes-compra.index', compact('ordenesCompras'))
            ->with('i', ($request->input('page', 1) - 1) * $ordenesCompras->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ordenesCompra = new OrdenesCompra();

        return view('ordenes-compra.create', compact('ordenesCompra'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrdenesCompraRequest $request): RedirectResponse
    {
        // Los datos ya están validados por el middleware
        $data = $request->validated();
        $cotizaciones = $request->input('cotizaciones');
    
        // Obtener las IDs de consolidaciones que ya tienen órdenes de compra asociadas
        $consolidacionesEnOrdenes = OrdenesCompraCotizacione::pluck('id_consolidaciones')->toArray();
    
        // Filtrar cotizaciones que no tienen órdenes de compra asociadas
        $cotizacionesFiltradas = array_filter($cotizaciones, function($cotizacion) use ($consolidacionesEnOrdenes) {
            return !in_array($cotizacion['id_consolidaciones'], $consolidacionesEnOrdenes);
        });
    
        // Agrupar cotizaciones por tercero
        $cotizacionesPorTercero = [];
        foreach ($cotizacionesFiltradas as $cotizacion) {
            $idTercero = $cotizacion['id_terceros'];
            if (!isset($cotizacionesPorTercero[$idTercero])) {
                $cotizacionesPorTercero[$idTercero] = [];
            }
            $cotizacionesPorTercero[$idTercero][] = $cotizacion;
        }
    
        // Crear una orden de compra por cada tercero
        foreach ($cotizacionesPorTercero as $idTercero => $cotizacionesDelTercero) {
            // Crear la orden de compra
            $ordenCompra = OrdenesCompra::create([
                'fecha_emision' => $data['fecha_emision'],
                'id_terceros' => $idTercero
            ]);
    
            // Crear las cotizaciones relacionadas
            foreach ($cotizacionesDelTercero as $cotizacion) {
                OrdenesCompraCotizacione::create([
                    'id_ordenes_compras' => $ordenCompra->id,
                    'id_solicitudes_cotizaciones' => $cotizacion['id_solicitudes_cotizaciones'],
                    'id_consolidaciones_oferta' => $cotizacion['id_consolidaciones_oferta'],
                    'id_solicitud_elemento' => $cotizacion['id_solicitud_elemento'],
                    'id_cotizaciones_precio' => $cotizacion['id_cotizaciones_precio'],
                    'id_consolidaciones' => $cotizacion['id_consolidaciones']
                ]);
            }
        }
    
        return Redirect::route('ordenes-compras.index')
            ->with('success', 'Órdenes de Compra creadas exitosamente.');
    }       

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $ordenesCompra = OrdenesCompra::with([
            'tercero',
            'ordenesCompraCotizaciones.solicitudesElemento.nivelesTres',
            'ordenesCompraCotizaciones.solicitudesCotizacione.cotizacione',
            'ordenesCompraCotizaciones.cotizacionesPrecio',
            'ordenesCompraCotizaciones.consolidacione.solicitudesCompra',
        ])->findOrFail($id);

        return view('ordenes-compra.show', compact('ordenesCompra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $ordenesCompra = OrdenesCompra::find($id);

        return view('ordenes-compra.edit', compact('ordenesCompra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrdenesCompraRequest $request, OrdenesCompra $ordenesCompra): RedirectResponse
    {
        $ordenesCompra->update($request->validated());

        return Redirect::route('ordenes-compras.index')
            ->with('success', 'Orden de Compra actualizada exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        OrdenesCompra::find($id)->delete();

        return Redirect::route('ordenes-compras.index')
            ->with('success', 'OrdenesCompra eliminada exitosamente');
    }
}
