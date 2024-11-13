<?php

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Rango de fechas por defecto (últimos 14 días)
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->subDays(14)->startOfDay()->toDateTimeString());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfDay()->toDateTimeString());
    
        // Filtrar registros de auditoría en el rango de fechas, sin paginar
        $audits = Audit::whereBetween('created_at', [$fechaInicio, $fechaFin])->get();
    
        // Convertir los valores antiguos y nuevos a JSON
        foreach ($audits as $audit) {
            $audit->old_values = json_encode($audit->old_values);
            $audit->new_values = json_encode($audit->new_values);
        }
    
        // Iniciar el contador manualmente en 0
        $i = 0;
    
        return view('audit.index', compact('audits', 'i'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $audit = Audit::findOrFail($id);
        $audit->old_values = json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $audit->new_values = json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
        return view('audit.show', compact('audit'));
    }
}
