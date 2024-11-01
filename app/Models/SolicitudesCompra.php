<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class SolicitudesCompra
 *
 * @property $id
 * @property $fecha_solicitud
 * @property $id_users
 * @property $prefijo
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @property SolicitudesElemento[] $solicitudesElementos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SolicitudesCompra extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 20;

    protected $table = 'solicitudes_compras'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_solicitud', 'id_users', 'prefijo', 'descripcion'];


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
    public function solicitudesElemento()
    {
        return $this->hasMany(\App\Models\SolicitudesElemento::class, 'id_solicitudes_compra', 'id');
    }

    public function consolidaciones()
    {
        return $this->hasMany(\App\Models\Consolidacione::class, 'id_solicitudes_compras', 'id');
    }
    
}
