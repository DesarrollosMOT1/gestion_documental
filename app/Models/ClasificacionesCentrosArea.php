<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClasificacionesCentrosArea
 *
 * @property $id
 * @property $id_clasificaciones_centros
 * @property $id_areas
 * @property $created_at
 * @property $updated_at
 *
 * @property Area $area
 * @property ClasificacionesCentro $clasificacionesCentro
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ClasificacionesCentrosArea extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_clasificaciones_centros', 'id_areas'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'id_areas', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clasificacionesCentro()
    {
        return $this->belongsTo(\App\Models\ClasificacionesCentro::class, 'id_clasificaciones_centros', 'id');
    }
    
}
