<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 *
 * @property Tercero $tercero
 * @property SolicitudesCotizacione[] $solicitudesCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cotizacione extends Model
{
    
    protected $perPage = 20;

    protected $table = 'cotizaciones'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_cotizacion', 'nombre', 'valor', 'condiciones_pago', 'descuento', 'id_terceros'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tercero()
    {
        return $this->belongsTo(\App\Models\Tercero::class, 'id_terceros', 'nit');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesCotizaciones()
    {
        return $this->hasMany(\App\Models\SolicitudesCotizacione::class, 'id_cotizaciones', 'id');
    }
    
}
