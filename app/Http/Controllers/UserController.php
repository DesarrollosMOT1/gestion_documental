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

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $areas = Area::all();
    
        // Agrupar permisos por categorías
        $permissionsGrouped = [
            'Niveles' => [
                'ver_nivel_sistemas',
                'ver_nivel_mantenimiento_vehiculo',
                'ver_nivel_implementos_aseo_cafeteria',
                'ver_nivel_utiles_papeleria_fotocopia',
                'ver_nivel_seguridad_salud',
                'ver_nivel_dotacion_personal',
            ],
            'Consolidaciones' => [
                'ver_consolidaciones_jefe',
                'editar_consolidacion_estado_jefe',
                'editar_consolidacion_estado',
            ],
            'Interfaz' => [
                'ver_administracion_usuarios',
                'ver_administracion_roles',
                'ver_administracion_areas',
                'ver_administracion_permisos',
                'ver_solicitudes_compras',
                'ver_consolidaciones',
                'ver_solicitudes_ofertas',
                'ver_cotizaciones',
                'ver_ordenes_compras',
                'ver_clasificaciones_centros',
                'ver_entrada_inventario',
                'ver_niveles_jerarquicos',
                'ver_referencias_gastos',
                'ver_centros_costos',
                'ver_terceros',
                'ver_impuestos',
                'ver_solicitudes_usuario_autentificado',
                'ver_registro_auditoria',
            ],
            'Niveles de la solicitud de compra' => [
                'ver_nivel_solicitud_compra_mantenimiento_vehiculo',
                'ver_nivel_solicitud_compra_utiles_papeleria_fotocopia',
                'ver_nivel_solicitud_compra_implementos_aseo_cafeteria',
                'ver_nivel_solicitud_compra_sistemas',
                'ver_nivel_solicitud_compra_seguridad_salud',
                'ver_nivel_solicitud_compra_dotacion_personal',
            ],
        ];
    
        // Obtener los permisos reales
        $permissions = Permission::whereIn('name', array_merge(...array_values($permissionsGrouped)))->get();
    
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
        // Agrupar permisos por categorías
        $permissionsGrouped = [
            'Niveles' => [
                'ver_nivel_sistemas',
                'ver_nivel_mantenimiento_vehiculo',
                'ver_nivel_implementos_aseo_cafeteria',
                'ver_nivel_utiles_papeleria_fotocopia',
                'ver_nivel_seguridad_salud',
                'ver_nivel_dotacion_personal',
            ],
            'Consolidaciones' => [
                'ver_consolidaciones_jefe',
                'editar_consolidacion_estado_jefe',
                'editar_consolidacion_estado',
            ],
            'Interfaz' => [
                'ver_administracion_usuarios',
                'ver_administracion_roles',
                'ver_administracion_areas',
                'ver_administracion_permisos',
                'ver_solicitudes_compras',
                'ver_consolidaciones',
                'ver_solicitudes_ofertas',
                'ver_cotizaciones',
                'ver_ordenes_compras',
                'ver_clasificaciones_centros',
                'ver_entrada_inventario',
                'ver_niveles_jerarquicos',
                'ver_referencias_gastos',
                'ver_centros_costos',
                'ver_terceros',
                'ver_impuestos',
                'ver_solicitudes_usuario_autentificado',
                'ver_registro_auditoria',
            ],
            'Niveles de la solicitud de compra' => [
                'ver_nivel_solicitud_compra_mantenimiento_vehiculo',
                'ver_nivel_solicitud_compra_utiles_papeleria_fotocopia',
                'ver_nivel_solicitud_compra_implementos_aseo_cafeteria',
                'ver_nivel_solicitud_compra_sistemas',
                'ver_nivel_solicitud_compra_seguridad_salud',
                'ver_nivel_solicitud_compra_dotacion_personal',
            ],
        ];

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
