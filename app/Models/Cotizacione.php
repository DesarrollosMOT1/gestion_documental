<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Cotizacione
 *
 * @property $id
 * @property $fecha_cotizacion
 * @property $nombre
 * @property $valor
 * @property $condiciones_pago
 * @property $descuento
 * @property $id_terceros
 * @property $created_at
 * @property $updated_at
 * @property $fecha_inicio_vigencia
 * @property $fecha_fin_vigencia
 *
 * @property Tercero $tercero
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cotizacione extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 2000;

    protected $table = 'cotizaciones'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_cotizacion', 'nombre', 'valor', 'condiciones_pago', 'id_terceros', 'fecha_inicio_vigencia', 'fecha_fin_vigencia', 'id_users'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tercero()
    {
        return $this->belongsTo(\App\Models\Tercero::class, 'id_terceros', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesCotizaciones()
    {
        return $this->hasMany(\App\Models\SolicitudesCotizacione::class, 'id_cotizaciones', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_users', 'id');
    }
    
}
