<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesCompra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudesCompraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\CentrosCosto;
use App\Models\NivelesUno;
use App\Models\NivelesDos;
use App\Models\NivelesTres;
use App\Models\SolicitudCompra;
use App\Models\SolicitudesElemento;
use App\Models\Impuesto;

class SolicitudesCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private function generatePrefix(): string
    {
        $month = strtoupper(date('M')); // Obtiene las primeras tres letras del mes actual (Jun, Jul, etc.)
        $year = date('y'); // Obtiene los últimos dos dígitos del año actual (24 para 2024)
        return $month . $year;
    }
    
    public function index(Request $request): View
    {
        $solicitudesCompras = SolicitudesCompra::paginate();

        $impuestos = Impuesto::all();

        return view('solicitudes-compra.index', compact('solicitudesCompras', 'impuestos'))
            ->with('i', ($request->input('page', 1) - 1) * $solicitudesCompras->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $solicitudesCompra = new SolicitudesCompra();
        $solicitudesCompra->prefijo = $this->generatePrefix();
        $users = User::all();
        $nivelesUno = NivelesUno::all(); // Obtener todos los niveles uno
        $centrosCostos = CentrosCosto::all();
    
        return view('solicitudes-compra.create', compact('solicitudesCompra', 'users', 'nivelesUno', 'centrosCostos'));
    }
    
    public function getNivelesDos($idNivelUno)
    {
        $nivelesDos = NivelesDos::where('id_niveles_uno', $idNivelUno)->get();
        return response()->json($nivelesDos);
    }

    public function getNivelesTres($idNivelDos)
    {
        $nivelesTres = NivelesTres::where('id_niveles_dos', $idNivelDos)->get();
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
            $solicitudesCompra->solicitudesElementos()->create([
                'id_niveles_tres' => $element['id_niveles_tres'],
                'id_centros_costos' => $element['id_centros_costos'],
                'cantidad' => $element['cantidad'],
                'estado' => $element['estado'] ?? null,
                'id_solicitudes_compra' => $solicitudesCompra->id,
            ]);
        }

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'SolicitudesCompra created successfully.');
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $solicitudesCompra = SolicitudesCompra::with('solicitudesElemento.nivelesTres', 'solicitudesElemento.centrosCosto')
                                            ->findOrFail($id);
    
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
            ->with('success', 'SolicitudesCompra updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        SolicitudesCompra::find($id)->delete();

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'SolicitudesCompra deleted successfully');
    }
}
