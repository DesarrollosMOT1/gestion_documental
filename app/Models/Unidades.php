<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    protected $perPage = 20;

    protected $fillable = ['nombre'];

    // Relación con los registros
    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class, 'unidad', 'id');
    }

    // Relación con las equivalencias donde la unidad es la unidad principal
    public function equivalencias()
    {
        return $this->hasMany(\App\Models\Equivalencia::class, 'unidad_principal', 'id');
    }

    public function obtenerEquivalencias($unidadId)
    {
        $unidad = $this->find($unidadId);

        if (! $unidad) {
            return null;
        }

        static $visitas = [];

        if (in_array($unidad->id, $visitas)) {
            return [
                'unidad' => $unidad->nombre,
                'equivalencias' => [],
            ];
        }

        $visitas[] = $unidad->id;

        $equivalenciasCadena = [];

        $equivalenciasDirectas = $unidad->equivalencias()->get();

        foreach ($equivalenciasDirectas as $equivalencia) {
            $unidadEquivalente = Unidades::find($equivalencia->unidad_equivalente);

            if ($unidadEquivalente) {
                $existe = false;
                foreach ($equivalenciasCadena as $eqCadena) {
                    if ($eqCadena['unidad_equivalente'] === $unidadEquivalente->nombre) {
                        $existe = true;
                        break;
                    }
                }

                if (! $existe) {
                    $equivalenciasCadena[] = [
                        'unidad_equivalente' => $unidadEquivalente->nombre,
                        'cantidad' => $equivalencia->cantidad,
                    ];
                }
                $equivalenciasDeUnidadEquivalente = $this->obtenerEquivalencias($unidadEquivalente->id);
                foreach ($equivalenciasDeUnidadEquivalente['equivalencias'] as $eq) {
                    $existe = false;
                    foreach ($equivalenciasCadena as $eqCadena) {
                        if ($eqCadena['unidad_equivalente'] === $eq['unidad_equivalente']) {
                            $existe = true;
                            break;
                        }
                    }
                    if (! $existe) {
                        $cantidadMultiplicada = $eq['cantidad'] * $equivalencia->cantidad;
                        $equivalenciasCadena[] = [
                            'unidad_equivalente' => $eq['unidad_equivalente'],
                            'cantidad' => $cantidadMultiplicada,
                        ];
                    }
                }
            }
        }

        return [
            'unidad' => $unidad->nombre,
            'equivalencias' => $equivalenciasCadena,
        ];
    }

    public function nivelTres()
    {
        return $this->hasOne(NivelesTres::class, 'unidad_id');
    }
}
