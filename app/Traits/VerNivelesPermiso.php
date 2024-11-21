<?php

namespace App\Traits;

use App\Models\NivelesUno;

trait VerNivelesPermiso
{
    public function nivelesPermitidos(array $permissions): array
    {
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

    /**
     * Niveles permitidos para Solicitud de Compra.
     * 
     * @return array Lista de IDs de niveles permitidos para Solicitud de Compra.
     */
    public function obtenerNivelesPermitidosSolicitudCompra(): array
    {
        $permissions = [
            'ver_nivel_solicitud_compra_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_nivel_solicitud_compra_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_nivel_solicitud_compra_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_nivel_solicitud_compra_sistemas' => 'SISTEMAS',
            'ver_nivel_solicitud_compra_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_nivel_solicitud_compra_dotacion_personal' => 'DOTACION PERSONAL',
            'ver_nivel_solicitud_compra_logistica' => 'LOGISTICA',
        ];

        return $this->nivelesPermitidos($permissions);
    }

    /**
     * Niveles permitidos para otros usos generales.
     * 
     * @return array Lista de IDs de niveles permitidos para otros usos.
     */
    public function obtenerNivelesPermitidos(): array
    {
        $permissions = [
            'ver_nivel_mantenimiento_vehiculo' => 'MANTENIMIENTO VEHICULO',
            'ver_nivel_utiles_papeleria_fotocopia' => 'UTILES, PAPELERIA Y FOTOCOPIA',
            'ver_nivel_implementos_aseo_cafeteria' => 'IMPLEMENTOS DE ASEO Y CAFETERIA',
            'ver_nivel_sistemas' => 'SISTEMAS',
            'ver_nivel_seguridad_salud' => 'SEGURIDAD Y SALUD',
            'ver_nivel_dotacion_personal' => 'DOTACION PERSONAL',
            'ver_nivel_logistica' => 'LOGISTICA',
        ];

        return $this->nivelesPermitidos($permissions);
    }
}
