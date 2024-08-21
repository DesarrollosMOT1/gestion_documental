<?php

namespace App\Http\Controllers;

use App\Models\Consolidacione;
use App\Models\SolicitudesElemento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ConsolidacioneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ConsolidacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $consolidaciones = Consolidacione::paginate();

        return view('consolidacione.index', compact('consolidaciones'))
            ->with('i', ($request->input('page', 1) - 1) * $consolidaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $consolidacione = new Consolidacione();

        return view('consolidacione.create', compact('consolidacione'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsolidacioneRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $elementos = $request->input('elementos', []);
    
        foreach ($elementos as $elemento) {
            Consolidacione::create([
                'user_id' => auth()->id(),
                'id_solicitudes_compras' => $elemento['id_solicitudes_compras'],
                'id_solicitud_elemento' => $elemento['id_solicitud_elemento'],
                'estado' => 0,
                'cantidad' => $elemento['cantidad'],
            ]);
        }
    
        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'Consolidación creada exitosamente.');
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
        $consolidacione = Consolidacione::find($id);

        return view('consolidacione.show', compact('consolidacione'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $consolidacione = Consolidacione::find($id);

        return view('consolidacione.edit', compact('consolidacione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsolidacioneRequest $request, Consolidacione $consolidacione): RedirectResponse
    {
        $consolidacione->update($request->validated());

        return Redirect::route('consolidaciones.index')
            ->with('success', 'Consolidacione updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Consolidacione::find($id)->delete();

        return Redirect::route('consolidaciones.index')
            ->with('success', 'Consolidacione deleted successfully');
    }
}
