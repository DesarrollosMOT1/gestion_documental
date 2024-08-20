<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CentrosCosto
 *
 * @property $codigo
 * @property $nombre
 * @property $id_clasificaciones_centros
 * @property $created_at
 * @property $updated_at
 *
 * @property ClasificacionesCentro $clasificacionesCentro
 * @property SolicitudesElemento[] $solicitudesElementos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CentrosCosto extends Model
{
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['codigo', 'nombre', 'id_clasificaciones_centros'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clasificacionesCentro()
    {
        return $this->belongsTo(\App\Models\ClasificacionesCentro::class, 'id_clasificaciones_centros', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesElementos()
    {
        return $this->hasMany(\App\Models\SolicitudesElemento::class, 'codigo', 'id_centros_costos');
    }
    
}
