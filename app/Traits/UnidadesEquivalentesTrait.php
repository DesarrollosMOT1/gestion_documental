<?php

namespace App\Traits;
use Illuminate\Support\Collection;
use App\Models\Unidades;

trait UnidadesEquivalentesTrait
{
    /**
     * Procesa y formatea las equivalencias de unidades para un elemento
     * 
     * @param mixed $elemento El elemento (solicitud, consolidación, etc.) que tiene una unidad
     * @param Unidades $unidadesModel Instancia del modelo de Unidades
     * @return array|null Información de la unidad con equivalencias
     */
    protected function procesarUnidadEquivalente($elemento, $unidadesModel)
    {
        // Verificar si el elemento tiene niveles tres y unidad
        if (!$elemento->nivelesTres || !$elemento->nivelesTres->unidades) {
            return null;
        }

        $unidad = $elemento->nivelesTres->unidades;
        
        // Obtener equivalencias
        $equivalencias = $unidadesModel->obtenerEquivalencias($unidad->id);
        
        // Formatear equivalencias
        $equivalenciasTexto = $this->formatearEquivalencias($equivalencias['equivalencias'], $elemento->cantidad);

        return [
            'nombre' => $unidad->nombre,
            'equivalencias' => $equivalenciasTexto
        ];
    }

    /**
     * Formatea las equivalencias de unidades
     * 
     * @param array $equivalencias Lista de equivalencias
     * @param float $cantidadOriginal Cantidad original del elemento
     * @return string Texto de equivalencias formateado
     */
    protected function formatearEquivalencias($equivalencias, $cantidadOriginal)
    {
        if (empty($equivalencias)) {
            return '';
        }

        return collect($equivalencias)
            ->map(function($eq) use ($cantidadOriginal) {
                // Calcular la cantidad equivalente
                $cantidadCalculada = $cantidadOriginal * $eq['cantidad'];
                
                // Formatear la cantidad
                $cantidadFormateada = number_format($cantidadCalculada, 2);
                $cantidadFormateada = rtrim(rtrim($cantidadFormateada, '0'), '.');
                
                return "{$cantidadFormateada} {$eq['unidad_equivalente']}";
            })
            ->implode(', ');
    }

    /**
     * Procesa una colección de elementos agregando información de unidades
     * 
     * @param mixed $elementos Colección de elementos
     * @param Unidades $unidadesModel Instancia del modelo de Unidades
     * @return mixed Colección de elementos con información de unidades
     */
    protected function procesarUnidadesElementos($elementos, $unidadesModel)
    {
        return $elementos->map(function ($elemento) use ($unidadesModel) {
            // Si el elemento ya tiene información de unidad, no lo modificamos
            if (isset($elemento->unidad_info)) {
                return $elemento;
            }

            // Procesar unidad equivalente
            $unidadInfo = $this->procesarUnidadEquivalente($elemento, $unidadesModel);
            
            // Agregar información de unidad al elemento
            if ($unidadInfo) {
                $elemento->unidad_info = $unidadInfo;
            }

            return $elemento;
        });
    }

    /**
     * Prepara un listado de unidades con sus equivalencias para formularios
     * 
     * @param Unidades $unidadesModel Instancia del modelo de Unidades
     * @return Collection Colección de unidades con información de equivalencias
     */
    protected function prepararUnidadesConEquivalencias($unidadesModel)
    {
        return Unidades::all()->map(function($unidad) use ($unidadesModel) {
            $equivalencias = $unidadesModel->obtenerEquivalencias($unidad->id);
            $equivalenciasTexto = collect($equivalencias['equivalencias'])
                ->map(function($eq) {
                    return "{$eq['cantidad']} {$eq['unidad_equivalente']}";
                })
                ->implode(', ');
                
            $unidad->nombre_completo = $unidad->nombre . ($equivalenciasTexto ? " ($equivalenciasTexto)" : '');
            return $unidad;
        });
    }

    protected function procesarUnidadesConsolidaciones($consolidaciones, $unidadesModel)
    {
        return $consolidaciones->each(function ($consolidacion) use ($unidadesModel) {
            if (!$consolidacion->solicitudesElemento?->nivelesTres?->unidades) {
                return;
            }

            $unidad = $consolidacion->solicitudesElemento->nivelesTres->unidades;
            $equivalencias = $unidadesModel->obtenerEquivalencias($unidad->id);
            
            // Formatear equivalencias con la cantidad de la consolidación
            $equivalenciasTexto = $this->formatearEquivalencias(
                $equivalencias['equivalencias'], 
                $consolidacion->cantidad
            );

            // Si no hay equivalencias, mostrar al menos la unidad principal
            if (empty($equivalenciasTexto)) {
                $equivalenciasTexto = "{$consolidacion->cantidad} {$unidad->nombre}";
            }

            $consolidacion->unidad_info = [
                'nombre' => $unidad->nombre,
                'equivalencias' => $equivalenciasTexto
            ];
        });
    }

    protected function procesarElementosMultiples($elementos, $unidadesModel)
    {
        return $elementos->map(function ($elemento) use ($unidadesModel) {
            $unidadInfo = null;
            $equivalenciasData = [];
            
            if ($elemento->nivelesTres?->unidades) {
                $equivalencias = $unidadesModel->obtenerEquivalencias($elemento->nivelesTres->unidades->id);
                $unidadInfo = [
                    'nombre' => $elemento->nivelesTres->unidades->nombre,
                    'equivalencias' => $this->formatearEquivalencias(
                        $equivalencias['equivalencias'],
                        $elemento->cantidad
                    )
                ];
                $equivalenciasData = $equivalencias['equivalencias'];
            }

            return array_merge($elemento->toArray(), [
                'unidad_info' => $unidadInfo,
                'equivalencias' => $equivalenciasData
            ]);
        });
    }
}
