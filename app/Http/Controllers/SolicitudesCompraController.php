<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SolicitudesCompra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudesCompraRequest;
use App\Models\AgrupacionesConsolidacione;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\CentrosCosto;
use App\Models\NivelesUno;
use App\Models\NivelesDos;
use App\Models\NivelesTres;
use App\Models\SolicitudesElemento;
use App\Models\Impuesto;
use App\Models\Cotizacione;
use App\Models\Tercero;

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
        // Mapeo de permisos a los nombres de los niveles uno
        $permissions = [
            'ver_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_sistemas' => 'SISTEMAS',
            'ver_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_dotacion_personal' => 'DOTACION PERSONAL',
        ];
    
        // Obtener los nombres de los niveles uno permitidos según los permisos del usuario
        $nivelesPermitidos = [];
        foreach ($permissions as $permiso => $nombre) {
            if (auth()->user()->hasPermissionTo($permiso)) {
                $nivelesPermitidos[] = $nombre;
            }
        }
    
        // Obtener los niveles uno permitidos
        $nivelesUnoIds = NivelesUno::whereIn('nombre', $nivelesPermitidos)->pluck('id')->toArray();
    
        // Obtener las solicitudes de compra que tienen al menos un SolicitudesElemento relacionado con los NivelesUno permitidos
        $solicitudesCompras = SolicitudesCompra::whereHas('solicitudesElemento.nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
            $query->whereIn('id', $nivelesUnoIds);
        })
        ->with('solicitudesElemento')
        ->paginate();
    
        $fechaActual = Carbon::now()->toDateString();
        $users = User::all();
        $agrupacionesConsolidacione = new AgrupacionesConsolidacione();
    
        return view('solicitudes-compra.index', compact('solicitudesCompras', 'fechaActual', 'users', 'agrupacionesConsolidacione'))
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
        $fechaActual = Carbon::now()->toDateString();
    
        // Obtener el área del usuario autenticado
        $user = auth()->user();
        $areaId = $user->id_area;
    
        // Obtener los centros de costos asociados a las clasificaciones de centros del área del usuario
        $centrosCostos = CentrosCosto::whereIn('id_clasificaciones_centros', function ($query) use ($areaId) {
            $query->select('id_clasificaciones_centros')
                  ->from('clasificaciones_centros_areas')
                  ->where('id_areas', $areaId);
        })->get();
    
        // Mapeo de permisos a los nombres de los niveles uno
        $permissions = [
            'ver_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_sistemas' => 'SISTEMAS',
            'ver_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_dotacion_personal' => 'DOTACION PERSONAL',
        ];
    
        // Obtener los nombres de los niveles uno según los permisos del usuario
        $nivelesPermitidos = [];
        foreach ($permissions as $permiso => $nombre) {
            if (auth()->user()->hasPermissionTo($permiso)) {
                $nivelesPermitidos[] = $nombre;
            }
        }
    
        // Obtener los niveles uno con base en los permisos del usuario
        $nivelesUno = NivelesUno::whereIn('nombre', $nivelesPermitidos)->get();
    
        return view('solicitudes-compra.create', compact('solicitudesCompra', 'users', 'nivelesUno', 'centrosCostos', 'fechaActual'));
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
            $solicitudesCompra->solicitudesElemento()->create([
                'id_niveles_tres' => $element['id_niveles_tres'],
                'id_centros_costos' => $element['id_centros_costos'],
                'cantidad' => $element['cantidad'],
                'estado' => $element['estado'] ?? null,
                'id_solicitudes_compra' => $solicitudesCompra->id,
            ]);
        }

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'Solicitud Compra creada creada.');
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        // Mapeo de permisos a los nombres de los niveles uno
        $permissions = [
            'ver_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_sistemas' => 'SISTEMAS',
            'ver_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_dotacion_personal' => 'DOTACION PERSONAL',
        ];
    
        // Obtener los nombres de los niveles uno permitidos según los permisos del usuario
        $nivelesPermitidos = [];
        foreach ($permissions as $permiso => $nombre) {
            if (auth()->user()->hasPermissionTo($permiso)) {
                $nivelesPermitidos[] = $nombre;
            }
        }
    
        // Obtener los niveles uno permitidos
        $nivelesUnoIds = NivelesUno::whereIn('nombre', $nivelesPermitidos)->pluck('id')->toArray();
    
        // Obtener la solicitud de compra con los elementos filtrados por nivel uno permitido
        $solicitudesCompra = SolicitudesCompra::with(['solicitudesElemento' => function($query) use ($nivelesUnoIds) {
            $query->whereHas('nivelesTres.nivelesDos.nivelesUno', function($query) use ($nivelesUnoIds) {
                $query->whereIn('id', $nivelesUnoIds);
            });
        }, 'solicitudesElemento.nivelesTres', 'solicitudesElemento.centrosCosto'])
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
            ->with('success', 'Solicitud Compra actualizada exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        SolicitudesCompra::find($id)->delete();

        return Redirect::route('solicitudes-compras.index')
            ->with('success', 'Solicitud Compra eliminada exitosamente');
    }
}
