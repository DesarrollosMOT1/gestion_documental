<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SolicitudOfertaTercero
 *
 * @property $id
 * @property $solicitudes_ofertas_id
 * @property $tercero_id
 * @property $created_at
 * @property $updated_at
 *
 * @property SolicitudesOferta $solicitudesOferta
 * @property Tercero $tercero
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SolicitudOfertaTercero extends Model
{
    
    protected $perPage = 20;

    protected $table = 'solicitud_oferta_tercero'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['solicitudes_ofertas_id', 'tercero_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesOferta()
    {
        return $this->belongsTo(\App\Models\SolicitudesOferta::class, 'solicitudes_ofertas_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tercero()
    {
        return $this->belongsTo(\App\Models\Tercero::class, 'tercero_id', 'nit');
    }
    
}
