<?php

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('audit.index');
    }

    /**
     * Devuelve los datos de auditoría en formato JSON para DataTables.
     */
    public function getAudits(): JsonResponse
    {
        $audits = Audit::all()->map(function ($audit) {
            return [
                'id' => $audit->id,
                'user_type' => class_basename($audit->user_type),
                'user_name' => optional($audit->user)->name,
                'created_at' => $audit->created_at->format('d/m/Y H:i:s'),
                'event' => $audit->event,
                'auditable_type' => class_basename($audit->auditable_type),
                'auditable_id' => $audit->auditable_id,
                'old_values' => json_encode($audit->old_values),
                'new_values' => json_encode($audit->new_values),
                'url' => $audit->url,
                'ip_address' => $audit->ip_address,
                'user_agent' => $audit->user_agent,
                'tags' => $audit->tags,
            ];
        });

        return response()->json(['data' => $audits]);
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
