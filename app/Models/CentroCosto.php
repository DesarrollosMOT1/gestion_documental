<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CentroCosto
 *
 * @property $codigo
 * @property $nombre
 *
 * @property SolicitudCompra[] $solicitudCompras
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CentroCosto extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['codigo', 'nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudCompras()
    {
        return $this->hasMany(\App\Models\SolicitudCompra::class, 'codigo', 'id_centro_costo');
    }
    
}
