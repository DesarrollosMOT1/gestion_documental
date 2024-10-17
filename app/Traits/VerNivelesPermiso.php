<?php

namespace App\Traits;

use App\Models\NivelesUno;

trait VerNivelesPermiso
{
    public function obtenerNivelesPermitidos()
    {
        // Mapeo de permisos a los nombres de los niveles uno
        $permissions = [
            'ver_nivel_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_nivel_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_nivel_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_nivel_sistemas' => 'SISTEMAS',
            'ver_nivel_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_nivel_dotacion_personal' => 'DOTACION PERSONAL',
        ];

        // Obtener los nombres de los niveles uno permitidos según los permisos del usuario
        $nivelesPermitidos = [];
        foreach ($permissions as $permiso => $nombre) {
            if (auth()->user()->hasPermissionTo($permiso)) {
                $nivelesPermitidos[] = $nombre;
            }
        }

        // Obtener los niveles uno permitidos
        return NivelesUno::whereIn('nombre', $nivelesPermitidos)->pluck('id')->toArray();
    }
}
