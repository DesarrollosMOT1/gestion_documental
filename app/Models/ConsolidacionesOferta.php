<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class ConsolidacionesOferta
 *
 * @property $id
 * @property $cantidad
 * @property $estado
 * @property $id_solicitudes_compras
 * @property $id_solicitud_elemento
 * @property $id_consolidaciones
 * @property $id_solicitudes_ofertas
 * @property $created_at
 * @property $updated_at
 *
 * @property Consolidacione $consolidacione
 * @property SolicitudesCompra $solicitudesCompra
 * @property SolicitudesOferta $solicitudesOferta
 * @property SolicitudesElemento $solicitudesElemento
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ConsolidacionesOferta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cantidad', 'id_solicitudes_compras', 'id_solicitud_elemento', 'id_consolidaciones', 'id_solicitudes_ofertas', 'descripcion'];


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
    public function solicitudesOferta()
    {
        return $this->belongsTo(\App\Models\SolicitudesOferta::class, 'id_solicitudes_ofertas', 'id');
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
        return $this->hasMany(\App\Models\SolicitudesCotizacione::class, 'id_consolidaciones_oferta', 'id');
    }
    
}
