<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SolicitudCompra
 *
 * @property $id
 * @property $fecha_solicitud
 * @property $nombre
 * @property $area
 * @property $tipo_factura
 * @property $prefijo
 * @property $cantidad
 * @property $nota
 * @property $id_centro_costo
 * @property $id_referencia_gastos
 * @property $created_at
 * @property $updated_at
 *
 * @property CentroCosto $centroCosto
 * @property ReferenciaGasto $referenciaGasto
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SolicitudCompra extends Model
{
    protected $table = 'solicitudes_compras'; 
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_solicitud', 'nombre', 'area', 'tipo_factura', 'prefijo', 'cantidad', 'nota', 'id_centro_costo', 'id_referencia_gastos'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centroCosto()
    {
        return $this->belongsTo(\App\Models\CentrosCosto::class, 'id_centro_costo', 'codigo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referenciaGasto()
    {
        return $this->belongsTo(\App\Models\ReferenciaGasto::class, 'id_referencia_gastos', 'codigo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'nombre', 'id');
    }

    public function solicitudesElemento()
    {
        return $this->hasMany(\App\Models\SolicitudesElemento::class, 'id_solicitudes_compra', 'id');
    }
    
}
