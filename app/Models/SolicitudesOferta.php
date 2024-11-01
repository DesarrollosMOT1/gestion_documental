<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

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
class SolicitudesOferta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_solicitud_oferta', 'id_users'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function terceros()
    {
        return $this->belongsToMany(\App\Models\Tercero::class, 'solicitud_oferta_tercero', 'solicitudes_ofertas_id', 'tercero_id');
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

    public function getTercerosSinCotizacion()
    {
        return $this->terceros()
            ->leftJoin('cotizaciones', 'terceros.id', '=', 'cotizaciones.id_terceros')
            ->leftJoin('solicitudes_cotizaciones', 'cotizaciones.id', '=', 'solicitudes_cotizaciones.id_cotizaciones')
            ->whereNull('solicitudes_cotizaciones.id')
            ->select('terceros.*')
            ->get();
    }
    
}
