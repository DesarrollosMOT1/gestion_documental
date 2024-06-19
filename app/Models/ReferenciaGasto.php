<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReferenciaGasto
 *
 * @property $codigo
 * @property $nombre
 * @property $linea
 * @property $created_at
 * @property $updated_at
 *
 * @property LineasGasto $lineasGasto
 * @property SolicitudCompra[] $solicitudCompras
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ReferenciaGasto extends Model
{
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo', 'nombre', 'linea'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lineasGasto()
    {
        return $this->belongsTo(\App\Models\LineasGasto::class, 'linea', 'codigo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudCompras()
    {
        return $this->hasMany(\App\Models\SolicitudCompra::class, 'codigo', 'id_referencia_gastos');
    }
    
}
