<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Lista de permisos a crear
        $permisos = [
            'ver_sistemas',
            'ver_mantenimiento_vehiculo',
            'ver_implementos_aseo_cafeteria',
            'ver_utiles_papeleria_fotocopia',
            'ver_seguridad_salud',
            'ver_dotacion_personal',
            'ver_consolidaciones_jefe',
            'editar_consolidacion_estado_jefe',
            'editar_consolidacion_estado',
        ];

        // Crear los permisos si no existen
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
