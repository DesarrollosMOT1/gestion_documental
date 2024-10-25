<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class OrdenesCompraCotizacione
 *
 * @property $id
 * @property $id_ordenes_compras
 * @property $id_solicitudes_cotizaciones
 * @property $id_entradas
 * @property $created_at
 * @property $updated_at
 * @property $id_consolidaciones_oferta
 * @property $id_solicitud_elemento
 * @property $id_cotizaciones_precio
 * @property $id_consolidaciones
 *
 * @property Consolidacione $consolidacione
 * @property ConsolidacionesOferta $consolidacionesOferta
 * @property CotizacionesPrecio $cotizacionesPrecio
 * @property Entrada $entrada
 * @property OrdenesCompra $ordenesCompra
 * @property SolicitudesCotizacione $solicitudesCotizacione
 * @property SolicitudesElemento $solicitudesElemento
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class OrdenesCompraCotizacione extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_ordenes_compras', 'id_solicitudes_cotizaciones', 'id_entradas', 'id_consolidaciones_oferta', 'id_solicitud_elemento', 'id_cotizaciones_precio', 'id_consolidaciones'];


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
    public function consolidacionesOferta()
    {
        return $this->belongsTo(\App\Models\ConsolidacionesOferta::class, 'id_consolidaciones_oferta', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cotizacionesPrecio()
    {
        return $this->belongsTo(\App\Models\CotizacionesPrecio::class, 'id_cotizaciones_precio', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entrada()
    {
        return $this->belongsTo(\App\Models\Entrada::class, 'id_entradas', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ordenesCompra()
    {
        return $this->belongsTo(\App\Models\OrdenesCompra::class, 'id_ordenes_compras', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesCotizacione()
    {
        return $this->belongsTo(\App\Models\SolicitudesCotizacione::class, 'id_solicitudes_cotizaciones', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesElemento()
    {
        return $this->belongsTo(\App\Models\SolicitudesElemento::class, 'id_solicitud_elemento', 'id');
    }
    
}
