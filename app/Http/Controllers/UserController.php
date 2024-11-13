<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse; 
use Illuminate\Support\Facades\Redirect;
use App\Traits\PermissionsTrait;

class UserController extends Controller
{
    use PermissionsTrait;
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $areas = Area::all();
        
        // Obtener los permisos agrupados desde el trait
        $permissionsGrouped = $this->getPermissionsGrouped();
        
        // Obtener los permisos reales
        $permissions = $this->getPermissions();
    
        return view('users.create', compact('roles', 'permissions', 'areas', 'permissionsGrouped'));
    } 
    
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_area' => $request->id_area,
        ]);
    
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);
    
        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        // Obtener los permisos agrupados desde el trait
        $permissionsGrouped = $this->getPermissionsGrouped();
    
        $areas = Area::all();
        return view('users.edit', compact('user', 'roles', 'permissions', 'areas', 'permissionsGrouped'));
    }
    
    public function update(UserRequest $request, User $user)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->id_area = $request->input('id_area');
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save();
    
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);
    
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();

        return Redirect::route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}
