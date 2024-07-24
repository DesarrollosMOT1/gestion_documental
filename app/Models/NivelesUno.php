<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NivelesUno
 *
 * @property $id
 * @property $nombre
 * @property $id_clasificaciones_centros
 * @property $created_at
 * @property $updated_at
 *
 * @property ClasificacionesCentro $clasificacionesCentro
 * @property NivelesDo[] $nivelesDos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class NivelesUno extends Model
{
    protected $table = 'niveles_uno';
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'id_clasificaciones_centros'];


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
    public function nivelesDos()
    {
        return $this->hasMany(\App\Models\NivelesDos::class, 'id', 'id_niveles_uno');
    }
    
}
