<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Impuesto
 *
 * @property $id
 * @property $tipo
 * @property $porcentaje
 * @property $created_at
 * @property $updated_at
 *
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Impuesto extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tipo', 'porcentaje'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesCotizaciones()
    {
        return $this->hasMany(\App\Models\SolicitudesCotizacione::class, 'id', 'id_impuestos');
    }
    
}
