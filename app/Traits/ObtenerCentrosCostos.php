<?php

namespace App\Traits;
use App\Models\CentrosCosto;

trait ObtenerCentrosCostos
{
    public function obtenerCentrosCostos()
    {
        // Obtener el área del usuario autenticado
        $user = auth()->user();
        $areaId = $user->id_area;

        // Obtener los centros de costos asociados a las clasificaciones de centros del área del usuario
        $centrosCostos = CentrosCosto::whereIn('id_clasificaciones_centros', function ($query) use ($areaId) {
            $query->select('id_clasificaciones_centros')
                ->from('clasificaciones_centros_areas')
                ->where('id_areas', $areaId);
        })->get();

        return $centrosCostos;
    }
}
