<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdenesCompraCotizacione
 *
 * @property $id
 * @property $id_ordenes_compras
 * @property $id_solicitudes_cotizaciones
 * @property $id_entradas
 * @property $created_at
 * @property $updated_at
 *
 * @property Entrada $entrada
 * @property OrdenesCompra $ordenesCompra
 * @property SolicitudesCotizacione $solicitudesCotizacione
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class OrdenesCompraCotizacione extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_ordenes_compras', 'id_solicitudes_cotizaciones', 'id_entradas', 'id_consolidaciones_oferta', 'id_solicitud_elemento'];


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
    
}
