<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Traits\PermissionsTrait;
class RoleController extends Controller
{
    use PermissionsTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Obtener todos los roles sin paginación
        $roles = Role::get();
    
        // Iniciar el contador manualmente en 0
        $i = 0;
    
        return view('role.index', compact('roles', 'i'));
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $role = new Role();
        $permisos = Permission::all();

        // Obtener los permisos agrupados desde el trait
        $permissionsGrouped = $this->getPermissionsGrouped();

        return view('role.create', compact('role', 'permisos', 'permissionsGrouped'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web' 
        ]);
        $role->permissions()->sync($request->input('permissions', []));
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    
        return Redirect::route('roles.index')
            ->with('success', 'Rol creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $role = Role::find($id);

        return view('role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $role = Role::findOrFail($id);
        $permisos = Permission::all();
        
        // Obtener los permisos agrupados desde el trait
        $permissionsGrouped = $this->getPermissionsGrouped();

        return view('role.edit', compact('role', 'permisos', 'permissionsGrouped'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->input('permissions', []));
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    
        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        Role::find($id)->delete();

        // Restablecer el caché de permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return Redirect::route('roles.index')
            ->with('success', 'Rol eliminado exitosamente');
    }
}
