<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $permissions = Permission::paginate();

        return view('permission.index', compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * $permissions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permission = new Permission();

        return view('permission.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web' // Asumimos que usarás el guard 'web' por defecto
        ]);

        return Redirect::route('permissions.index')
            ->with('success', 'Permiso creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $permission = Permission::find($id);

        return view('permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $permission = Permission::find($id);

        return view('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update(['name' => $request->name]);

        return Redirect::route('permissions.index')
            ->with('success', 'Permiso actualizado correctamente');
    }

    public function destroy($id): RedirectResponse
    {
        Permission::find($id)->delete();

        return Redirect::route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}
