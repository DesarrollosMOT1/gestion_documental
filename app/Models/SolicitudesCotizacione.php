<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class SolicitudesCotizacione
 *
 * @property $id
 * @property $id_solicitudes_compras
 * @property $id_cotizaciones
 * @property $cantidad
 * @property $id_impuestos
 * @property $id_solicitud_elemento
 * @property $created_at
 * @property $updated_at
 *
 * @property Cotizacione $cotizacione
 * @property Impuesto $impuesto
 * @property SolicitudesCompra $solicitudesCompra
 * @property SolicitudesElemento $solicitudesElemento
 * @property OrdenesCompraCotizacione[] $ordenesCompraCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SolicitudesCotizacione extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $perPage = 20;

    protected $table = 'solicitudes_cotizaciones'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_consolidaciones_oferta','id_solicitudes_compras', 'id_cotizaciones', 'cantidad', 'descuento', 'id_impuestos', 'id_solicitud_elemento', 'precio'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cotizacione()
    {
        return $this->belongsTo(\App\Models\Cotizacione::class, 'id_cotizaciones', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function impuesto()
    {
        return $this->belongsTo(\App\Models\Impuesto::class, 'id_impuestos', 'id');
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
    public function ordenesCompraCotizaciones()
    {
        return $this->hasMany(\App\Models\OrdenesCompraCotizacione::class, 'id', 'id_solicitudes_cotizaciones');
    }

    public function consolidacionOferta()
    {
        return $this->belongsTo(\App\Models\ConsolidacionesOferta::class, 'id_consolidaciones_oferta', 'id');
    }

    public function cotizacionesPrecios()
    {
        return $this->hasMany(\App\Models\CotizacionesPrecio::class, 'id_solicitudes_cotizaciones', 'id');
    }
    
}
