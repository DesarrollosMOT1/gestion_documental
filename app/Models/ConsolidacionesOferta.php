<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsolidacionesOferta
 *
 * @property $id
 * @property $cantidad
 * @property $estado
 * @property $id_solicitudes_compras
 * @property $id_solicitud_elemento
 * @property $id_consolidaciones
 * @property $created_at
 * @property $updated_at
 *
 * @property Consolidacione $consolidacione
 * @property SolicitudesCompra $solicitudesCompra
 * @property SolicitudesElemento $solicitudesElemento
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ConsolidacionesOferta extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cantidad', 'estado', 'id_solicitudes_compras', 'id_solicitud_elemento', 'id_consolidaciones'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consolidacione()
    {
        return $this->belongsTo(\App\Models\Consolidacione::class, 'id_consolidaciones', 'id');
    }
    
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesCotizaciones()
    {
        return $this->hasMany(\App\Models\SolicitudesCotizacione::class, 'id', 'id_consolidaciones_oferta');
    }
    
}
