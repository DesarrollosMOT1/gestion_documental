<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Consolidacione
 *
 * @property $id
 * @property $user_id
 * @property $id_solicitudes_compras
 * @property $id_solicitud_elemento
 * @property $estado
 * @property $cantidad
 * @property $created_at
 * @property $updated_at
 *
 * @property SolicitudesCompra $solicitudesCompra
 * @property SolicitudesElemento $solicitudesElemento
 * @property User $user
 * @property ElementosConsolidado[] $elementosConsolidados
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Consolidacione extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['agrupacion_id','id_solicitudes_compras', 'id_solicitud_elemento', 'cantidad'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesCompra()
    {
        return $this->belongsTo(\App\Models\SolicitudesCompra::class, 'id_solicitudes_compras', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesElemento()
    {
        return $this->belongsTo(\App\Models\SolicitudesElemento::class, 'id_solicitud_elemento', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementosConsolidados()
    {
        return $this->hasMany(\App\Models\ElementosConsolidado::class, 'id_consolidacion', 'id');
    }
    

    public function agrupacioneConsolidaciones()
    {
        return $this->hasMany(\App\Models\AgrupacionesConsolidacione::class, 'id', 'agrupacion_id');
    }
}
