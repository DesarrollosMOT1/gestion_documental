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
            'ver_nivel_sistemas',
            'ver_nivel_mantenimiento_vehiculo',
            'ver_nivel_implementos_aseo_cafeteria',
            'ver_nivel_utiles_papeleria_fotocopia',
            'ver_nivel_seguridad_salud',
            'ver_nivel_dotacion_personal',
            'ver_consolidaciones_jefe',
            'editar_consolidacion_estado_jefe',
            'editar_consolidacion_estado',
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
            'ver_nivel_solicitud_compra_mantenimiento_vehiculo',
            'ver_nivel_solicitud_compra_utiles_papeleria_fotocopia',
            'ver_nivel_solicitud_compra_implementos_aseo_cafeteria',
            'ver_nivel_solicitud_compra_sistemas',
            'ver_nivel_solicitud_compra_seguridad_salud',
            'ver_nivel_solicitud_compra_dotacion_personal',
            'ver_registro_auditoria',
            'ver_nivel_solicitud_compra_logistica',
            'ver_nivel_logistica'
        ];

        // Crear los permisos si no existen
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
