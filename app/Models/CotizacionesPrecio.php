<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class CotizacionesPrecio
 *
 * @property $id
 * @property $id_solicitudes_cotizaciones
 * @property $id_agrupaciones_consolidaciones
 * @property $descripcion
 * @property $estado
 * @property $created_at
 * @property $updated_at
 * @property $id_consolidaciones
 * @property $estado_jefe
 *
 * @property AgrupacionesConsolidacione $agrupacionesConsolidacione
 * @property Consolidacione $consolidacione
 * @property SolicitudesCotizacione $solicitudesCotizacione
 * @property OrdenesCompraCotizacione[] $ordenesCompraCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CotizacionesPrecio extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 20;

    protected $table = 'cotizaciones_precio'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_solicitudes_cotizaciones', 'id_agrupaciones_consolidaciones', 'descripcion', 'estado', 'id_consolidaciones', 'estado_jefe'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agrupacionesConsolidacione()
    {
        return $this->belongsTo(\App\Models\AgrupacionesConsolidacione::class, 'id_agrupaciones_consolidaciones', 'id');
    }
    
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
    public function solicitudesCotizacione()
    {
        return $this->belongsTo(\App\Models\SolicitudesCotizacione::class, 'id_solicitudes_cotizaciones', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordenesCompraCotizaciones()
    {
        return $this->hasMany(\App\Models\OrdenesCompraCotizacione::class, 'id', 'id_cotizaciones_precio');
    }
    
}
