<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SolicitudesCompra
 *
 * @property $id
 * @property $fecha_solicitud
 * @property $id_users
 * @property $prefijo
 * @property $descripcion
 * @property $estado_solicitud
 * @property $fecha_estado
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @property SolicitudesElemento[] $solicitudesElementos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SolicitudesCompra extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_solicitud', 'id_users', 'prefijo', 'descripcion', 'estado_solicitud', 'fecha_estado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_users', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesCotizaciones()
    {
        return $this->hasMany(\App\Models\SolicitudesCotizacione::class, 'id', 'id_solicitudes_compras');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesElementos()
    {
        return $this->hasMany(\App\Models\SolicitudesElemento::class, 'id', 'id_solicitudes_compra');
    }
    
}
