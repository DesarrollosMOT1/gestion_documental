<?php

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $audits = Audit::paginate();
    
        foreach ($audits as $audit) {
            $audit->old_values = json_encode($audit->old_values);
            $audit->new_values = json_encode($audit->new_values);
        }
    
        return view('audit.index', compact('audits'))
            ->with('i', ($request->input('page', 1) - 1) * $audits->perPage());
    }

        /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $audit = Audit::find($id);

        return view('audit.show', compact('audit'));
    }
}
