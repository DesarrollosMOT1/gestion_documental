<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClasificacionesCentro
 *
 * @property $id
 * @property $nombre
 * @property $id_areas
 * @property $created_at
 * @property $updated_at
 *
 * @property Area $area
 * @property CentrosCosto[] $centrosCostos
 * @property NivelesUno[] $nivelesUnos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ClasificacionesCentro extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'id_areas'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'id_areas', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function centrosCostos()
    {
        return $this->hasMany(\App\Models\CentrosCosto::class, 'id', 'id_clasificaciones_centros');
    }
    
    
}
