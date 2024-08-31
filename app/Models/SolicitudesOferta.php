<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SolicitudesOferta
 *
 * @property $id
 * @property $fecha_solicitud_oferta
 * @property $id_users
 * @property $id_terceros
 * @property $created_at
 * @property $updated_at
 *
 * @property Tercero $tercero
 * @property User $user
 * @property ConsolidacionesOferta[] $consolidacionesOfertas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SolicitudesOferta extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_solicitud_oferta', 'id_users', 'id_terceros'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tercero()
    {
        return $this->belongsTo(\App\Models\Tercero::class, 'id_terceros', 'nit');
    }
    
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
    public function consolidacionesOfertas()
    {
        return $this->hasMany(\App\Models\ConsolidacionesOferta::class, 'id_solicitudes_ofertas', 'id');
    }
    
}
