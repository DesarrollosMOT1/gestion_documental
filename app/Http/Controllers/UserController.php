<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $areas = Area::all();
        return view('users.create', compact('roles', 'permissions', 'areas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_area' => 'required|exists:areas,id',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_area' => $request->id_area,
        ]);
    
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);
    
        return redirect()->route('admin.users.index')->with('success', 'Usuario creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $areas = Area::all();
        return view('users.edit', compact('user', 'roles', 'permissions', 'areas'));
    }
    
    public function update(Request $request, User $user)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->email = $request->input('id_area');
    
        if ($request->filled('password') && $request->input('password') !== $request->input('password_confirmation')) {
            // Las contraseñas no coinciden
            return redirect()->back()->with('error', 'Las contraseñas no coinciden')->withInput();
        }
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save();
    
        // Sincroniza roles
        $user->roles()->sync($request->roles);
    
        // Sincroniza permisos
        $user->permissions()->sync($request->permissions);
    
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado con éxito');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}