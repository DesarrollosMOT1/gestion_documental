<?php

namespace App\Http\Controllers;

use App\Models\SolicitudCompra;
use App\Models\CentroCosto;
use App\Models\ReferenciaGasto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudCompraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SolicitudCompraController extends Controller
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
        $solicitudCompras = SolicitudCompra::paginate();

        return view('solicitud-compra.index', compact('solicitudCompras'))
            ->with('i', ($request->input('page', 1) - 1) * $solicitudCompras->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $solicitudCompra = new SolicitudCompra();
        $solicitudCompra->prefijo = $this->generatePrefix();

        $centro_costo = CentroCosto::all();
        $referencia_gasto = ReferenciaGasto::all();
        $usuarios = User::all();

        return view('solicitud-compra.create', compact('solicitudCompra', 'centro_costo', 'referencia_gasto', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SolicitudCompraRequest $request): RedirectResponse
    {
        SolicitudCompra::create($request->validated());

        return Redirect::route('solicitud-compras.index')
            ->with('success', 'Solicitud de Compra creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $solicitudCompra = SolicitudCompra::find($id);

        return view('solicitud-compra.show', compact('solicitudCompra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $solicitudCompra = SolicitudCompra::find($id);

        $centro_costo = CentroCosto::all();
        $referencia_gasto = ReferenciaGasto::all();
        $usuarios = User::all();

        return view('solicitud-compra.edit', compact('solicitudCompra', 'centro_costo', 'referencia_gasto', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SolicitudCompraRequest $request, SolicitudCompra $solicitudCompra): RedirectResponse
    {
        $solicitudCompra->update($request->validated());

        return Redirect::route('solicitud-compras.index')
            ->with('success', 'Solicitud de Compra actualizada correctamente');
    }

    public function destroy($id): RedirectResponse
    {
        SolicitudCompra::find($id)->delete();

        return Redirect::route('solicitud-compras.index')
            ->with('success', 'Solicitud de Compra eliminada correctamente');
    }
}
