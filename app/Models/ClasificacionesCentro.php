<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClasificacionesCentro
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property CentrosCosto[] $centrosCostos
 * @property NivelesUno[] $nivelesUnos
 * @property Area[] $areas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ClasificacionesCentro extends Model
{
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function centrosCostos()
    {
        return $this->hasMany(\App\Models\CentrosCosto::class, 'id', 'id_clasificaciones_centros');
    }

    /**
     * Relación de muchos a muchos con Area a través de ClasificacionesCentrosArea.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'clasificaciones_centros_areas', 'id_clasificaciones_centros', 'id_areas');
    }    
}
