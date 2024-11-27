<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class SolicitudesElemento
 *
 * @property $id
 * @property $id_niveles_tres
 * @property $id_solicitudes_compra
 * @property $id_centros_costos
 * @property $cantidad
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property CentrosCosto $centrosCosto
 * @property NivelesTres $nivelesTres
 * @property SolicitudesCompra $solicitudesCompra
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SolicitudesElemento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 20;

    protected $table = 'solicitudes_elementos'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_niveles_tres', 'id_solicitudes_compra', 'id_centros_costos', 'cantidad', 'estado', 'descripcion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centrosCosto()
    {
        return $this->belongsTo(\App\Models\CentrosCosto::class, 'id_centros_costos', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelesTres()
    {
        return $this->belongsTo(\App\Models\NivelesTres::class, 'id_niveles_tres', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesCompra()
    {
        return $this->belongsTo(\App\Models\SolicitudesCompra::class, 'id_solicitudes_compra', 'id');
    }

    public function consolidaciones()
    {
        return $this->hasMany(\App\Models\Consolidacione::class, 'id_solicitud_elemento', 'id');
    }

    public function solicitudesCotizaciones()
    {
        return $this->hasMany(\App\Models\SolicitudesCotizacione::class, 'id_solicitud_elemento', 'id');
    }
    
}
